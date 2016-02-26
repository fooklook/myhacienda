##个人庄园
集成个人博客、个人作品展示、个人兴趣爱好展示。

###项目安装
1. 复制.env.example文件改为.env，并配置数据库、邮件代理发送配置和七牛配置。
2. 数据库初始化

```shell
//mysql创建数据库
CREATE DATABASE myhacienda DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
//生成表
php artisan migrate
//填充数据
php artisan db:seed
```