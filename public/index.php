<?php

error_reporting(E_ALL);
date_default_timezone_set('Asia/Bangkok');

use Phalcon\Mvc\Application as WebApplication,
    Phalcon\DI\FactoryDefault as ApplicationManager,
    Phalcon\Config\Adapter\Ini as ConfigIni;

class Application extends WebApplication {
    
    private $config;        // การตั้งค่า Config | by Object Array
    
    // ทำงานอัตโนมัติ
    public function __construct() {
        $this->config = new ConfigIni(APPLICATION_PATH . '/config/main.ini');   // Read the configuration
    }   
    
    /* ลงทะเบียน (Register Services)*/
    private function _registerServices(){
        $debug = new \Phalcon\Debug();
        $debug->listen(Phalcon_Debug);
        $manager = new ApplicationManager();
        include_once APPLICATION_PATH . '/autoloader.php';     // Read auto-loader
        include_once APPLICATION_PATH . '/routers.php';         // Read Router
        include_once APPLICATION_PATH . '/services.php';        // Read services
        $this->setDI($manager);
    }
    
    private function redirect($open = true){
        if(empty($open)){
            echo '<META HTTP-EQUIV="Refresh" CONTENT="0;URL=http://drivesoftcenter.net/">';
            exit();
        }
    }
    
    /* แสดงเว็บแอพพลิเคชั่น (Run Web Application) */
    public function run() {
        try { 
            $this->_registerServices(); 
            echo $this->handle()->getContent();
        } catch(\Phalcon\Exception $e) {
            $this->redirect(DevMode);
            echo 'PhalconException: ' . $e->getMessage();
        } catch (\Exception $e) {
            $this->redirect(DevMode);
            echo 'PhpException: ' . $e->getMessage();
        }
    }
    
}

/* ==================================================
 * กำหนดค่า Default (ค่าเริ่มต้น)
 * ================================================== */

// Path Root (เริ่มต้น)
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(dirname(__FILE__)));
    define('APPLICATION_PATH', ROOT_PATH . '/application');
    define('IMAGE_PATH', ROOT_PATH . '/public/images');
    define('THEME_PATH', ROOT_PATH . '/public/themes');
}

define('Phalcon_Debug', true);  // ต้องการแสดง Debug หรือไม่ (true,false)
define('DevMode', true);        // อยู่ในโหมดพัฒนา หรือไม่ (true,false)

/* ==================================================
 * ลงทะเบียนและแสดงเว็บแอพพลิดเคชั่นยน Web Browser
 * ================================================== */

$application = new Application();
$application->run();