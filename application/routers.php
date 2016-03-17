<?php

use Phalcon\Mvc\Router;

/* ==================================================
 * ลงทะเบียน "เส้นทางเว็บแอพพลิเคชั่น" (Router)
 * Registering a router
 * ================================================== */

$manager->set('router', function() {
    
    $router = new Router();
    $router->setDefaultController($this->config->router->controllerDefault);
    $router->setDefaultAction($this->config->router->actionDefault);
    $router->removeExtraSlashes(TRUE);
    
    $router->add('/:controller/:action/:params', array(
        'controller'    => 1,
        'action'        => 2,
        'params'        => 3
    ));

    $router->add('/:controller/:action/', array(
        'controller'    => 1,
        'action'        => 2
    ));

    $router->add('/:controller/:action', array(
        'controller'    => 1,
        'action'        => 2
    ));

    $router->add('/:controller/', array(
        'controller'    => 1,
        'action'        => $this->config->router->actionDefault
    ));

    $router->add('/:controller', array(
        'controller'    => 1,
        'action'        => $this->config->router->actionDefault
    ));

    $router->add('/', array(
        'controller'    => $this->config->router->controllerDefault,
        'action'        => $this->config->router->actionDefault
    ));
        
    $router->add('', array(
        'controller'    => $this->config->router->controllerDefault,
        'action'        => $this->config->router->actionDefault
    ));
        
    return $router;
    
});
