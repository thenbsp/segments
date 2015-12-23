<?php

// app.template_subscriber:
//     class: AppBundle\EventSubscriber\TemplateSubscriber
//     arguments: ["@kernel", "@templating"]
//     tags:
//         - { name: kernel.event_subscriber }

<?php

namespace AppBundle\EventSubscriber;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;

class TemplateSubscriber implements EventSubscriberInterface
{
    /**
     * Symfony\Component\HttpKernel\KernelInterface
     */
    protected $kernel;

    /**
     * Symfony\Component\Templating\EngineInterface
     */
    protected $templating;

    public function __construct(KernelInterface $kernel, EngineInterface $templating)
    {
        $this->kernel       = $kernel;
        $this->templating   = $templating;
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::VIEW => 'onKernelView',
        );
    }

    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $parameters = $event->getControllerResult();

        if( !is_array($parameters) ) {
            return;
        }

        $template = $this->getTemplateReference($event->getRequest());
        $response = $this->templating->renderResponse($template, $parameters);

        $event->setResponse($response);
    }

    protected function getTemplateReference(Request $request, $engine = 'twig')
    {
        $namespace = $request->attributes->get('_controller');
        $className = explode('::', $namespace);

        if( !preg_match('/Controller\\\(.+)Controller$/', $className[0], $matchController) ) {
            throw new \InvalidArgumentException(sprintf('The "%s" class does not look like a controller class (it must be in a "Controller" sub-namespace and the class name must end with "Controller")', $className[0]));
        }

        if( !preg_match('/^(.+)Action$/', $className[1], $matchAction) ) {
            throw new \InvalidArgumentException(sprintf('The "%s" method does not look like an action method (it does not end with Action)', $className[1]));
        }

        if( $bundle = $this->getBundleForClass($className[0]) ) {
            while ($bundleName = $bundle->getName()) {
                if (null === $parentBundleName = $bundle->getParent()) {
                    $bundleName = $bundle->getName();
                    break;
                }
                $bundles = $this->kernel->getBundle($parentBundleName, false);
                $bundle = array_pop($bundles);
            }
        } else {
            $bundleName = null;
        }

        return new TemplateReference($bundleName, $matchController[1], $matchAction[1], $request->getRequestFormat(), $engine);
    }

    protected function getBundleForClass($class)
    {
        $reflectionClass = new \ReflectionClass($class);
        $bundles = $this->kernel->getBundles();

        do {
            $namespace = $reflectionClass->getNamespaceName();
            foreach ($bundles as $bundle) {
                if (0 === strpos($namespace, $bundle->getNamespace())) {
                    return $bundle;
                }
            }
            $reflectionClass = $reflectionClass->getParentClass();
        } while ($reflectionClass);
    }
}
