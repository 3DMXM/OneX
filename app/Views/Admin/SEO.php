<div class="mdui-container-fluid">
    <div class="mdui-typo">
        <h1>页面SEO设置</h1>
        <hr/>
        <button class="mdui-btn mdui-color-theme-accent mdui-ripple"
                mdui-dialog="{target: '#add-seo'}"
        >添加新页面</button>
        <hr/>

        <div class="mdui-dialog" id="add-seo">
            <div class="mdui-dialog-title">新建SEO页面</div>
            <div class="mdui-dialog-content">
                <div class="mdui-textfield">
                    <label for="seo_parent" class="mdui-textfield-label">路径</label>
                    <input id="seo_parent" class="mdui-textfield-input" type="text"/>
                </div>
                <div class="mdui-textfield">
                    <label for="seo_title" class="mdui-textfield-label">标题</label>
                    <input id="seo_title" class="mdui-textfield-input" type="text"/>
                </div>
                <div class="mdui-textfield">
                    <label for="seo_keywords" class="mdui-textfield-label">关键词</label>
                    <input id="seo_keywords" class="mdui-textfield-input" type="text"/>
                </div>
                <div class="mdui-textfield">
                    <label for="seo_description" class="mdui-textfield-label">介绍</label>
                    <textarea id="seo_description" class="mdui-textfield-input" rows="4" placeholder=""></textarea>
                </div>
                <div class="mdui-dialog-actions">
                    <button class="mdui-btn mdui-color-theme-accent mdui-ripple" onclick="AddNewSEO()">添加</button>
                    <button class="mdui-btn mdui-ripple" mdui-dialog-close>取消</button>
                </div>
            </div>
        </div>
    </div>

    <!--SEO列表-->
    <div class="mdui-col-xs-12">
        <div class="mdui-table-fluid">
            <table class="mdui-table mdui-table-hoverable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>路径</th>
                        <th>标题</th>
                        <th>关键词</th>
                        <th>介绍</th>
                        <th>点击量</th>
                        <th>编辑</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($list as $val){
                    echo "<tr>
    <td>{$val['id']}</td>
    <td>{$val['seo_parent']}</td>
    <td>{$val['seo_title']}</td>
    <td>{$val['seo_keywords']}</td>
    <td>{$val['seo_description']}</td>
    <td>{$val['seo_click_cnt']}</td>
    <td><button class='mdui-btn mdui-color-theme-accent mdui-ripple' mdui-dialog=\"{target: '#add-seo'}\" onclick='GetSEOData(\"{$val['seo_parent']}\")'>编辑</button></td>
</tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
    const $ = mdui.$;
    function AddNewSEO(){
        let data = {
            'seo_parent': $("#seo_parent").val(),
            'seo_title': $("#seo_title").val(),
            'seo_keywords': $("#seo_keywords").val(),
            'seo_description': $("#seo_description").val(),
        };

        $.ajax({
            method: 'POST',
            url: '/~SEO/AddSEO',
            dataType:"json",
            data: data,
            success: function (res){
                if (res.code === "00"){
                    location.reload();
                }
                mdui.snackbar({position: 'right-top', message: res.msg});
            }
        });
    }
    function GetSEOData(parent){
        $.ajax({
            method: 'POST',
            url: '/~SEO/GetSEO',
            dataType:"json",
            data: {'parent':parent},
            success:function (res){
                if (res.code == "00"){
                    let data = res.data;
                    $("#seo_parent").val(data['seo_parent']);
                    $("#seo_title").val(data['seo_title']);
                    $("#seo_keywords").val(data['seo_keywords']);
                    $("#seo_description").val(data['seo_description']);
                }else {
                    mdui.snackbar({position: 'right-top', message: res.msg});
                }
            }
        });
    }
</script>