# OneX

演示地址：https://onex.aoe.top

该项目是基于oneindex使用CodeIgniter4 进行开发

使用onedrive来搭建自己的网盘

项目还在完善中

适用于访问量大，导致API被限制时使用

### 安装
- 克隆代码
```
git clone https://github.com/3DMXM/OneX.git
```
- 将网站根目录指定到 ``OneX/public``
- 在``config\Database.php``中配置数据库
- 导入onex.sql中的格式
- 在``token``表中手动配置相关参数
- 在``user``表中手动配置相关参数
> 对，没错，很麻烦，因为我还没写安装相关的代码

### 优点：
- 将API相关缓存到数据库
- 不会出现目录空白的情况
- 显示REDAME.md文档
- 下载不会走服务器流量
- 框架自带缓存，节约PHP资源
- 可自定义SEO数据
- 可统计范围次数
- 后台密码使用双重MD5加密，更好的保护你的密码
- 后台使用一次性token验证,防止后台被别人登录了自己还不知道
- 在线游览图片、视频、音频
- 相同文件夹中的音乐会自动组成音乐盒

### 缺点
- 除了下载其他都会走
- 访问量大会对服务器和数据库造成压力
- 功能不多
- 只有一个皮肤
- ~~还没写后台页面~~（已写后台
- 无法在线编辑文件
- 无法上传文件
- ~~文件排序比较随机~~（优先按文件类型排序，然后再按文件名排序
- 缺点多于优点


### 伪静态
nginx
```
if (!-f $request_filename){
    set $rule_0 1$rule_0;
}
if (!-d $request_filename){
    set $rule_0 2$rule_0;
}
if ($rule_0 = "21"){
    rewrite ^/(.*)$ /index.php?/$1 last;
}
```
Apache 
```
不知道
```

此项目开源，欢迎有能力的大佬参与开发