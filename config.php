<?php
/**
 * Author: icret
 * Date: 2019/6/16 23:35
 */

$config = array(
    // 网站标题
    'title' => 'BT种子上传 - 种子免费托管',
    // 网站关键字
    'keywords'=>'bt种子,bt上传,开源,种子托管,免费',
    // 网站描述
    'description'=>'bt种子上传是一款用于上传bt种子在线管理和托管的程序,程序免费开源可以单独设置下载地址广告。',
    // 网站公告
    'tips'=>'本网站仅作为演示，不对内容负任何责任!',
    // 网站域名 末尾不加/
    'domain'=>'https://bt.100024.xyz',
    // 存储路径 设置后请勿随意修改，否则会导致加密链接下载失效！ 前后需要加/
    'path'=>'/u/',
    // 允许上传的类型
    'mime'=>array('torrent','txt','zip','7z','rar'),
    // 允许上传的大小 默认200kb
    'size'=>204800,
    // * 网址加密秘钥 很重要，一经修改请勿再修改，否则会导致所有链接失效！
    'token'=>'545141.com',
    // 登录与管理密码
    'password'=>'admin',
    // 是否允许直接下载 以link.php?down=** 进行直接下载 关闭后直链打开页面后直接下载 不再单独显示下载页面 true开启 false关闭
    'directLink'=> false,
    // 是否开启登录才能上传 true开启 false关闭
    'login'=>false,
    // * 是否开启管理 true开启 false关闭
    'manager'=>true,
    // 顶部广告 第一行写点击链接，第二行写图片链接,如果不是最后一行，请务必末尾加','
    // 广告如果有重复链接的，可以在末尾加一些修饰符 ?=*
    'adTop'=>[
        'https://img.545141.com?1'=>'common/static/ad.jpg'
    ],
    // 底部广告 第一行写点击链接，第二行写图片链接,如果不是最后一行，请务必末尾加','
    'adBot'=>[
        'https://img.545141.com'=>'common/static/ad.jpg',
    ],
    'version'=>'1.2'
);

// 设置html为utf8
header('Content-Type:text/html;charset=utf-8');
//将时区设置为上海时区
ini_set('date.timezone', 'Asia/Shanghai');