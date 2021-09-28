<div class="mdui-container-fluid">
    <div class="mdui-typo">
        <h1>基本设置</h1>
    </div>
    <form action="" method="post">
        <div class="mdui-textfield">
            <h4>网站名称</h4>
            <input class="mdui-textfield-input" type="text" name="site_name" value="<?=$site_info['site_name'] ?>"/>
        </div>
        <div class="mdui-textfield">
            <h4>OneDrive起始目录(空为根目录)<small>例：仅共享public目录 /public</small></h4>
            <input class="mdui-textfield-input" type="text" name="onedrive_root" value="<?=$site_info['onedrive_root'];?>"/>
        </div>
        <div class="mdui-textfield">
            <h4>缓存过期时间(秒)</h4>
            <input class="mdui-textfield-input" type="text" name="cache_expire_time" value="<?=$site_info['cache_expire_time'];?>"/>
        </div>
        <div class="mdui-textfield">
            <h4>修改后台密码（不改请留空</h4>
            <input class="mdui-textfield-input" type="password" name="password" value=""/>
        </div>

        <button type="submit" class="mdui-btn mdui-color-theme-accent mdui-ripple mdui-float-right">
            <i class="mdui-icon material-icons">save</i> 保存
        </button>
    </form>
</div>
