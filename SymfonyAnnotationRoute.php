/**
parameters:
    app.routing.loader.annot_dir.class: Symfony\Component\Routing\Loader\AnnotationDirectoryLoader
    app.routing.loader.annot_file.class: Symfony\Component\Routing\Loader\AnnotationFileLoader
    app.routing.loader.annot_class.class: AppBundle\Routing\AnnotatedRouteControllerLoader
services:

    app.routing.loader.annot_class:
        class: '%app.routing.loader.annot_class.class%'
        tags:
            - { name: routing.loader }
        arguments:
            - '@annotation_reader'

    app.routing.loader.annot_dir:
        class: '%app.routing.loader.annot_dir.class%'
        tags:
            - { name: routing.loader }
        arguments:
            - '@file_locator'
            - '@app.routing.loader.annot_class'

    app.routing.loader.annot_file:
        class: '%app.routing.loader.annot_file.class%'
        tags:
            - { name: routing.loader }
        arguments:
            - '@file_locator'
            - '@app.routing.loader.annot_class'
*/

<?php

namespace AppBundle\Routing;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Loader\AnnotationClassLoader;

class AnnotatedRouteControllerLoader extends AnnotationClassLoader
{
    protected function configureRoute(Route $route, \ReflectionClass $class, \ReflectionMethod $method, $annot)
    {
        $route->setDefault('_controller', $class->getName().'::'.$method->getName());

        foreach ($this->reader->getMethodAnnotations($method) as $configuration) {
            $route->setMethods(implode('|', $configuration->getMethods()));
        }
    }

    protected function getGlobals(\ReflectionClass $class)
    {
        $globals = parent::getGlobals($class);

        foreach ($this->reader->getClassAnnotations($class) as $configuration) {
            if ($configuration instanceof Method) {
                $globals['methods'] = array_merge($globals['methods'], $configuration->getMethods());
            }
        }

        return $globals;
    }

    protected function getDefaultRouteName(\ReflectionClass $class, \ReflectionMethod $method)
    {
        $routeName = parent::getDefaultRouteName($class, $method);

        return preg_replace(array(
            '/(bundle|controller)_/',
            '/action(_\d+)?$/',
            '/__/',
        ), array(
            '_',
            '\\1',
            '_',
        ), $routeName);
    }
}


