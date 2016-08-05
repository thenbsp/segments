
# List of Commands

### 查看所有服务

```php
php bin/console debug:container
```

### 查看所有路由

```php
php bin/console debug:router
```

### 查看所有事件

```php
php bin/console debug:event-dispatcher
```

### 触发指定事件

```php
php bin/console debug:event-dispatcher {eventName}
```

### 生成 Bundle

```php
php bin/console generate:bundle
```

### 生成 Controller

```php
php bin/console generate:controller
```

### 新建数据库

```php
php bin/console doctrine:database:create
```

### 生成数据表
```php
php bin/console doctrine:schema:update --force
```

### 生成实体 getter && setter

```php
php bin/console doctrine:generate:entities {bundleName}
```

### 生成实体 form type
```php
php bin/console generate:doctrine:form {bundleName:entityName}
```

### 根据已存在的数据表生成实体

```php
php bin/console doctrine:mapping:import --force {bundleName} {annotation|yml|xml}
```

### 装载测试数据

```php
php bin/console doctrine:fixtures:load
```

### 创建静态资源的快捷方式到 web 目录

```php
php bin/console assets:install web --symlink
```

### 导出 FOSJsRoutingBundle 下的路由到 web 目录

```php
php bin/console fos:js-routing:dump
```

### 合并资原文件

```php
php bin/console assetic:dump --env=prod
```

### 优化自动加载

```php
composer dump-autoload --optimize
```

### Symfony2

```
rm -rf ./app/logs/*;
rm -rf ./app/cache/*;
rm -rf ./web/bundles;

chmod 0777 -R ./app/logs;
chmod 0777 -R ./app/cache;

app/console assets:install web --symlink;
```

### Symfony3

```
rm -rf ./var/logs/*;
rm -rf ./var/cache/*;
rm -rf ./var/sessions/*;
rm -rf ./web/images;
rm -rf ./web/css;
rm -rf ./web/js;

php bin/console assets:install web;

chmod 0777 -R ./var/logs;
chmod 0777 -R ./var/cache;
chmod 0777 -R ./var/sessions;
```
