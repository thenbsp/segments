
# List of Commands

### 查看所有服务

```php
bin/console debug:container
```

### 查看所有路由

```php
bin/console debug:router {routeName}
```

### 查看所有事件

```php
bin/console debug:event-dispatcher
```

### 调度指定事件

```php
bin/console debug:event-dispatcher {eventName}
```

### 生成 Bundle

```php
bin/console generate:bundle --namespace=Acme/BlogBundle
```

### 生成 Controller

```php
bin/console generate:controller --controller=Acme/BlogBundle:Post
```

### 新建数据库

```php
bin/console doctrine:database:create
```

### 生成数据表
```php
bin/console doctrine:schema:update --force
```

### 生成实体对象 getter && setter

```php
bin/console doctrine:generate:entities Acme/BlogBundle
```

### 生成表单类型
```php
bin/console generate:doctrine:form Acme/BlogBundle:Post
```

### 根据已存在的数据表生成实体

```php
bin/console doctrine:mapping:import --force AppBundle xml
```

### 装载数据

```php
bin/console doctrine:fixtures:load
```

### 创建静态资源的快捷方式到 web 目录

```php
bin/console assets:install web --symlink
```

### 导出 FOSJsRoutingBundle 下的路由到 web 目录

```php
app/console fos:js-routing:dump
```

### 合并资原文件

```php
bin/console assetic:dump --env=prod
```

### 优化自动加载

```php
composer dump-autoload --optimize
```

### Rest

```
rm -rf ./var/cache/dev/*;
rm -rf ./var/cache/prod/*;
rm -rf ./var/sessions/dev;
rm -rf ./var/sessions/prod;
rm -rf ./var/logs/*.log;
rm -rf ./web/bundles;

bin/console assets:install web --symlink;

chmod 0777 -R ./var/cache;
chmod 0777 -R ./var/logs;
chmod 0777 -R ./var/sessions;

composer dump-autoload --optimize;
```
