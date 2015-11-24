<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse,
    Symfony\Component\HttpFoundation\RedirectResponse,
    Symfony\Bundle\FrameworkBundle\Routing\Router,
    Symfony\Component\HttpKernel\Event\GetResponseEvent;

// # on kernel reqeust
// listener.kernel.request:
//     class: AppBundle\EventListener\KernelListener
//     arguments:
//         - @router
//     tags:
//         - { name: kernel.event_listener, event: kernel.request, method: onRequest

class KernelListener
{
    /**
     * 当前 Router
     */
    protected $router;

    /**
     * 重要：这里需要排除些不需要 openid 的 URL
     * 除了这些 Route 之前，会自动转向授权页
     */
    protected $ignoreRoute = [
        'authorize',
        'authorize_callback'
    ];

    /**
     * 构造方法
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * 请求完成后执行
     */
    public function onRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();
        $session = $request->getSession();

        // 如果有 OpenID，则放行
        if( $session->has('openid') ) {
            return;
        }

        // 排除资源文件
        if( preg_match("^/(_(profiler|wdt)|css|images|js)/^", $request->getPathInfo()) ) {
            return;
        }

        // 排除不需要 openid 的 URL
        $currentRoute   = $request->get('_route');
        $currentParams  = $request->get('_route_params');

        if( in_array($currentRoute, $this->ignoreRoute) ) {
            return;
        }

        // 跳转到授权页，并把当前页作为参数（授权完成后还要跳转回来）
        $currentUri     = $this->router->generate($currentRoute, $currentParams);
        $authorizeUrl   = $this->router->generate('wechat_authorize', [
            'continue'  => $currentUri
        ]);

        if( !$request->isXmlHttpRequest() ) {
            return $event->setResponse(new RedirectResponse($authorizeUrl));
        }
        
        $response = new JsonResponse([
            'failure'   => '401 Unauthorized',
            'redirect'  => $authorizeUrl
        ]);
        
        return $event->setResponse($response);
    }

}
