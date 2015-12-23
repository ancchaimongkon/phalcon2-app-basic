<?php

use Phalcon\Mvc\User\Component;

class CBaseSystem extends Component {
    
    /* ===========================================================
     * Web Site
     * =========================================================== */
    
    /* เวอร์ชั่นเว็บไซต์ */
    public static $version = '0.0.1';
    
    /* วันที่อัพเดทเว็บไซต์ล่าสุด */
    public static $lastUpdate = '2015-07-21 00:31:25';
    
    /* ชื่อหัวเว็บไซต์ */
    public static $pageTitle = 'Web Application | Phalcon Framework Version 2';
    
    
    /* ===========================================================
     * เปิด / ปิด ระบบ Access Control List (ACL)
     * =========================================================== */
    
    public $securityStart       = true;
    public $securityRealtime    = true; // อัพเดทตลอดเวลา
    
}