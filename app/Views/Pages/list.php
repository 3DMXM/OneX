<?php 

function human_filesize($size, $precision = 1) {
    for($i = 0; ($size / 1024) > 1; $i++, $size /= 1024) {}
    return round($size, $precision).(['B','KB','MB','GB','TB','PB','EB','ZB','YB'][$i]);
}
function file_ico($item){
    $ext = strtolower(pathinfo($item['file_name'], PATHINFO_EXTENSION));
    if(in_array($ext,['bmp','jpg','jpeg','png','gif'])){
        return "image";
    }
    if(in_array($ext,['mp4','mkv','webm','avi','mpg', 'mpeg', 'rm', 'rmvb', 'mov', 'wmv', 'mkv', 'asf'])){
        return "ondemand_video";
    }
    if(in_array($ext,['ogg','mp3','wav','flac'])){
        return "audiotrack";
    }
    return "insert_drive_file";
}
function get_absolute_path($path) {
    $path = str_replace(array('/', '\\', '//'), '/', $path);
    $parts = array_filter(explode('/', $path), 'strlen');
    $absolutes = array();
    foreach ($parts as $part) {
        if ('.' == $part) continue;
        if ('..' == $part) {
            array_pop($absolutes);
        } else {
            $absolutes[] = $part;
        }
    }
    return str_replace('//','/','/'.implode('/', $absolutes).'/');
}
?>

    <!-- 文件列表 -->
    <div class="nexmoe-item">
        <div class="mdui-row">
            <ul class="mdui-list">
                <li class="mdui-list-item th">
                    <div class="mdui-col-xs-12 mdui-col-sm-6">文件名 <i class="mdui-icon material-icons icon-sort">expand_more</i></div>
                    <div class="mdui-col-sm-2 mdui-text-right">修改时间 <i class="mdui-icon material-icons icon-sort">expand_more</i></div>
                    <div class="mdui-col-sm-2 mdui-text-right">大小 <i class="mdui-icon material-icons icon-sort">expand_more</i></div>
                    <div class="mdui-col-sm-2 mdui-text-right">操作 <i class="mdui-icon material-icons icon-sort">expand_more</i></div>
                

                </li>
                <?php if($path != '/'):
                    $parent = explode("/", $path);
                    $parent = array_filter($parent);
                    array_pop($parent);
                    $parent = implode("/", $parent);
                    ?>
                <li class="mdui-list-item mdui-ripple">
                    <a href="/<?= $parent ?>">
                    <div class="mdui-col-xs-12 mdui-col-sm-7">
                        <i class="mdui-icon material-icons">arrow_upward</i>
                        ..
                    </div>
                    <div class="mdui-col-sm-3 mdui-text-right"></div>
                    <div class="mdui-col-sm-2 mdui-text-right"></div>
                    </a>
                </li> 
                <?php endif;?>
                
                <?php 
                foreach((array)$files as $item):
                    $root = $site_info['onedrive_root'];
                    $file_parent = substr($item['file_parent'], strlen($root));

                    ?>
                    <?php if($item['file_type'] == "folder"):?>

                    <li class="mdui-list-item mdui-ripple">              
                        <a href="<?="{$file_parent}{$item['file_name']}" ?>">
                            <div class="mdui-col-xs-12 mdui-col-sm-6 mdui-text-truncate">
                                <i class="mdui-icon material-icons">folder_open</i>
                                <span><?=$item['file_name'] ?></span>
                            </div>
                            <div class="mdui-col-sm-2 mdui-text-right"><?php echo date("Y-m-d H:i:s", $item['file_time']);?></div>
                            <div class="mdui-col-sm-2 mdui-text-right"><?php echo human_filesize($item['file_size']);?></div>
                        </a>
                    </li>
                    <?php else:?>
                    <li class="mdui-list-item file mdui-ripple">
                        <a href="<?="{$file_parent}{$item['file_name']}" ?>" target="_blank">
                            <div class="mdui-col-xs-12 mdui-col-sm-6 mdui-text-truncate">
                                <i class="mdui-icon material-icons"><?php echo file_ico($item);?></i>
                                <span><?=$item['file_name'] ?></span>
                            </div>
                            <div class="mdui-col-sm-2 mdui-text-right"><?php echo date("Y-m-d H:i:s", $item['file_time']);?></div>
                            <div class="mdui-col-sm-2 mdui-text-right"><?php echo human_filesize($item['file_size']);?></div>
                            <div class="mdui-col-sm-2 mdui-text-right">
                                <i class="mdui-icon material-icons icon-sort">file_download</i>
                            </div>
                        </a>
                    </li>
                    <?php endif;?>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
    <?php if($readme): ?>
        <div class="nexmoe-item">
            <div class="mdui-typo" style="padding: 20px;">
                <div class="mdui-chip">
                <span class="mdui-chip-icon"><i class="mdui-icon material-icons">face</i></span>
                <span class="mdui-chip-title">README.md</span>
                </div>
                <div class="show-readme" id="show_readme">
                    <textarea name="show_readme" style="display:none;"><?=$readme ?></textarea>
                </div>		
            </div>
        </div>
        <!-- editor.md引用 -->
        <!-- https://pan.aoe.top/scripts/lib/editor.md/editormd.js -->
        <script src="https://code.aoe.top/libs/jquery/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://code.aoe.top/libs/editor.md/css/editormd.min.css" >
        <script type="text/javascript" src="https://code.aoe.top/libs/editor.md/lib/marked.min.js"></script>
        <script type="text/javascript" src="https://code.aoe.top/libs/editor.md/lib/raphael.min.js"></script>
        <script type="text/javascript" src="https://code.aoe.top/libs/editor.md/lib/prettify.min.js"></script>
        <script type="text/javascript" src="https://code.aoe.top/libs/editor.md/lib/underscore.min.js"></script>
        <script type="text/javascript" src="https://code.aoe.top/libs/editor.md/lib/sequence-diagram.min.js"></script>
        <script type="text/javascript" src="https://code.aoe.top/libs/editor.md/lib/flowchart.min.js"></script>
        <script type="text/javascript" src="https://code.aoe.top/libs/editor.md/lib/jquery.flowchart.min.js"></script>
        <script type="text/javascript" src="https://code.aoe.top/libs/editor.md/editormd.js"></script>
        <script>
            var testEditor;
            testEditor = editormd.markdownToHTML("show_readme", {
                // htmlDecode      : "style,script,sub,sup,embed|onclick,title,onmouseover,onmouseout,style",  // Filter tags, and all on* attributes
                htmlDecode      : "style,script,sub,sup,embed|on*",  // Filter tags, and all on* attributes
                // htmlDecode      : true,  // Filter tags, and all on* attributes
                syncScrolling   : "single",
                emoji           : true,
                taskList        : true,
                tocm            : true,  // 解析下拉目录
                tex             : false,  // 默认不解析
                flowChart       : true,  // 默认不解析
                sequenceDiagram : true,  // 默认不解析
                path            : "https://code.aoe.top/libs/editor.md/lib/",
            });
            $("#show_readme a").attr("target", "_blank");
        </script>
    <?php endif; ?>
    <?php if ($audio): ?>
    <link rel="stylesheet" href="https://code.aoe.top/libs/APlayer/dist/APlayer.min.css">
    <div class="nexmoe-item">
        <div class="mdui-chip">
            <span class="mdui-chip-icon"><i class="mdui-icon material-icons">music_note</i></span>
            <span class="mdui-chip-title">音乐盒</span>
        </div>
        <div class="mdui-typo" style="padding: 20px;">
            <div id="aplayer"></div>
        </div>
    </div>
    <script src="https://code.aoe.top/libs/APlayer/dist/APlayer.min.js"></script>

    <script>
        const ap = new APlayer({
            container: document.getElementById('aplayer'),
            audio: [
                <?php foreach ($audio as $val): ?>
                {
                    name: '<?=$val['file_name']?>',
                    url: '<?=$val['file_downloadUrl'] ?>',
                },
                <?php endforeach; ?>
            ]
        });

    </script>

    <?php endif; ?>
    


