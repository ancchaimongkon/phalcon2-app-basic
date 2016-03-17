<?php

use Phalcon\Mvc\Controller;
use CBaseSystem as System;

class CController extends Controller {
    
    public $pageTitle; 

    public function initialize(){
        
        $this->assets->collection('cssHeader');
        $this->assets->collection('jsHeader');
        $this->assets->collection('cssFooter');
        $this->assets->collection('jsFooter');
    }
    
    public function setAssetsBase(){
        
        $this->assets->collection('cssHeader')
            ->addCss($this->getPathAssets('/assets/cyber/style/cyber-build.css'))
            ->addCss($this->getPathAssets('/themes/main/assets/style/theme-build.css'));
        
        $this->assets->collection('jsFooter')
            ->addJs($this->getPathAssets('/vendor/jquery/2.1.4/jquery.min.js'));
        
        /* 
         
        * =========================================================
        * Example
        * =========================================================

        $this->assets
            ->collection('cssHeader')
            ->addCss($this->getPathAssets('/vendor/font-awesome-4.4.0/font-awesome.min.css'))
            ->addCss('http://fonts.googleapis.com/css?family=Nunito:400,300,700',false);
        
        $this->assets
            ->collection('jsFooter')
            ->addJs($this->getPathAssets('/vendor/jquery-2.1.4/jquery.min.js'));
        
        $this->assets
            ->collection('cssHeader')
            ->addCss($this->getPathAssets('/assets/style/font-awesome.min.css'));
        $this->assets
            ->collection('jsFooter')
            ->addJs($this->getPathAssets('/assets/script/scrolltopcontrol.min.js));
         
        */
    }
    
    /* เลือก Theme */
    protected function setTheme($theme){
        $this->view->setLayoutsDir(sprintf('%s/%s/', $this->config->theme->themesDir, $theme)); /* ตำแหน่งเก็บไฟล์ layouts ทั้งหมด */
    }
    
    /* เลือก Layout */
    protected function setLayout($layout){
        $this->view->setTemplateAfter('layouts/' . $layout);
    }
   
    /* ปรับแต่งลิ้งค์ assets */
    protected function getPathAssets($path){
        return $path . '?v=' . System::$version;
    }

    protected function errorPage($code = 404, $message = 'Not Found !'){
        $this->view->statusCode = array($code,$message);
        $this->setLayout('error');
    }
    
}