##个人庄园
集成个人博客、个人作品展示、个人兴趣爱好展示。

###项目安装
1. 复制.env.example文件改为.env，并配置数据库、邮件代理发送配置和七牛配置。

```php
//配置说明
APP_ENV=local
APP_DEBUG=true
APP_KEY=SomeRandomString

DB_HOST=localhost
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

//邮件服务器的相关配置
MAIL_DRIVER=smtp
MAIL_HOST=mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null

MARKDOWN_URL=

//注册七牛账号，使用免费云空间，相关账号配置。
QINIU_DOMAINS_DEFAULT=
QINIU_ASSESS_KEY=
QINIU_SECRET_KEY=
QINIU_BUCKET=
//七牛图片前缀
QINIU_PREFIX=

//GITHUB相关配置
//在github中创建services中，填入的密钥。
GITHUB_SECRET=
//需要同步的项目名称
GITHUB_REPOSITORY=
GITHUB_EMAIL=
GITHUB_USERNAME=
//在github网站中，个人设置，创建一个Personal access tokens
GITHUB_TOKEN=
```
2. 数据库初始化

```shell
//mysql创建数据库
CREATE DATABASE myhacienda DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
//生成表
php artisan migrate
//填充数据
php artisan db:seed
```