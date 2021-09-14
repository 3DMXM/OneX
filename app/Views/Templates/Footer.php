    <!--底部-->
    <div class="fotter">
	    <p>小莫网盘 @2020-<?=date("Y") ?> 如果网盘中有包含侵犯您权利的内容，请联系邮箱xm@xmsky.onmicrosoft.com</p>
	    <p>
	        <a href="https://www.aoe.top/notes/490" target="_blank">下载速度慢提速方案</a>|
	        <a href="https://www.aoe.top/notes/497" target="_blank">下载提示需要登录？</a>
	    </p>
	    <p><a href="javascript:buyMeCoffee()">给小莫投食</a></p>
	    <div class="buyMeCoffee">
			<picture onclick="buyMeCoffee()">
				<source srcset="https://code.aoe.top/img/buyMeCoffee/buyMeCoffee.webp" type="image/webp">
				<img src="https://code.aoe.top/img/buyMeCoffee/buyMeCoffee.png" alt="给小莫投食">
			</picture>
		</div>
	</div>
	<script type='text/javascript' src='https://code.aoe.top/libs/jquery/jquery-3.6.0.min.js'></script>
	<script type='text/javascript' src='https://code.aoe.top/libs/layer/layer.js'></script>
    
    <!-- Google统计代码 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-130847064-2"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'UA-130847064-2');
    </script>    
    <script>
       function buyMeCoffee() {
           
            layer.open({
                type:1,
                area:['300px', '400px'],
                title:'给小莫投食',
                resize:false,
                scrollbar:false,
                shadeClose : true,
                content:'<div class="donate-box"><div class="meta-pay text-center"><strong>小莫已经懒到不想动了<br/>或许给小莫投点食能让小莫有点动力</strong></div> ' + 
				'<div class="qr-pay text-center"><img class="pay-img" id="alipay_qr" src="https://code.aoe.top/img/buyMeCoffee/zfb.png">' +
				'<img class="pay-img d-none" id="wechat_qr" src="https://code.aoe.top/img/buyMeCoffee/wx.png"></div><div class="choose-pay text-center mt-2">' +
				'<input id="alipay" type="radio" name="pay-method" checked><label for="alipay" class="pay-button">' +
				'<img src="https://code.aoe.top/img/buyMeCoffee/alipay.png"></label>' +
				'<input id="wechatpay" type="radio" name="pay-method"><label for="wechatpay" class="pay-button">' +
				'<img src="https://code.aoe.top/img/buyMeCoffee/wechat.png"></label></div></div>'
            });
            $('.choose-pay input[type="radio"]').click(function(){
                var id= $(this).attr('id');
                if(id=='alipay'){$('.qr-pay #alipay_qr').removeClass('d-none');$('.qr-pay #wechat_qr').addClass('d-none')};
                if(id=='wechatpay'){$('.qr-pay #alipay_qr').addClass('d-none');$('.qr-pay #wechat_qr').removeClass('d-none')};
            });
        }
    </script>
</body>
</html>