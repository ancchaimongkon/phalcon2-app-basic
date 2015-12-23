<?php

use Phalcon\Mvc\Url as UrlManager,
	Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter,
	Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter,
	Phalcon\Session\Adapter\Files as SessionAdapter,
	Phalcon\Logger\Adapter\File as LogFile,
	Phalcon\Mvc\View\Engine\Volt as VoltEngine,
	Phalcon\Mvc\View,
	Phalcon\Mvc\Dispatcher;

/* ==================================================
 * กำหนด Url เบื้องต้น
 * The URL component is used to generate all kind of urls in the application
 * ================================================== */

$manager->set('url', function (){
    $url = new UrlManager();
    $url->setBaseUri($this->config->application->baseUri);
    return $url;
}, true);
       
$manager->set('dispatcher', function () use ($manager) {
    $eventsManager = $manager->getShared('eventsManager');
    $dispatcher = new Dispatcher();
    $dispatcher->setEventsManager($eventsManager);
    return $dispatcher;
}); 

/* ==================================================
 * ตั้งค่าการเชื่อมต่อฐานข้อมูล
 * Database connection is created based in the parameters defined in the configuration file
 * ================================================== */

$manager->set('db', function (){
    return new DbAdapter(array(
        'host'      => $this->config->database->host,
        'username'  => $this->config->database->username,
        'password'  => $this->config->database->password,
        'dbname'    => $this->config->database->dbname,
        'options'   => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $this->config->database->charset
        )
    ));
});

$manager->set('view', function () {
    $view = new View();
    $view->setViewsDir(__DIR__ . '/views/');
    $view->setLayoutsDir($this->config->theme->main);
    $view->setTemplateAfter($this->config->application->layoutDefault);
    $view->registerEngines(array(
        '.phtml' => function ($view, $di){
            $volt = new VoltEngine($view, $di);
            $volt->setOptions(array(
                'compiledPath' => APPLICATION_PATH . $this->config->application->cacheDir . "/{$this->moduleName}/",
                'compiledSeparator' => '_'
            ));
            return $volt;
        },
    ));
    return $view;
});

        
/* ==================================================
 * ตั้งค่าการเปิดใช้งาน Session
 * Start the session the first time some component request the session service
 * ================================================== */

$manager->set('session', function () {
    $session = new SessionAdapter();
    $session->start();
    return $session;
});

/* ==================================================
 * กำหนดค่ามาตรฐานข้อมูลของ Phalcon Fraemwork version 2.0.2
 * ================================================== */

// ดึงข้อมูล Config จากไฟล์ public/index.php 
$manager->set('config', function () {
    return $this->config;
}, true);
$manager->set('modelsMetadata', function () {
    return new MetaDataAdapter();
});

// เปิดใช้งานระบบเก็บข้อมูล Log
$manager->set('logger', function () {
    $monthNow = date("Y-m-d",time());
    $pathLog = APPLICATION_PATH . $this->config->application->logsDir . '/' . $monthNow . '.log';
    $logger = new LogFile($pathLog);
    return $logger;
});

/* ==================================================
 * ลงทะเบียน Component & Librarys ที่เราสร้างขึ้นเอง
 * Register an user component
 * ================================================== */

// ดึงข้อมูลหลัก เช่น ข้อมูลการตั้งค่าต่าง ๆ 
$manager->set('base', function(){
    // ex. $this->base->xxxx;
    return new CBaseSystem();
});