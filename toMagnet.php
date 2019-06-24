<?php
header("content-type:text/html;charset=utf-8");

if (isset($_FILES['file']))
{
    echo '<title>种子转换成磁力链接</title>';
}elseif (isset($_POST['file1']))
{
    echo '<title>磁力转换成种子</title>';
}else{
    echo '<title>种子转换成磁力链接</title>';
}
require 'common/header.php';

/*
 * 磁力转换成种子
 */
if (isset($_POST['file1']))
{
// 获取磁力链接
    $link = $_POST['file1'];
// urls are encoded, let's reverse that
    $link = urldecode($link);
// first regex searches for 'btih:' and matches subsequent
// word characters ([a-zA-Z0-9_])
// match(es) are captured as an array to $matchBtih
    preg_match('/(?<=btih:)\w+/', $link, $matchBtih);
    echo '<a class="btn btn-primary" href="http://btcache.me/torrent/'.$matchBtih[0].'" target="_blank"><i class="icon icon-download-alt"></i> 下载种子</a>';

# http://btcache.me/torrent/17CC8E34EEEFAB3261579B62C86411059A2CEA7F

    // 载入底部
    echo '<div class="col-md-12">';
    require 'common/footer.php';
    echo '</div>';
    exit;
}


/*
 * 文件上传
 */
if (empty($_FILES))
{
    echo '<title>种子转换成磁力链接</title>';
    echo '
<div class="col-md-12">
<h1>#1 种子转磁力链接</h1>
<p>选择种子文件，点击 上传 按钮</p>
    <form class="form-inline" action="toMagnet.php" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <input type="file" name="file" class="form-control" id="exampleInputInviteCode3" placeholder="选择要转换成磁力的种子">
      </div>
      <button type="submit" class="btn btn-primary">上传</button>
    </form>
<h1>#2 磁力链接转种子</h1>
<p>将磁力链接复制到文本框里，可以不带 magnet://</p>
<form class="form-inline" action="toMagnet.php" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <input type="text" name="file1" class="form-control" id="exampleInputInviteCode3" placeholder="选择要转换成种子的磁力">
      </div>
      <button type="submit" class="btn btn-primary">上传</button>
 </form>
</div>
    ';
    // 引用公共底部
    echo '<div class="col-md-12">';
    require 'common/footer.php';
    echo '</div>';
    exit;
}

/*
 * 种子处理
 */

require 'common/BEncode.php';
require 'common/BDecode.php';

$path = @htmlspecialchars($_FILES['file']['tmp_name']);//此处填写种子的地址
$torrent = @file_get_contents($path);
$desc = BDecode($torrent);
$info = $desc['info'];
$arrayNum = count($desc['info']['files']); // 计算包含文件数量

// 磁力链接
$hash = strtoupper(sha1( BEncode($info) ));
$magnet = sprintf('magnet:?xt=urn:btih:%s&dn=%s', $hash, $info['name']);
// 截取磁力
$magnet = @substr($magnet,0,strrpos($magnet,"&dn="));

echo '
<div id="qrcode" style="margin-bottom: 20px;"></div>
<p>可以用支持二维码扫描的app进行在线下载或播放</p>
<div class="input-group col-md-8" style="margin-bottom: 20px;">
    <span class="input-group-addon fix-border">文件名：</span>
    <input type="text" class="form-control" value="'.$desc['info']['name'].'">
</div>
<div class="input-group col-md-8" style="margin-bottom: 20px;">
    <span class="input-group-addon fix-border">HASH值：</span>
    <input type="text" class="form-control" value="'.$hash.'">
</div>
<div class="input-group col-md-8" style="margin-bottom: 20px;">
    <span class="input-group-addon fix-border">磁力链接：</span>
    <input type="text" class="form-control" value="'.$magnet.'">
</div>
';

// 计算文件大小
$arrayNum = count($desc['info']['files']);
$fileSize = 0;
for ($i=0;$i<$arrayNum;$i++)
{
    $fileSize+=$desc['info']['files'][$i]['length'];
}

echo '<h3>文件信息:</h3>';
echo '<p>创建者：'.$desc['created by'].'</p>';
echo '<p>创建时间：'.date("Y-m-d H:i:s",$desc['creation date']).'</p>';
echo '<p>文件大小：'.setSize($fileSize).'</p>';
echo '<p>文件数量：'.$arrayNum.'</p>';

// 获取文件列表
echo '
<table class="table table-striped  table-bordered table-hover table-auto table-responsive">
      <thead>
        <tr>
            <th class="success">文件列表:</th>
        </tr>
      </thead>';

// 循环迭代出所有文件
for ($i=0;$i<$arrayNum;$i++)
{
    echo '<tr><td>'.$desc['info']['files'][$i]['path'][0].'</td></tr>';
}
echo '</table>';

// 获取tracker 并列出
echo '<div class="col-md-8">
<p><button type="button" class="btn" data-toggle="collapse" data-target="#collapseExample">Tracker 列表</button></p>
<div class="collapse" id="collapseExample">
    <div class="bg-default with-padding">';
// 获取Tracker
if (!empty($desc['announce'])){
    $num = count($desc['announce']);
    for ($i=0;$i<$num;$i++)
    {
        echo '<p class="text-success">'.$desc['announce'].'</p>';
    }
}else{
    $desc['announce'] = null;
}
// 获取备用 Tracker
if (!empty($desc['announce-list'])){
    $num = count($desc['announce-list']);
    for ($i=0;$i<$num;$i++)
    {
        echo '<p class="text-success">'.$desc['announce-list'][$i][0].'</p>';
    }
}else{
    $desc['announce-list'] = null;
}
echo '    
    </div>
</div>';

// 引用公共底部
echo '<div class="col-md-12">';
require 'common/footer.php';
echo '</div>';
?>
<script>
    // 二维码设置参数方式
    var qrcode = new QRCode(document.getElementById('qrcode'), {
        text: "<?php echo $magnet;?>",
        width: 260,
        height: 260,
        colorDark : '#000000',
        colorLight : '#ffffff',
        correctLevel : QRCode.CorrectLevel.H
    });
    // 登录js
    $('#myModal').modal({
        show:<?php echo checkPwd();?>
    })
</script>
