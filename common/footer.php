<footer class="container text-muted small"  style="text-align: center">
    <hr>
    <p>
        <?php if(!empty($config['tips'])){echo $config['tips'].'</li></ul>';} ?><br />
        BT种子上传程序 开源简单安全无数据库 | <a data-toggle="modal" data-target="#myModal">登录</a> | <a href="common/tinyfilemanager.php" target="_blank">文件管理</a><br />
        Copyright © 2019 <a href="http://bt.100024.xyz" target="_blank">Btupdown </a>Powered By <a href="https://www.545141.com/936.html" target="_blank">icret</a> version: <?php echo $config['version']?> <a href="https://github.com/icret/Btupdown" target="_blank">Github</a>
    </p>
</footer>
</body>
</html>