<?php
class Upload{
    private $path;   //文件上传目录
    private $max_size; //上传文件大小限制
    private $errno;  //错误信息号
    private $mime; //允许上传的文件类型

    /**
     * 构造函数,
     * @access public
     * @param $path string 上传的路径
     */
    public function __construct($path,$mime,$max_size){  //UPLOAD_PATH是自定义的文件的物理路径。
        $this->path = $path;
        $this->mime = $mime;
        $this->max_size = $max_size;
    }

    /**
     * 文件上传的方法，分目录存放文件
     * @access public
     * @param $file array 包含上传文件信息的数组
     * @return mixed 成功返回上传的文件名，失败返回false
     */
    public function up($file){
        //判断是否从浏览器端成功上传到服务器端
        if ($file['error'] == 0) {
            # 上传到临时文件夹成功,对临时文件进行处理
            //上传类型判断
            if (!in_array(pathinfo($file['name'])['extension'], $this->mime)) {
                # 类型不对
                $this->errno = -1;
                return false;
            }

            //判断文件大小
            if ($file['size'] > $this->max_size) {
                # 大小超出配置文件的中的上传限制
                $this->errno = -2;
                return false;
            }

            //获取存放上传文件的目录
            $sub_path = date('Y').'/'.date('m').'/'; // 相对路径

            $sub_path1 = __DIR__.$this->path.$sub_path; // 绝对路径
            if (!is_dir($sub_path1))
            {
                @mkdir($sub_path1,0755,true);
            }

            //文件重命名,由当前日期 + 随机数 + 后缀名
            $file_name = date('dHis').mt_rand(999,9999).strrchr($file['name'], '.');  //strrchr表示从右截取文件后缀名。
            //准备就绪了，开始上传
            if (move_uploaded_file($file['tmp_name'], $sub_path1 . $file_name)) {
                # 移动成功
                return $this->path . $sub_path . $file_name;
            } else {
                # 移动失败
                $this->errno = -3;
                return false;
            }

        } else {
            # 上传到临时文件夹失败，根据其错误号设置错误号
            $this->errno = $file['error'];
            return false;
        }

    }

    /**
     * 获取错误信息,根据错误号获取相应的错误提示
     * @access public
     * @return string 返回错误信息
     */
    public function error(){
        switch ($this->errno) {
            case -1:
                return '请检查你的文件类型，目前支持的类型有'.implode(',', $this->mime);
                break;
            case -2:
                return '文件超出系统规定的大小，最大不能超过'. $this->max_size;
                break;
            case -3:
                return '文件移动失败';
                break;
            case 1:
                return '上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值,其大小为'.ini_get('upload_max_filesize');
                break;
            case 2:
                return '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值,其大小为' . $_POST['MAX_FILE_SIZE'];
                break;
            case 3:
                return '文件只有部分被上传';
                break;
            case 4:
                return '没有文件被上传';
                break;
            case 5:
                return '非法上传';
                break;
            case 6:
                return '找不到临时文件夹';
                break;
            case 7:
                return '文件写入临时文件夹失败';
                break;
            default:
                return '未知错误,灵异事件';
                break;
        }
    }
}

//------------*-----------//
require 'common/function.php';
require 'common/encrypt.php';
if (checkPwd()=='true'){
    $reJson = array(
        "result" => 'success',
        "enLink"=>'请登录后再上传!',
    );
    exit(json_encode($reJson,JSON_UNESCAPED_UNICODE));
}

$upload = new upload($config['path'],$config['mime'],$config['size']);
if($filePath = $upload->up($_FILES['file'])){
    $reJson = array(
        "result" => 'success',
        "enLink"=>$config['domain'].'/link.php?hash='.encrypt($filePath, 'E',$config['token']),
        "link" => $config['domain'].$filePath
    );
    echo json_encode($reJson,JSON_UNESCAPED_UNICODE);
}else
{
    $reJson = array(
        'result'=>'fail',
        'error'=>$upload->error()
    );
    echo json_encode($reJson,JSON_UNESCAPED_UNICODE);
}