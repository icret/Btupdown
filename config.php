<?php
/**
 * Author: icret
 * Date: 2019/6/16 23:35
 * link: https://www.545141.com/936.html
 */

$config = array(
    // 网站标题
    'title' => 'BT种子上传 - 开源bt种子免费托管',
    // 网站关键字
    'keywords'=>'bt种子,bt上传,开源,种子托管,磁力转换种子,种子转换磁力',
    // 网站描述
    'description'=>'bt种子上传是一款用于上传bt种子在线管理和托管的程序,程序免费开源可以单独设置下载地址广告,支持磁力种子互转。',
    // 网站公告
    'tips'=>'本网站仅作为演示，请勿上传非法资源。种子上传程序已经开源：<a href="https://github.com/icret/Btupdown/archive/master.zip" target="_blank"><button class="btn btn-mini " type="button">源码下载</button></a>',
    // 网站域名 末尾不加/
    'domain'=>'http://bt.100024.xyz',
    // 存储路径 设置后请勿随意修改，否则会导致加密链接下载失效！ 前后需要加/
    'path'=>'/u/',
    // 允许上传的类型
    'mime'=>array('torrent','txt','zip','7z','rar'),
    // 允许上传的大小 默认300kb 自定义大小请使用字节转换kb转换 http://www.bejson.com/convert/filesize/
    'size'=>307200,
    // * 网址加密秘钥 很重要，一经修改请勿再修改，否则会导致所有链接失效！
    'token'=>'545141.com',
    // 登录与管理密码 默认账号和密码:admin
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
    'version'=>'1.2.1'
);

// 设置html为utf8
header('Content-Type:text/html;charset=utf-8');
//将时区设置为上海时区
ini_set('date.timezone', 'Asia/Shanghai');