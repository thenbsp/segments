
# List of Commands

### 查看所有服务

```php
app/console debug:container
```

### 查看所有路由

```php
app/console debug:router {routeName}
```

### 查看所有事件

```php
app/console debug:event-dispatcher
```

### 调度指定事件

```php
app/console debug:event-dispatcher {eventName}
```

### 生成 Bundle

```php
app/console generate:bundle --namespace=Acme/BlogBundle
```

### 生成 Controller

```php
app/console generate:controller --controller=Acme/BlogBundle:Post
```

### 新建数据库

```php
app/console doctrine:database:create
```

### 生成数据表
```php
app/console doctrine:schema:update --force
```

### 生成实体对象 getter && setter

```php
app/console doctrine:generate:entities Acme/BlogBundle
```

### 生成表单类型
```php
app/console generate:doctrine:form Acme/BlogBundle:Post
```

### 根据已存在的数据表生成实体

```php
app/console doctrine:mapping:import --force AppBundle xml
```

### 装载数据

```php
app/console doctrine:fixtures:load
```

### 创建静态资源的快捷方式到 web 目录

```php
app/console assets:install web --symlink
```

### 导出 FOSJsRoutingBundle 下的路由到 web 目录

```php
app/console fos:js-routing:dump
```

### 合并资原文件

```php
app/console assetic:dump --env=prod
```

### 优化自动加载

```php
composer dump-autoload --optimize
```

### Reset

```
rm -rf ./app/cache/dev;
rm -rf ./app/cache/prod;
rm -rf ./app/logs/*.log;
rm -rf ./web/bundles;
rm -rf ./web/css;
rm -rf ./web/images;
rm -rf ./web/js;

app/console assets:install web --symlink;
app/console fos:js-routing:dump;
app/console assetic:dump --env=prod;

chmod 0777 -R ./app/cache;
chmod 0777 -R ./app/logs;

composer dump-autoload --optimize;
```

### Symfony 3

```
rm -rf ./var/cache/dev;
rm -rf ./var/cache/prod;
rm -rf ./var/sessions/dev;
rm -rf ./var/sessions/prod;
rm -rf ./var/logs/*.log;
```
