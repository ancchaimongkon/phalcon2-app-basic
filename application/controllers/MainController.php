<?php

class MainController extends CController {

    public function initialize(){
        parent::initialize();
        $this->setAssetsBase();
    }
    
    public function indexAction(){}

}