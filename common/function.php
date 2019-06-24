<?php
require 'config.php';

// 获取允许上传的后缀以','隔开，并删除最后一个','
function getMime()
{
    global $config;
    $mime='';
    for ($i=0;$i<count($config['mime']);$i++)
    {
        $mime .= $config['mime'][$i].',';
    }
    return rtrim($mime,',');
}

// 校验登录
function checkPwd() {
    global $config;
    // 如果未设置登录上传
    if ($config['login']==false)
    {
        return'false';
    }
    // 如果设置了登录上传
    if (!empty( $_POST['password'] ) ) {
        if ( $_POST['password'] == $config['password'] ) {
            $psw = $_POST['password'];
            setcookie('admin',$psw);
            return 'false';
        }else{
            return 'true';
        }
    } elseif (!empty( $_COOKIE['admin'] ) ) {
        if ( $_COOKIE['admin'] == $config['password'] ) {
            return 'false';
        }
    } else {
        return 'true';
    }
}

// 四舍五入求大小
function setSize($file)
{
    switch (is_numeric($file))
    {
        case $file>1073741824:
            $file = $file / 1024 / 1024 / 1024;
            return round($file) . ' GB';
            break;
        case $file>1048576:
            $file = $file / 1024 / 1024;
            return round($file) . ' MB';
            break;
        case $file>1024:
            return round($file) . ' KB';
            break;
        default:
            return round($file) . ' 字节';
    }
}