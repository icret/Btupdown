<?php
require 'config.php';

// 校验登录
function checkPwd() {
    global $config;
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