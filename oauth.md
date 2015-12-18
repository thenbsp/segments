# OAuath2

### create authenticate url

```php
$client = new Client($appid, $appkey);
$client->addScope($scope);
$client->setRedirectUri($url);

header('Location: ' . filter_var($client->createAuthorizeUrl(), FILTER_SANITIZE_URL));
```

### authenticate

```php
$client->authenticate($_GET['code']);
$_SESSION['access_token'] = $client->getAccessToken();
```

### calling APIs

```php
$userinfo = new Userinfo($_SESSION['access_token']);
```

# Wechat

```php
/Credential/AccessToken.php
/Message/...
/OAuth/...
/Jsapi/...
/User/...
/Menu/...
/Card/...
/Media/...
/Payment/...
/Analytics/...
/Entityshop/...
/Semantic/..
/Support/...
  /ServerIp.php
  /Qrcode.php
  /ShortUrl.php
```
