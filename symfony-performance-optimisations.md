### Symfony Performance Optimisations

From: http://symfony.com/doc/current/performance.html(http://symfony.com/doc/current/performance.html)

默认情况下，PHP 的 OPcache 在字节码缓存中保存最多 2,000 个文件。此数字对于典型的 Symfony 应用程序来说太低，因此您应该使用 ``opcache.max_accelerated_files`` 配置选项设置更高的限制：

```
opcache.max_accelerated_files = 20000
```

PHP 使用内部缓存来存储将文件路径映射到其真实和绝对文件系统路径的结果。默认情况下 PHP 设置一个 16K 的 ``realpath_cache_size``，对 Symfony 来说太小了。请考虑将此值至少更新为 4096K：

```
realpath_cache_size = 4096K
```

缓存路径默认情况下只存储 120 秒。请考虑使用 ``realpath_cache_ttl`` 选项更新此值：

```
realpath_cache_ttl = 600
```

默认情况下，``Symfony Standard Edition`` 在 autoload.php 文件中使用 Composer 的自动加载器。这个自动加载器很容易使用，因为它会自动找到您放置在注册目录中的任何新类。

不幸的是，这是有代价的，因为加载器遍历所有配置的命名空间以找到一个特定的文件，使得 ``file_exists()`` 调用，直到它终于找到它寻找的文件。

最简单的解决方案是告诉 Composer 构建一个优化的“类映射”，它是所有类的位置的一个大数组，它存储在 ``vendor/composer/autoload_classmap.php`` 中。

类映射可以从命令行生成，并且可能成为部署过程的一部分：

```
composer dump-autoload --optimize --no-dev --classmap-authoritative
```

+ ``--optimize`` 转储您的应用程序中使用的每个PSR-0和PSR-4兼容类
+ ``--no-dev`` 排除在开发环境中仅需要的类（例如测试）
+ ``--classmap-authoritative`` 阻止Composer为类映射中找不到的类扫描文件系统
