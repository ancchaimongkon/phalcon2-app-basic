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
    
    $router->add('', array(
        'controller'    => $this->config->router->controllerDefault,
        'action'        => $this->config->router->actionDefault
    ));

    $router->add('/', array(
        'controller'    => $this->config->router->controllerDefault,
        'action'        => $this->config->router->actionDefault
    ));
        
    return $router;
    
});
