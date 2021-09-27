# OneX

演示地址：https://game.aoe.top/

该项目是基于oneindex使用CodeIgniter4 进行开发

使用onedrive来搭建自己的网盘

项目还在完善中

适用于访问量大，导致API被限制时使用

### 优点：
- 将API相关缓存到数据库
- 不会出现目录空白的情况
- 显示REDAME.md文档
- 下载不会走服务器流量
- 框架自带缓存，节约PHP流量

### 缺点
- 除了下载其他都会走
- 无法在线游览文档、图片、视频
- 访问量大会对服务器和数据库造成压力
- 功能不多
- 只有一个皮肤
- 还没写后台页面
- 无法在线编辑文件
- 无法上传文件
- 文件排序比较随机
- 缺点多于优点


### 伪静态
nginx
```
try_files $uri $uri/ /index.php/$args;
```
Apache 
```
RewriteEngine on
# 如果请求的是真实存在的文件或目录，直接访问
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
# 如果请求的不是真实文件或目录，分发请求至 index.php
RewriteRule . index.php
```

此项目开源，欢迎有能力的大佬参与开发