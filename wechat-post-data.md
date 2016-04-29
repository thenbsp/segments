### 文本消息

```
<xml>
    <ToUserName><![CDATA[gh_08cb40357652]]></ToUserName>
    <FromUserName><![CDATA[ob4npwpYsDT6CQGHRDl9U50V6-RE]]></FromUserName>
    <CreateTime>1461938829</CreateTime>
    <MsgType><![CDATA[text]]></MsgType>
    <Content><![CDATA[文字消息]]></Content>
    <MsgId>6278979459712291404</MsgId>
</xml>
```

### 图片消息

```
<xml>
    <ToUserName><![CDATA[gh_08cb40357652]]></ToUserName>
    <FromUserName><![CDATA[ob4npwpYsDT6CQGHRDl9U50V6-RE]]></FromUserName>
    <CreateTime>1461938922</CreateTime>
    <MsgType><![CDATA[image]]></MsgType>
    <PicUrl><![CDATA[http://mmbiz.qpic.cn/mmbiz/CiaSEgdzWoUjKrgj5icYD9SXURx0xDarUKc2fiaKagRcjgafjcHTKwzeokhrcy0hd3hsjF5mtBakRIGfqbibEkg5VA/0]]></PicUrl>
    <MsgId>6278979859144249952</MsgId>
    <MediaId><![CDATA[Aq97afz81ENqsLKuTOFNtGpqoUPdm-4Pqx5rhYze7Zh1KcA4t60boveboj7DVhoP]]></MediaId>
</xml>
```

### 语音消息

```
<xml>
    <ToUserName><![CDATA[gh_08cb40357652]]></ToUserName>
    <FromUserName><![CDATA[ob4npwpYsDT6CQGHRDl9U50V6-RE]]></FromUserName>
    <CreateTime>1461939124</CreateTime>
    <MsgType><![CDATA[voice]]></MsgType>
    <MediaId><![CDATA[bZeLKlKjYSrLOwIhsicX2Wz6c7Zq5EZVNfJSzAmiFOG7f-WMhw_CfexAoBLAHmf1]]></MediaId>
    <Format><![CDATA[amr]]></Format>
    <MsgId>6278980726727643823</MsgId>
    <Recognition><![CDATA[]]></Recognition>
</xml>
```

### 视频消息

```
// 始终没找到从哪里才能给公众号发视频，有知道的劳烦告诉一下
```

### 小视频消息

```
<xml>
    <ToUserName><![CDATA[gh_08cb40357652]]></ToUserName>
    <FromUserName><![CDATA[ob4npwpYsDT6CQGHRDl9U50V6-RE]]></FromUserName>
    <CreateTime>1461939273</CreateTime>
    <MsgType><![CDATA[shortvideo]]></MsgType>
    <MediaId><![CDATA[p8Yx3ddhpn9YpolOGxjX9Zwvhw1KffnR0j2TVZJxQbixQq1foSlD-YxgHiSAqmMy]]></MediaId>
    <ThumbMediaId><![CDATA[9Gvjqk6xei-GVI5Zd_lPLtTwfTnuYSFrqioahJ4l2eAx68M-NXGQ_981pV5yHDqF]]></ThumbMediaId>
    <MsgId>6278981366677770986</MsgId>
</xml>
```

### 地里位置消息

```
<xml>
    <ToUserName><![CDATA[gh_08cb40357652]]></ToUserName>
    <FromUserName><![CDATA[ob4npwpYsDT6CQGHRDl9U50V6-RE]]></FromUserName>
    <CreateTime>1461940127</CreateTime>
    <MsgType><![CDATA[location]]></MsgType>
    <Location_X>34.228226</Location_X>
    <Location_Y>108.911987</Location_Y>
    <Scale>16</Scale>
    <Label><![CDATA[陕西省西安市雁塔区太白南路2号]]></Label>
    <MsgId>6278985034579842147</MsgId>
</xml>
```

### 链接消息

```
<xml>
    <ToUserName><![CDATA[gh_08cb40357652]]></ToUserName>
    <FromUserName><![CDATA[ob4npwpYsDT6CQGHRDl9U50V6-RE]]></FromUserName>
    <CreateTime>1461940282</CreateTime>
    <MsgType><![CDATA[link]]></MsgType>
    <Title><![CDATA[4.24探秘鲸鱼沟]]></Title>
    <Description><![CDATA[鲸鱼沟简介鲸鱼沟位于白鹿原狄寨镇南2公里，距西安约30公里，为灞桥区与长安区交界。沟内自然风光秀丽，一年...]]></Description>
    <Url><![CDATA[http://www.hdb.com/party/t6x7u?h_share_uid=39v4c&hdb_from=WXShare]]></Url>
    <MsgId>6278985700299773134</MsgId>
</xml>
```

### 关注事件

```
<xml>
    <ToUserName><![CDATA[gh_08cb40357652]]></ToUserName>
    <FromUserName><![CDATA[ob4npwpYsDT6CQGHRDl9U50V6-RE]]></FromUserName>
    <CreateTime>1461940805</CreateTime>
    <MsgType><![CDATA[event]]></MsgType>
    <Event><![CDATA[subscribe]]></Event>
    <EventKey><![CDATA[]]></EventKey>
</xml>
```

### 取消关注事件

```
<xml>
    <ToUserName><![CDATA[gh_08cb40357652]]></ToUserName>
    <FromUserName><![CDATA[ob4npwpYsDT6CQGHRDl9U50V6-RE]]></FromUserName>
    <CreateTime>1461940735</CreateTime>
    <MsgType><![CDATA[event]]></MsgType>
    <Event><![CDATA[unsubscribe]]></Event>
    <EventKey><![CDATA[]]></EventKey>
</xml>
```

### 扫描带参数的二维码关注事件

```
<xml>
    <ToUserName><![CDATA[gh_08cb40357652]]></ToUserName>
    <FromUserName><![CDATA[ob4npwpYsDT6CQGHRDl9U50V6-RE]]></FromUserName>
    <CreateTime>1461942855</CreateTime>
    <MsgType><![CDATA[event]]></MsgType>
    <Event><![CDATA[subscribe]]></Event>
    <EventKey><![CDATA[qrscene_1113]]></EventKey> <Ticket><![CDATA[gQEo7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2pqbFJWV1hsb203YnF6X3Y4eFdyAAIEw3cjVwMEAAAbba==]]></Ticket>
</xml>
```

### 扫描带参数的二维码时已关注，直接进入会话事件

```
<xml>
    <ToUserName><![CDATA[gh_08cb40357652]]></ToUserName>
    <FromUserName><![CDATA[ob4npwpYsDT6CQGHRDl9U50V6-RE]]></FromUserName>
    <CreateTime>1461942905</CreateTime>
    <MsgType><![CDATA[event]]></MsgType>
    <Event><![CDATA[SCAN]]></Event>
    <EventKey><![CDATA[1113]]></EventKey> <Ticket><![CDATA[gQEo7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2pqbFJWV1hsb203YnF6X3Y4eFdyAAIEw3cjVwMEAAAbba==]]></Ticket>
</xml>
```

### 上报地理位置事件

```
<xml>
    <ToUserName><![CDATA[gh_08cb40357652]]></ToUserName>
    <FromUserName><![CDATA[ob4npwpYsDT6CQGHRDl9U50V6-RE]]></FromUserName>
    <CreateTime>1461941811</CreateTime>
    <MsgType><![CDATA[event]]></MsgType>
    <Event><![CDATA[LOCATION]]></Event>
    <Latitude>34.216242</Latitude>
    <Longitude>102.105487</Longitude>
    <Precision>2662.000000</Precision>
</xml>
```

### 自定义菜单点击拉取消息事件

```
<xml>
    <ToUserName><![CDATA[gh_08cb40357652]]></ToUserName>
    <FromUserName><![CDATA[ob4npwpYsDT6CQGHRDl9U50V6-RE]]></FromUserName>
    <CreateTime>1461942774</CreateTime>
    <MsgType><![CDATA[event]]></MsgType>
    <Event><![CDATA[CLICK]]></Event>
    <EventKey><![CDATA[key_1]]></EventKey>
</xml>
```

### 自定义菜单跳转事件

```
<xml>
    <ToUserName><![CDATA[gh_08cb40357652]]></ToUserName>
    <FromUserName><![CDATA[ob4npwpYsDT6CQGHRDl9U50V6-RE]]></FromUserName>
    <CreateTime>1461940878</CreateTime>
    <MsgType><![CDATA[event]]></MsgType>
    <Event><![CDATA[VIEW]]></Event>
    <EventKey><![CDATA[http://www.7749.la/timeline]]></EventKey>
    <MenuId>403282101</MenuId>
</xml>
```
