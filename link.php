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
        header('location:'. $config['domain'].'/link.php?hash='.htmlspecialchars($_REQUEST['down']));
    }
}

?>
<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title?></title>
    <link rel="stylesheet" href="common/static/zui/css/zui.min.css">
</head>
<body>
<div class="container" style="text-align: center">
    <div style="position:fixed; left:35%; margin-left:-30%; top:2%; margin-top:80px;" class="hidden-xs text-muted small">
        <a href="index.php" target="_blank"><div id="qrcode"></div>手机扫码下载</a>
    </div>

    <?php
    // 顶部广告
    foreach ($config['adTop'] as $link=>$img)
    {
        echo '<a href="'.$link.'" target="_blank"><img src="'.$img.'" width="100%" alt="adTop"></a>';
    }?>
    <div class="panel">
        <div class="panel-heading">
            <h5 class="text-nowrap">下载ID：<?php echo $id.' 下载次数:'.mt_rand(0,9999);?></h5>
            <h5 class="visible-xs"><?php echo '下载次数:'.mt_rand(0,9999);?></h5>
        </div>
        <div class="panel-body">
            <a href="<?php echo $downLink;?>" download="<?php echo $fileName;?>"><button class="btn" type="button"><i class="icon icon-download-alt"> </i>点击下载</button></a>
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
<script src="common/static/qrcode.min.js"></script>
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
    // 二维码设置参数方式
    var qrcode = new QRCode(document.getElementById('qrcode'), {
        text: window.location.href,
        width: 168,
        height: 168,
        colorDark : '#000000',
        colorLight : '#ffffff',
        correctLevel : QRCode.CorrectLevel.H
    });
    // 悬浮
</script>

<footer class="container text-muted small"  style="text-align: center">
    <hr>
    <p>
        <?php if(!empty($config['tips'])){echo $config['tips'].'</li></ul>';} ?><br />
        Copyright © 2019 <a href="http://bt.100024.xyz" target="_blank">Btupdown </a>Powered By <a href="https://www.545141.com/902.html" target="_blank">icret</a> version: <?php echo $config['version']?> <a href="https://github.com/icret/Btupdown" target="_blank">Github</a>
    </p>
</footer>
</html>