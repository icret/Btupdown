<?php
/**
 * Author: adminsitrator
 * Date: 2019/6/23 21:28
 */
require 'common/function.php';checkPwd();?>
<!DOCTYPE html>
<html lang="zh_cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="common/static/zui/css/zui.min.css">
    <link href="common/static/zui/lib/uploader/zui.uploader.min.css" rel="stylesheet">
    <script src="common/static/zui/jquery.min.js"></script>
    <script src="common/static/zui/js/zui.min.js"></script>
    <script src="common/static/zui/lib/uploader/zui.uploader.min.js"></script>
    <script src="common/static/clipboard.min.js"></script>
    <script src="common/static/qrcode.min.js"></script>
    <link rel="shortcut icon" href="common/static/favicon.ico">
</head>
<body>
<div class="container">
        <nav class="navbar navbar-default" role="navigation">
            <div class="container">
                <!-- 导航头部 -->
                <div class="navbar-header">
                    <!-- 移动设备上的导航切换按钮 -->
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse-example">
                        <span class="sr-only">切换导航</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- 品牌名称或logo -->
                    <a class="navbar-brand" href="index.php">首页</a>
                </div>
                <!-- 导航项目 -->
                <div class="collapse navbar-collapse navbar-collapse-example">
                    <!-- 一般导航项目 -->
                    <ul class="nav navbar-nav">
                        <li><a href="toMagnet.php">种子转磁力</a></li>
                        <li><a href="common/tinyfilemanager.php" target="_blank">管理</a></li>
                    </ul>
                </div>
            </div>
        </nav>