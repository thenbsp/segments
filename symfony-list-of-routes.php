<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $router     = $this->get('router');
        $collection = $router->getRouteCollection();
    
        $routes = array();

        foreach ($collection->all() as $routeName => $route) {

            $method = empty($route->getMethods())
                ? 'ANY'
                : implode(', ', $route->getMethods());

            $scheme = empty($route->getSchemes())
                ? 'ANY'
                : implode(', ', $route->getSchemes());

            $host = empty($route->getHost())
                ? 'ANY'
                : $route->getPath();

            $routes[] = array(
                'name'      => $routeName,
                'method'    => $method,
                'scheme'    => $scheme,
                'host'      => $host,
                'path'      => $route->getPath()
            );
        }

        return $this->render('UserBundle:Default:index.html.twig', array(
            'routes' => $routes
        ));
    }
}
