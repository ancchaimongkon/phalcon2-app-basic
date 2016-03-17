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
    $view->setViewsDir(__DIR__ . '/views/'); /* ตำแหน่งเก็บไฟล์ views ทั้งหมด */
    $view->setLayoutsDir(sprintf('%s/%s/', $this->config->theme->themesDir, $this->config->theme->themeDefault)); /* ตำแหน่งเก็บไฟล์ layouts ทั้งหมด */
    $view->setTemplateAfter('layouts/' . $this->config->theme->layoutDefault); /* เลือกไฟล์ layout เริ่มต้น*/

    /* สร้างโฟล์เดอร์เก็บไฟล์ cache */
    $cacheDir = sprintf('%s/%s/', APPLICATION_PATH, $this->config->application->cacheDir);
    if (!is_dir($cacheDir)) { mkdir($cacheDir); }

    $view->registerEngines(array(
        '.phtml' => function ($view, $di){
            $volt = new VoltEngine($view, $di);
            $volt->setOptions(array(
                'compiledPath' => sprintf('%s/%s/', APPLICATION_PATH, $this->config->application->cacheDir),
                'compiledSeparator' => '_'
            ));
            return $volt;
        },
    ));

    return $view;

});
        
/* ==================================================
 * ตั้งค่าการเปิดใช้งาน Session
 * ================================================== */

$manager->set('session', function () {
    $session = new SessionAdapter();
    $session->start();
    return $session;
});

/* ==================================================
 * กำหนดค่ามาตรฐานข้อมูลของ Phalcon Fraemwork version 2.0.2
 * ================================================== */

/* ดึงข้อมูล Config */
$manager->set('config', function () {
    return $this->config;
}, true);
$manager->set('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/* เปิดใช้งานระบบเก็บข้อมูล Log */
$manager->set('logger', function (){
    $monthNow = date('Y-m-d',time());
    $pathLog = sprintf('%s/%s/%s.log', APPLICATION_PATH, $this->config->application->logsDir, $monthNow);
    $logger = new LogFile($pathLog);
    return $logger;
});
        
/* ==================================================
 * ลงทะเบียน Component & Librarys ที่เราสร้างขึ้นเอง
 * ================================================== */

/* ดึงข้อมูลหลัก เช่น ข้อมูลการตั้งค่าต่าง ๆ */
$manager->set('base', function(){
    return new CBaseSystem(); // ex. $this->base->xxxx;
});