<style type="text/css">
    .mdui-table a{
        color: white;
    }
</style>
<div class="mdui-container-fluid">
    <div class="mdui-typo">
        <h1>短链设置</h1>
        <hr/>
        <button class="mdui-btn mdui-color-theme-accent mdui-ripple"
                mdui-dialog="{target: '#add-seo'}">新建短链</button>
        <hr/>

        <div class="mdui-dialog" id="add-seo">
            <div class="mdui-dialog-title">新建短链</div>
            <div class="mdui-dialog-content">
                <div class="mdui-textfield">
                    <label for="seo_parent" class="mdui-textfield-label">本地短链</label>
                    <input id="sc_string" class="mdui-textfield-input" type="text"/>
                    <div class="mdui-btn mdui-color-theme-accent mdui-ripple" onclick="GetRandomString()">随机生成短链</div>
                </div>
                <div class="mdui-textfield">
                    <label for="seo_parent" class="mdui-textfield-label">跳转链接</label>
                    <input id="sc_url" class="mdui-textfield-input" type="text"/>
                </div>
                <div class="mdui-dialog-actions">
                    <button class="mdui-btn mdui-color-theme-accent mdui-ripple" onclick="AddNewSCUrl()">添加</button>
                    <button class="mdui-btn mdui-ripple" mdui-dialog-close>取消</button>
                </div>
            </div>
        </div>
    </div>

    <!--短链列表-->
    <div class="mdui-col-xs-12">
        <div class="mdui-table-fluid">
            <table class="mdui-table mdui-table-hoverable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>短链</th>
                    <th>访问次数</th>
                    <th>跳转地址</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach ($list as $val){
                echo "<tr>
<td>{$val['id']}</td>
<td><a href='/s/{$val['sc_string']}' target='_blank'>/s/{$val['sc_string']}</a></td>
<td>{$val['sc_click_cnt']}</td>
<td><a href='{$val['sc_url']}' target='_blank'>{$val['sc_url']}</a></td>
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

    function AddNewSCUrl(){
        let data = {
            'sc_url': $("#sc_url").val(),
            'sc_string': $("#sc_string").val()
        }
        $.ajax({
            method: 'POST',
            url: '/~SCUrl/AddSCUrl',
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

    function GetRandomString(){
        $.ajax({
            method: 'GET',
            url: '/~SCUrl/GetStr',
            dataType:"json",
            success: function (res){

                $("#sc_string").val(res.str);
            }
        });
    }


</script>