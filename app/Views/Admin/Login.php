<body class="mdui-theme-primary-blue-grey mdui-theme-accent-blue">
	<header class="mdui-appbar mdui-color-theme">
		<div class="mdui-toolbar mdui-container">
			<?php
			if(!empty($msg)){
				echo "<div class='mdui-typo-headline'>{$msg}</div>";
			}
			?>        
		</div>
	</header>
	
	<div class="mdui-container">
        <div class="mdui-container-fluid">
            <div class="mdui-col-md-6 mdui-col-offset-md-3">
            <center><h4 class="mdui-typo-display-2-opacity">系统管理</h4></center>
            <form action="" method="post">
				<div class="mdui-textfield mdui-textfield-floating-label">
				<i class="mdui-icon material-icons">person</i>
                    <label class="mdui-textfield-label">用户名</label>
                    <input name="username" class="mdui-textfield-input" type="text">
				</div>
                <div class="mdui-textfield mdui-textfield-floating-label">
                    <i class="mdui-icon material-icons">https</i>
                    <label class="mdui-textfield-label">密码</label>
                    <input name="password" class="mdui-textfield-input" type="password"/>
                </div>
                <br>
                <button type="submit" class="mdui-center mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme">
                    <i class="mdui-icon material-icons">fingerprint</i>
                    登录
                </button>
            </form>
            </div>            
        </div>
  	</div>