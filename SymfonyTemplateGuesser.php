<?php

namespace AppBundle\Templating;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;

class TemplateGuesser
{
    /**
     * Symfony\Component\HttpKernel\KernelInterface
     */
    protected $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public function guessTemplateName(Request $request, $engine = 'twig')
    {
        if( !$namespace = $request->attributes->get('_controller') ) {
            throw new \InvalidArgumentException('Invalid Request Object');
        }

        list($controller, $action) = explode('::', $namespace);

        if( !preg_match('/Controller\\\(.+)Controller$/', $controller, $matchController) ) {
            throw new \InvalidArgumentException(sprintf('The "%s" class does not look like a controller class (it must be in a "Controller" sub-namespace and the class name must end with "Controller")', $controller));
        }

        if( !preg_match('/^(.+)Action$/', $action, $matchAction) ) {
            throw new \InvalidArgumentException(sprintf('The "%s" method does not look like an action method (it does not end with Action)', $action));
        }

        if( $bundle = $this->getBundleForClass($controller) ) {
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

        return new TemplateReference($bundleName, $matchController[1], $matchAction[1],
            $request->getRequestFormat(), $engine);
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
