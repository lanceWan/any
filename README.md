# Any
最简化权限管理系统，基于 Laravel5.4 开发。由于 Laravel5.5 发布推迟，只好先写个 Laravel5.4版本的，后面再升级上去。

## Any 是什么
`Any` 是一个最简化全新管理后台模块，包含最简单的权限控制。最开始写权限系统的时候是看的一个老外写的源码。根据他的代码自己写了一个 基于Laravel5.2 `IAdmin` 后台，这个是最开始权限系系统，为了公用，所有权限都是写的配置文件。

`iDashboard` 是在 `IAdmin` 的基础之上优化了设计思想和代码结构，并且权限和路由名称进行绑定，一个中间件就可以判断所有控制器的权限。基于 Laravel5.3 开发，唯一优化的是用权限和路由别名绑定，这样代码写好之后就可以直接使用。但配置文件配置过多问题还是没有解决。

`Any` 是在 `iDashboard` 经验上重构的一个项目，之前版本的权限控制都是需要自己去定义，有没有一种方式像 ACL 那样自动生成权限并判断？这样就大大减少了去定义权限和配置。 `Any` 由此诞生。

`Any` 的主要原理就是根据用户访问的路由，获取当前访问的控制器(controller)和方法(method)，控制器加方法生成唯一权限值，当一个用户访问某个方法的时候中间件会判断。如果是超级管理员，即使没有这个权限会自动赋予权限给超级管理员角色。为了避免中间件查询过多，所以在用户登录的成功之后会缓存一份当前用户的所有权限，判断权限的时候直接获取缓存中，更新任何角色的权限都会更新缓存。除此之外，代码上也进行了很多优化。

## Any 特点
- 基于控制器方法权限控制
- 多主题(目前只开发了一套，后期支持)
- 多语言(没有实现数据多语言化)

> 这些只是基础功能的开始，希望得到更多的灵感

## 安装 Any
下载本项目代码到本地：
```
git clone https://github.com/lanceWan/any.git
```

进入到项目然后 `composer` 安装：

```
cd iDashboard

composer install
```

配置 `.env` 文件：
```
[sudo]cp .env.example .env
```

> Linux 和 Mac 下注意执行权限 !

配置数据库：
```
DB_HOST=localhost
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

迁移数据：
```
php artisan migrate --seed
```

OK,项目已经配置完成，直接访问首页然后登录即可，不清楚路由的可以直接去看 `routes/web.php` 文件。默认管理员账号：`iwanli` , 密码：`123456` 。如果你是在 `Linux` 或 `Mac` 下配置的请注意相关目录的权限，这里我就不多说了，enjoy！

## 线上演示
地址：[http://any.iwanli.me](http://any.iwanli.me)
- 管理员：`iwanli` `123456`
- 普通用户：`Gutkowski ` `123456`

## 安装错误问题
如果出现下面的错误：
```
The only supported ciphers are AES-128-CBC and AES-256-CBC with the correct key lengths.
```

如果你用 `php artisan key:generate` 生成秘钥的时候就报这个错误，那么请随便复制一个其他 `Laravel` 项目的 `APP_KEY` 到你报错项目的 `.env` 文件中。然后正常执行命令其他命令即可。

## 建议和反馈
`Any` 发展离不开大家的反馈和建议，如果大家有什么想法可以直接在 [https://github.com/lanceWan/any/issues](https://github.com/lanceWan/any/issues) 中提出，谢谢。

Laravel学习交流群：`312621686`