<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no"/>
<!--	<title>--><?//= $title; ?><!--</title>-->
    <meta name="keywords" content="<?= $SEO['seo_keywords'] ?>">
    <meta name="description" content="<?= $SEO['seo_description'] ?>">
    <title><?= $SEO['seo_title'] ?></title>
	<link rel="icon" href="/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/mdui@1.0.1/dist/css/mdui.min.css">
	<link rel="stylesheet" href="/styles/css/style.css">
	<script src="https://cdn.jsdelivr.net/npm/mdui@1.0.1/dist/js/mdui.min.js"></script>
</head>
<body class="mdui-theme-primary-blue-grey mdui-theme-accent-blue">
	<header class="nav">
		<div class="navSize">
			<a href="/"><img class="avatar" src="/favicon.ico" /></a>
			<div class="navRight">
			    <li class="navli"><a href="https://www.aoe.top" target="_blank">博客</a></li>
			    <li class="navli"><a href="https://mod.3dmgame.com/u/9688990" target="_blank">Mod</a></li>
			    <li class="navli"><a href="https://wanwang.aliyun.com/nametrade/detail/online.html?domainName=aoe.top" target="_blank">买下我</a></li>				
			</div>
		</div>
	</header>
    <div class="mdui-container">
        <div class="mdui-toolbar nexmoe-item">
            <a href="/"><?=$site_info['site_name'] ?></a>
            <?php
            $navsPath = "/";
            foreach((array)$navs as $val):
                if($navsPath == "/") {
                    $navsPath = "{$navsPath}{$val}";
                }else{
                    $navsPath = "{$navsPath}/{$val}";
                }
                ?>
                <i class="mdui-icon material-icons mdui-icon-dark" style="margin:0;">chevron_right</i>
                <a href="<?=$navsPath?>"><?=$val?></a>

            <?php endforeach;?>
            <!--<a href="javascript:;" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">refresh</i></a>-->
        </div>
        <!-- 头部 -->