## 项目名称

开发一个 HTML5 应用之前，请先为该应用起一个名称，名称应该尽量遵循以下原则：

* 使用有意义的名称，避免使用毫无意义名称比如：asdf
* 使用全小写的英文（可包含下划线），例如：myapp、myapp_v2、myapp_test
* 使用和公司、项目、功能相关的命名，例如：funxshop、biaozhun
* 使用尽可能短的名称

## 目录结构

目录结构命名约定可以使项目更易于理解（尤其是在其它人接管项目时），因此，请严格按照下面的目录名称存放文件。假设我们现在开发一个名为 example 的 HTML5 应用，目录结构应为：

```css
/example/audio        /** 音频文件 */
/example/font         /** 字体文件 */
/example/css          /** CSS 文件 */
/example/img          /** 图像文件 */
/example/js           /** Javascript 文件 */
/example/lib          /** PHP 库文件 */
/example/...          /** 其它文件（如果有的话） */
/example/index.php    /** 使用 .php 文件，避免使用 .html */
```

## 资源管理

使用资源管理器管理静态文件的意义在于随意切换静态资源的引用方式，这样使得开发、调试和发布应用不在受 CDN 缓存的限制，使用资源管理器之前，先引入文件 Asset.php：

代码地址：https://github.com/thenbsp/lib/blob/master/Asset.php

```php
require '/example/lib/Asset.php';
```

引入一个普通的资源：

```php
$asset = new Asset();

// 引入 /example/js/common.js
var_dump($asset->getUrl('js/common.js'));
```

引入一个 CDN 上的资源：

```php
$asset = new Asset('http://static.example.com/');

// 引入 http://static.exammple.com/js/common.js
var_dump($asset->getUrl('js/common.js'));
```

引入 CDN 上的资源并设置一个版本号：

```php
$asset = new Asset('http://static.example.com/');
$asset->setVersion('v2', 'version');

// 引入 http://static.exammple.com/js/common.js?version=v2
var_dump($asset->getUrl('js/common.js'));
```

一个实际场景中的示例：

```html
// /example/index.php

<?php

require './lib/Asset.php';

$asset = new Asset('http://name.b0.upaiyun.com/example/');

?>
<html>
<head>
<meta charset="UTF-8">
<title>example</title>
<link rel="stylesheet" href="<?php echo $asset->getUrl('css/common.css'); ?>" />
</head>
<body>

<img src="<?php echo $asset->getUrl('img/image.jpg'); ?>" />
// ...

<script src="<?php echo $asset->getUrl('js/common.js'); ?>" ></script>
</body>
</html>
```

**CSS 文件中引入图像，请使用相对路径，即 /example/css/common.css 调用 /example.com/img/image.jpg 请使用 ../img/image.jpg**

## 开放 CDN 托管平台

引入开放 CDN 直接使用绝对地址，**不需要使用 Asset 管理器**，示例：

```html
<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.js"></script>
```

一些常用的库请使用开放 CDN 平台，比如 jQuery、Zepto、Bootstrap 等，下面列出来常用的 CDN 托管平台：

* http://cdn.code.baidu.com/
* http://lib.sinaapp.com/
* http://staticfile.org/

## 正式上线

项目正式上线前需要注意改下工作：

**一、将所有静态文件（CSS、Javascript、图像）等文件压缩、优化上传至 CDN！**

使用 Asset 管理器调用 CDN 中的静态文件，以尽可能提高访问速度。

**二、添加统计代码！**

```javascript
<script src="http://sdk.talkingdata.com/app/h5/v1?appid={APPID}&vn={example}"></script>
```

``APPID`` 需要从官网获取，``example`` 为项目名称。

一些常用的 JS、CSS、图像优化平台

* http://zhitu.isux.us/
* https://tinypng.com/
* http://csscompressor.com/
* http://tool.css-js.com/
