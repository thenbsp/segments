<?php

// parameters:
//     app.template_guesser.class: AppBundle\Templating\TemplateGuesser
//     app.template_listener.class: AppBundle\EventListener\TemplateListener

// services:

//     app.template_guesser:
//         class: %app.template_guesser.class%
//         arguments: ["@kernel"]

//     app.template_listener:
//         class: %app.template_listener.class%
//         arguments: ["@templating", "@app.template_guesser"]
//         tags:
//             - { name: kernel.event_subscriber }

namespace AppBundle\EventListener;

use AppBundle\Templating\TemplateGuesser;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class TemplateListener implements EventSubscriberInterface
{
    /**
     * Symfony\Component\Templating\EngineInterface
     */
    protected $templating;

    /**
     * AppBundle\Templating\TemplateGuesser
     */
    protected $templateGuesser;

    public function __construct(EngineInterface $templating, TemplateGuesser $templateGuesser)
    {
        $this->templating       = $templating;
        $this->templateGuesser  = $templateGuesser;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $request = $event->getRequest();

        if( $request->getRequestFormat() === 'json' ) {
            $exception = $event->getException();
            $parameter = array(
                'errCode'   => $exception->getCode(),
                'errMsg'    => $exception->getMessage()
            );
            $event->setResponse($this->getJsonResponse($parameter));
        }
    }

    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        if( !is_array($parameter = $event->getControllerResult()) ) {
            return;
        }

        $request = $event->getRequest();

        if( $request->getRequestFormat() === 'json' ) {
            $response = $this->getJsonResponse($parameter);
        } else {
            $template = $this->templateGuesser->guessTemplateName($request);
            $response = $this->templating->renderResponse($template, $parameter);
        }

        $event->setResponse($response);
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::EXCEPTION => 'onKernelException',
            KernelEvents::VIEW      => 'onKernelView'
        );
    }

    protected function getJsonResponse(array $parameter)
    {
        $response = new JsonResponse($parameter);
        $response->setEncodingOptions(defined('JSON_UNESCAPED_UNICODE') ? JSON_UNESCAPED_UNICODE : 0);

        return $response;
    }
}
