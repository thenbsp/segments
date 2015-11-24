<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse,
    Symfony\Component\HttpKernel\Event\FilterResponseEvent;

/**
 * PHP 5.4 之前没有 JSON_UNESCAPED_UNICODE 选项
 */
defined('JSON_UNESCAPED_UNICODE') || define('JSON_UNESCAPED_UNICODE', 0);

/**
 * 监听全局响应
 */
class KernelResponseListener
{
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();

        if( $response instanceof JsonResponse ) {
            $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);
            $event->setResponse($response);
        }
    }
}
