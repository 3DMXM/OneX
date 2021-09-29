<link rel="stylesheet" href="https://code.aoe.top/libs/APlayer/dist/APlayer.min.css">
<div class="mdui-container-fluid">
    <div class="nexmoe-item">
<!--        <audio class="mdui-center" src="--><?//=$url ?><!--" controls autoplay style="width: 100%;"  poster="--><?php //@e($item['thumb'].'&width=176&height=176');?><!--"></audio>-->
        <div id="aplayer"></div>
    </div>
</div>
<script src="https://code.aoe.top/libs/APlayer/dist/APlayer.min.js"></script>
<script>
    const ap = new APlayer({
        container: document.getElementById('aplayer'),
        audio: [
            {
                name: '<?=end($navs) ?>',
                url: '<?=$url ?>',
            }
        ]
    });
</script>