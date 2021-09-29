

<div class="mc-drawer mdui-drawer" id="main-drawer">
    <div class="mdui-list">
        <a class="mdui-list-item" href="/~admin/index">
            <i class="mdui-list-item-icon mdui-icon material-icons"></i>
            <div class="mdui-list-item-content">基础设置</div>
        </a>
        <a class="mdui-list-item" href="/~admin/cache">
            <i class="mdui-list-item-icon mdui-icon material-icons"></i>
            <div class="mdui-list-item-content">目录缓存</div>
        </a>
        <a class="mdui-list-item" href="/~admin/show">
            <i class="mdui-list-item-icon mdui-icon material-icons"></i>
            <div class="mdui-list-item-content">显示设置</div>
        </a>
        <a class="mdui-list-item" href="/~admin/SEO">
            <i class="mdui-list-item-icon mdui-icon material-icons">grain</i>
            <div class="mdui-list-item-content">路径SEO设置</div>
        </a>

<!--            <a class="mdui-list-item" href="/~admin/"></a>-->
    </div>
</div>
<!--主体内容-->
<div class="mdui-container-fluid doc-container">
    <?php echo view("/Admin/{$page}"); ?>
</div>


<script>
    <?php if(!empty($msg)): ?>
        // 弹出消息
        mdui.snackbar({position: 'right-top', message: '<?=$msg ?>'});
    <?php endif; ?>
</script>