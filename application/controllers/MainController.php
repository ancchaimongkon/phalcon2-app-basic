<?php

class MainController extends CController {

    public function initialize(){
        parent::initialize();
        
        $this->setAssetsBase();
        $this->setTheme('main');
        $this->setLayout('partials/main');
        
        $this->assets->collection('cssHeader')
            ->addCss($this->getPathAssets('/public/themes/main/assets/css/theme-style.css'))
            ->addCss($this->getPathAssets('/public/themes/main/assets/css/theme-responsive.css'));
        
        $this->assets->collection('jsFooter')
            ->addJs($this->getPathAssets('/public/themes/main/assets/js/theme-script.js'));
        
    }
    
    public function indexAction(){

    }

}

