<?php require 'common/function.php';?>
<!DOCTYPE html>
<html lang="zh_cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $config['title'];?></title>
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
    <div class="col-md-12 text-muted small" style="margin-top: 7%;margin-bottom: 2%">
        <center>
            <a href="index.php" class="hidden-xs"><div id="qrcode"></div>使用手机扫码上传</a>
        </center>
    </div>
    <div class="col-md-12">
        <div id="upID" class="uploader" style="text-align: right;margin:15px">
            <div class="file-list" style="min-height:140px;border-style:dashed;" data-drag-placeholder="选择文件/将文件拖拽至此处 支持上传 <?php foreach ($config['mime'] as $value){echo $value.',';}?> 不要超过<?php echo $config['size']/1024 . "KB"?>"></div>
            <div class="uploader-message text-center">
                <div class="content"></div>
                <button type="button" class="close">×</button>
            </div>
            <button type="button" class="btn btn-primary uploader-btn-browse"><i class="icon icon-cloud-upload"></i> 选择文件</button>
        </div>
    </div>
    <div class="col-md-12">
        <ul class="nav nav-tabs">
            <li class="active"><a data-tab href="#tabContent1">加密链接</a></li>
            <li><a data-tab href="#tabContent2">直接下载</a></li>
        </ul>
        <div class="tab-content" style="text-align: right;margin:5px">
            <div class="tab-pane active" id="tabContent1">
                <textarea class="form-control" style="text-align: center;min-height: 100px;" id="enLink" readonly=""></textarea>
                <button id="btnenLink" class="btn" data-clipboard-action="copy" data-clipboard-target="#enLink" data-loading-text="已经复制链接..." style="margin-top:10px;"><i class="icon icon-copy"></i> 复制</button>

            </div>
            <div class="tab-pane" id="tabContent2">
                <textarea class="form-control" style="text-align: center;min-height: 100px;" id="link" readonly></textarea>
                <button id="btnLink" class="btn" data-clipboard-action="copy" data-clipboard-target="#link" data-loading-text="已经复制链接..." style="margin-top:10px;"><i class="icon icon-copy"></i> 复制</button>
            </div>
        </div>
    </div>
</div>
<!-- 登录 -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
                <h4 class="modal-title">登录之后才可以上传</h4>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form class="form-inline" action="index.php" method="post">
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="请输入登录密码">
                        </div>
                        <button type="submit" class="btn btn-primary">登录</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // 登录js
    $('#myModal').modal({
        show:<?php echo checkPwd();?>
    })
</script>
<script>
    $('#upID').uploader({
        // 当选择文件后立即自动进行上传操作
        autoUpload: true,
        // 文件上传提交地址
        url: 'upload.php',
        // 最大支持的上传文件
        max_file_size: <?php echo $config['size']?>,
        // 上传格式过滤
        filters: {
            mime_types: [{
                title: '文件',
                extensions:'<?php foreach ($config['mime'] as $value){echo $value.',';}?>',
            }],
            prevent_duplicates: true
        },
        // 点击框上传
        browseByClickList:true,
        // 一次性最多上传
        limitFilesCount:30,
        responseHandler: function (responseObject, file) {
            // 当服务器返回的文本内容包含 `'success'` 文件上传成功
            if (responseObject.response.indexOf('success')) {
                console.log(responseObject.response);
                var obj = JSON.parse(responseObject.response); //由JSON字符串转换为JSON对象
                var enLink = document.getElementById("enLink");
                enLink.innerHTML += obj.enLink + "\n";
                var link = document.getElementById("link");
                link.innerHTML +=  obj.link + "\n";
            } else {
                return '上传失败。服务器返回了一个错误：' + responseObject.response;
            }
        }
    });
    // 按钮状态
    $('#btnenLink').on('click', function() {
        var $btn = $(this);
        $btn.button('loading');
        setTimeout(function() {
            $btn.button('reset');
        }, 2000);
    });
    $('#btnLink').on('click', function() {
        var $btn = $(this);
        $btn.button('loading');
        setTimeout(function() {
            $btn.button('reset');
        }, 2000);
    });
    // copy
    var clipboard = new ClipboardJS('#btnenLink');
    clipboard.on('success', function(e) {
        console.info('复制成功:', e.text);
        e.clearSelection();
    });
    var clipboard = new ClipboardJS('#btnLink');
    clipboard.on('success', function(e) {
        console.info('复制成功:', e.text);
        e.clearSelection();
    });
    clipboard.on('error', function(e) {
        console.error('Action:', e.action);
        console.error('Trigger:', e.trigger);
    });
    // 二维码设置参数方式
    var qrcode = new QRCode(document.getElementById('qrcode'), {
        text: window.location.href,
        width: 168,
        height: 168,
        colorDark : '#000000',
        colorLight : '#ffffff',
        correctLevel : QRCode.CorrectLevel.H
    });
</script>
<footer class="container text-muted small"  style="text-align: center">
    <hr>
    <p>
        <?php if(!empty($config['tips'])){echo $config['tips'].'</li></ul>';} ?><br />
        BT种子上传程序 开源简单安全无数据库 | <a data-toggle="modal" data-target="#myModal">登录</a> | <a href="common/tinyfilemanager.php" target="_blank">文件管理</a><br />
        Copyright © 2019 <a href="http://bt.100024.xyz" target="_blank">Btupdown </a>Powered By <a href="https://www.545141.com/902.html" target="_blank">icret</a> version: <?php echo $config['version']?> <a href="https://github.com/icret/Btupdown" target="_blank">Github</a>
    </p>
</footer>
</body>
</html>