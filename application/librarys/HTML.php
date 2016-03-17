<?php

/* 
 * HTML Library v1.0.0
 * Updated : 2016-03-17 21:48
 * -------------------------------------------------------------
 * Eakkabin Jaikeawma <eakkabin@drivesoft.co>
 * Website : https://drivesoft.co/
 * -------------------------------------------------------------
 */

use Phalcon\Mvc\User\Component;
use CBaseSystem as System;

class HTML extends Component {
    
    private static $cacheVersion = '1.0.0';

    public static function image ($path, $htmlOptions = ['alt' => 'images']) {
        $pathImage = IMAGE_PATH . '/' . $path;
        if (file_exists($pathImage) && !is_dir($pathImage)) {
            list($width, $height) = getimagesize($pathImage); // พบไฟล์
            $htmlOption = array_merge(['width' => $width, 'height' => $height], $htmlOptions);
            return HTML::tag('img', System::$urlImage . $path . HTML::getFileCache(), $htmlOption);
        } else {
            return self::imageDefault($htmlOptions); // ไม่พบไฟล์
        }
    } 
    public static function imageUrl ($path) {
        $pathImage = IMAGE_PATH . '/' . $path;
        if (file_exists($pathImage) && !is_dir($pathImage)) {
            return System::$urlImage . $path . HTML::getFileCache();
        } else {
            return self::imageUrlDefault(); // ไม่พบไฟล์
        }
    }
    public static function imageDefault ($htmlOptions = ['alt' => 'images']) {
        $pathImage = IMAGE_PATH . '/default.png';
        if (file_exists($pathImage) && !is_dir($pathImage)) {
            list($width, $height) = getimagesize($pathImage); // พบไฟล์
            $htmlOption = array_merge(['width' => $width, 'height' => $height], $htmlOptions);
            return HTML::tag('img', System::$urlImage . 'default.png' . HTML::getFileCache(), $htmlOption);
        }
    }
    public static function imageUrlDefault () {
        $pathImage = IMAGE_PATH . '/default.png';
        if(file_exists($pathImage) && !is_dir($pathImage)){
            list($width, $height) = getimagesize($pathImage); // พบไฟล์
            return HTML::tag('img', System::$urlImage . 'default.png' . HTML::getFileCache(), ['width' => $width, 'height' => $height]);
        }
    }
    public static function getFileCache(){
        if (!empty(System::$version)){
            return '?v=' . System::$version;
        } else {
            return '?v=' . HTML::$cacheVersion;
        }
    }

    public static function tag ($tag = null, $content = null, $htmlOptions = []) {
        if (!empty($tag)) {
            if ($tag == 'img' || $tag == 'input') {
                return sprintf('<%s src="%s" %s />', $tag, $content, HTML::tagOptions($htmlOptions));
            } else {
                return sprintf('<%s %s>%s</%s>', $tag, HTML::tagOptions($htmlOptions), $content, $tag);
            }
        } else {
            return false;
        }
    }
    public static function tagOptions ($htmlOptions = []) {
        if(!empty($htmlOptions)){
            $attribute = '';
            foreach ($htmlOptions as $property => $value) {
                if(!empty($value)){
                    $attribute .= sprintf(' %s="%s"', $property, $value);
                }
            }
            return $attribute;
        }
    }
    
}