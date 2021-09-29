<div class="mdui-container-fluid">
    <div class="mdui-typo">
        <h1>显示设置</h1>
    </div>
    <form action="" method="post">
        <div class="mdui-textfield">
            <label for="show_image" class="mdui-textfield-label">图片(image)</label>
            <input id="show_image" name="show_image" class="mdui-textfield-input" type="text" value="<?=$site_info['show_image'] ?>"/>
        </div>
        <div class="mdui-textfield">
            <label for="show_video" class="mdui-textfield-label">视频(video)</label>
            <input id="show_video" name="show_video" class="mdui-textfield-input" type="text" value="<?=$site_info['show_video'] ?>"/>
        </div>
        <div class="mdui-textfield">
            <label for="show_audio" class="mdui-textfield-label">音频播放(audio)</label>
            <input id="show_audio" name="show_audio" class="mdui-textfield-input" type="text" value="<?=$site_info['show_audio'] ?>"/>
        </div>
        <div class="mdui-textfield">
            <label for="show_code" class="mdui-textfield-label">文本/代码(code)</label>
            <input id="show_code" name="show_code" class="mdui-textfield-input" type="text" value="<?=$site_info['show_code'] ?>"/>
        </div>
        <div class="mdui-textfield">
            <label for="show_code2" class="mdui-textfield-label">在线代码(code2)/可在线引用</label>
            <input id="show_code2" name="show_code2" class="mdui-textfield-input" type="text" value="<?=$site_info['show_code2'] ?>"/>
        </div>
         <div class="mdui-textfield">
            <label for="show_doc" class="mdui-textfield-label">文档(doc)</label>
            <input id="show_doc" name="show_doc" class="mdui-textfield-input" type="text" value="<?=$site_info['show_doc'] ?>"/>
        </div>


        <button type="submit" class="mdui-btn mdui-color-theme-accent mdui-ripple mdui-float-right">
            <i class="mdui-icon material-icons">save</i> 保存
        </button>
    </form>
</div>