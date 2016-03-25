<?php

namespace Thenbsp\Wechat\Bridge;

use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class Serializer
{
    /**
     * Symfony\Component\Serializer\Encoder\XmlEncoder
     */
    protected $xmlEncoder;

    /**
     * Symfony\Component\Serializer\Encoder\JsonEncoder
     */
    protected $jsonEncoder;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->xmlEncoder   = new XmlEncoder;
        $this->jsonEncoder  = new JsonEncoder;
    }

    /**
     * json encode
     */
    public function jsonEncode($data, array $context = array())
    {
        $defaults = array(
            'json_encode_options' => defined('JSON_UNESCAPED_UNICODE')
                ? JSON_UNESCAPED_UNICODE
                : 0
        );

        return $this->jsonEncoder->encode($data, 'json', array_replace($defaults, $context));
    }

    /**
     * json decode
     */
    public function jsonDecode($data, array $context = array())
    {
        $defaults = array(
            'json_decode_associative'       => true,
            'json_decode_recursion_depth'   => 512,
            'json_decode_options'           => 0,
        );

        return $this->jsonEncoder->decode($data, 'json', array_replace($defaults, $context));
    }

    /**
     * xml encode
     */
    public function xmlEncode($data, array $context = array())
    {
        $defaults = array(
            'xml_root_node_name'    => 'xml',
            'xml_format_output'     => true,
            'xml_version'           => '1.0',
            'xml_encoding'          => 'utf-8',
            'xml_standalone'        => false,
        );

        return $this->xmlEncoder->encode($data, 'xml', array_replace($defaults, $context));
    }

    /**
     * xml decode
     */
    public function xmlDecode($data, array $context = array())
    {
        return $this->xmlEncoder->decode($data, 'xml', $context);
    }
    
    /**
     * xml/json to array
     */
    public static function parse($string)
    {
        if( static::isJSON($string) ) {
            $result = $this->jsonEncoder->jsonDecode($string);
        } elseif( static::isXML($string) ) {
            $result = $this->xmlEncoder->xmlDecode($string);
        } else {
            throw new \InvalidArgumentException(sprintf('Unable to parse: %s', (string) $string));
        }
        return (array) $result;
    }
    /**
     * check is json string
     */
    public static function isJSON($data)
    {
        return (@json_decode($data) !== null);
    }
    /**
     * check is xml string
     */
    public static function isXML($data)
    {
        $xml = @simplexml_load_string($data);
        return ($xml instanceof \SimpleXmlElement);
    }
}
