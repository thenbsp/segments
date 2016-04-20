```php
$user = new User();
$user->setOpenid('xxx');
$user->setUnionid('xxx');
$user->setNickname('冯特罗');

$serializer = $this->get('serializer');

// Object to Array
$array = $serializer->normalize($user);

// Object to json
$json = $serializer->serialize($user, 'json', [
    'json_encode_options' => JSON_UNESCAPED_UNICODE
]);

// Object to xml
$xml = $serializer->serialize($user, 'xml', [
    'xml_root_node_name'    => 'xml',
    'xml_format_output'     => true,
    'xml_version'           => '1.0',
    'xml_encoding'          => 'utf-8',
    'xml_standalone'        => false,
]);

// Array to Object
$object = $serializer->denormalize($array, User::class);
```
