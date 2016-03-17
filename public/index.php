<?php

define('Dev_Mode', true);  // ต้องการแสดง Debug หรือไม่ (true,false)
define('Phalcon_Debug', true);  // ต้องการแสดง Debug หรือไม่ (true,false)

if (Dev_Mode){
    error_reporting(-1);
    ini_set('display_errors', 1);
} else {
    error_reporting(0); 
    ini_set('display_errors','On');
}

date_default_timezone_set('Asia/Bangkok');

use Phalcon\Mvc\Application as WebApplication,
    Phalcon\DI\FactoryDefault as ApplicationManager,
    Phalcon\Config\Adapter\Ini as ConfigIni,
    Phalcon\Debug as ModeDebug;

class Application extends WebApplication {
    
    private $config; // การตั้งค่า Config | by Object Array
    private $manager;
    
    // ทำงานอัตโนมัติ
    public function __construct() {
        $this->config = new ConfigIni(APPLICATION_PATH . '/config/main.ini');   // Read the configuration
    }
    
    /* ลงทะเบียน (Register Services)*/
    private function _registerServices(){
        $debug = new ModeDebug();
        $debug->listen(Phalcon_Debug);
        $this->manager = new ApplicationManager();
        $this->include_file('autoloader.php');      // Autoload Service
        $this->include_file('routers.php');         // Read Router
        $this->include_file('services.php');        // Read services
        $this->setDI($this->manager);
    }
    
    /* แสดงเว็บแอพพลิเคชั่น (Run Web Application) */
    public function run() {
        try { 
            $this->_registerServices(); 
            echo $this->handle()->getContent();
        } catch(\Phalcon\Exception $e) {
            echo 'PhalconException: ' . $e->getMessage(); exit();
        } catch (\Exception $e) {
            echo 'PhpException: ' . $e->getMessage(); exit();
        }
    }
    
    /* ตรวจสอบไฟล์ */
    public function include_file($file = null){
        $pathFile = sprintf('%s/%s', APPLICATION_PATH, $file);
        if (!empty($pathFile) && file_exists($pathFile)){
            $manager = $this->manager;
            include_once $pathFile;
            $this->manager = $manager;
        }
        return false;
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
}

/* ==================================================
 * ลงทะเบียนและแสดงเว็บแอพพลิดเคชั่นยน Web Browser
 * ================================================== */

$application = new Application();
$application->run();