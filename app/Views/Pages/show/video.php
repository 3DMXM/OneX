<link rel="stylesheet" href="https://code.aoe.top/libs/DPlayer/dist/DPlayer.min.js">
<div class="mdui-container-fluid">
    <div class="nexmoe-item">
        <div class="mdui-center" id="dplayer"></div>
    </div>
</div>
<script src="https://code.aoe.top/libs/DPlayer/dist/DPlayer.min.js"></script>
<script>
    const dp = new DPlayer({
        container: document.getElementById('dplayer'),
        video: {
            url: '<?=$url ?>',
            type: 'auto',
            thumbnails: '<?=$thumb ?>',
            pic: '<?=$thumb ?>'
        },
        subtitle:{
            url: ''
        }
    });
</script>
