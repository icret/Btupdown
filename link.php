<?php
require 'config.php';
require 'common/encrypt.php';

// 以网页展现
if (isset($_REQUEST['hash']))
{
    $title = '下载种子ID:'.htmlspecialchars($_REQUEST['hash']);
    $id = htmlspecialchars($_REQUEST['hash']);
}else
{
    $title = '种子下载';
}

$downLink = $config['domain'].encrypt($id, 'D', $config['token']);
$fileName = str_replace('/','',strrchr($downLink,'/'));

// 直链下载
if (strstr($_SERVER["QUERY_STRING"],'down=')){
    if (isset($_REQUEST['down']) && $config['directLink'])
    {
        $id = htmlspecialchars($_REQUEST['down']);
        header('Content-type: application/octet-stream');
        header('Content-Disposition: attachment; filename=download.*');
        header('location:'. $config['domain'].encrypt($id, 'D', $config['token']));
    }else
    {
        header('location:'. $config['domain'].'link.php?hash='.htmlspecialchars($_REQUEST['down']));
    }
}

?>
<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $title?></title>
    <link rel="stylesheet" href="common/static/zui/css/zui.min.css">
</head>
<body>
<div class="container-fixed-md" style="text-align: center">
    <?php
    // 顶部广告
    foreach ($config['adTop'] as $link=>$img)
    {
        echo '<a href="'.$link.'" target="_blank"><img src="'.$img.'" width="100%" alt="adTop"></a>';
    }?>
    <div class="panel">
        <div class="panel-heading">
            <h5>下载ID：<?php echo $id.' 下载次数:'.mt_rand(0,9999);?></h5>
        </div>
        <div class="panel-body">
            <a href="<?php echo $downLink;?>" download="<?php echo $fileName;?>"><button class="btn " type="button"><i class="icon icon-download-alt"> </i>点击下载</button></a>
        </div>
    </div>
    <?php
    // 底部广告
    foreach ($config['adBot'] as $link=>$img)
    {
        echo '<a href="'.$link.'" target="_blank"><img src="'.$img.'" width="100%" alt="adBot"></a>';
    }?>
</div>

</body>
<script src="common/static/zui/jquery.min.js"></script>
<script src="common/static/zui/js/zui.min.js"></script>
<script>
    function downloadFile(fileName, content){
        var aLink = document.createElement('a');
        var blob = new Blob([content]);
        var evt = document.createEvent("HTMLEvents");
        evt.initEvent("click", false, false);//initEvent 不加后两个参数在FF下会报错
        aLink.download = fileName;
        aLink.href = URL.createObjectURL(blob);
        aLink.dispatchEvent(evt);
    }
</script>
</html>