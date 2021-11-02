<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OneX 安装程序</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/mdui@1.0.1/dist/css/mdui.min.css">
    <script src="https://cdn.jsdelivr.net/npm/mdui@1.0.1/dist/js/mdui.min.js"></script>

</head>
<body class="mdui-drawer-body-left mdui-appbar-with-toolbar mdui-loaded mdui-theme-layout-dark mdui-theme-primary-cyan mdui-theme-accent-cyan">
<div class="mdui-container">
    <div class="mdui-typo">
        <h1>程序安装 <small><?=$title ?></small></h1>
    </div>
    <?php
    switch ($tab):  case 1: ?>
        <form action="?tab=2" method="post">
            <div class="mdui-textfield mdui-textfield-not-empty">
                <h4>数据库地址</h4>
                <input class="mdui-textfield-input" name="mysql_host" type="text" value="localhost" required>
            </div>
            <div class="mdui-textfield mdui-textfield-not-empty">
                <h4>数据库端口</h4>
                <input class="mdui-textfield-input" name="mysql_interface" type="text" value="3306" required>
            </div>
            <div class="mdui-textfield mdui-textfield-not-empty">
                <h4>数据库用户名</h4>
                <input class="mdui-textfield-input" name="mysql_user" type="text" value="root" required>
            </div>
            <div class="mdui-textfield mdui-textfield-not-empty">
                <h4>数据库密码</h4>
                <input class="mdui-textfield-input" name="mysql_password" type="password" value="" required>
            </div>
            <div class="mdui-textfield mdui-textfield-not-empty">
                <h4>数据库表格</h4>
                <input class="mdui-textfield-input" name="mysql_tabel" type="text" value="onex" required>
            </div>
            <button class="mdui-btn mdui-color-theme-accent mdui-ripple mdui-float-right" type="submit">
                <i class="mdui-icon material-icons">fast_forward</i> 下一步
            </button>
        </form>
    <?php break;    case 2:?>
        <form action="?tab=3" method="post">
            <div class="mdui-textfield mdui-textfield-not-empty">
                <h4>网站标题</h4>
                <input class="mdui-textfield-input" name="site_name" type="text" value="OneX" required>
            </div>
            <div class="mdui-textfield mdui-textfield-not-empty">
                <h4>OneDrive起始目录(默认为根目录) <small>例：仅共享public目录 /public</small></h4>
                <input class="mdui-textfield-input" name="onedrive_root" type="text" value="/" required>
            </div>
            <div class="mdui-textfield mdui-textfield-not-empty">
                <h4>缓存过期时间(秒)</h4>
                <input class="mdui-textfield-input" name="cache_expire_time" type="text" value="3600" required>
            </div>
             <div class="mdui-textfield mdui-textfield-not-empty">
                <h4>后台账号</h4>
                <input class="mdui-textfield-input" name="username" type="text" value="admin" required>
            </div>
            <div class="mdui-textfield mdui-textfield-not-empty">
                <h4>后台密码</h4>
                <input class="mdui-textfield-input" name="password" type="password" value="" required>
            </div>
            <button class="mdui-btn mdui-color-theme-accent mdui-ripple mdui-float-right" type="submit">
                <i class="mdui-icon material-icons">fast_forward</i> 下一步
            </button>
        </form>
    <?php break;    case 3:?>
        <form action="?tab=4" method="post">
            <div class="mdui-textfield mdui-textfield-not-empty">
                <h4>client_id <small></small></h4>
                <input class="mdui-textfield-input" name="client_id" type="text">
            </div>
            <div class="mdui-textfield mdui-textfield-not-empty">
                <h4>client_secret</h4>
                <input class="mdui-textfield-input" name="client_secret" type="text">
            </div>
            <div class="mdui-textfield mdui-textfield-not-empty">
                <h4>client_id</h4>
                <input class="mdui-textfield-input" name="client_id" type="text">
            </div>


        </form>
    <?php break;    case 4:?>


    <?php break;    endswitch; ?>
</div>
</body>
</html>