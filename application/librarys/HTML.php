<?php

use Phalcon\Mvc\User\Component;
use Phalcon\Tag;
use CBaseSystem as System;

class HTML extends Component {
    
    public static function image ($path, $mode = true, $htmlOptions = array()) {
        $pathImage = IMAGE_PATH . '/' . $path;
        if(file_exists($pathImage)){
            if(!empty($mode)){
                list($width, $height) = getimagesize($pathImage); // พบไฟล์
                $htmlOption = array_merge($htmlOptions,array('width' => $width, 'height' => $height, 'alt' => 'example'));
            }else{
                $htmlOption = $htmlOptions;
            }
            if(!empty($htmlOption)){
                return '<img src="/images/' . $path . self::getFileCache() . '"' . self::tagOptions($htmlOption) . ' />';
            }else{
                if(!empty($mode)){
                    return Tag::image(array('/images/' . $path . self::getFileCache(), false, 'width' => $width, 'height' => $height, 'alt' => 'example'));
                }else{
                    return Tag::image(array('/images/' . $path . self::getFileCache(), false, 'alt' => 'example'));
                }
            }
        }else{
            return self::imageDefault($htmlOptions); // ไม่พบไฟล์
        }
    } 
    public static function imageUrl ($path, $mode = true) {
        $pathImage = IMAGE_PATH . '/' . $path;
        if(file_exists($pathImage)){
            if(!empty($mode)){
                return System::$baseUrl . '/images/' . $path . self::getFileCache();
            }else{
                return '/images/' . $path . self::getFileCache();
            }
        } else {
            return self::imageUrlDefault(); // ไม่พบไฟล์
        }
    }
    public static function imageDefault ($htmlOptions = array(),$mode = true) {
        $pathImage = IMAGE_PATH . '/default.png';
        if(!empty($mode)){
            list($width, $height) = getimagesize($pathImage); // พบไฟล์
            $htmlOption = array_merge($htmlOptions,array('width'=>$width,'height'=>$height, 'alt' => 'example'));
        }else{
            $htmlOption = $htmlOptions;
        }
        if(!empty($htmlOption)){
            return '<img src="' . System::$baseUrl . '/images/default.png' . self::getFileCache() . '"'. self::tagOptions($htmlOption) . ' />';
        }else{
            if(!empty($mode)){
                return Tag::image(array('/images/default.png' . self::getFileCache(), false, 'width' => $width, 'height' => $height, 'alt' => 'example'));
            }else{
                return Tag::image(array('/images/default.png' . self::getFileCache(), false, 'alt' => 'example'));
            }
        }
    }
    public static function imageUrlDefault ($mode = true) {
        $pathImage = IMAGE_PATH . '/default.png';
        if(file_exists($pathImage)){
            if(!empty($mode)){
                return System::$baseUrl . '/images/default.png' . self::getFileCache();
            }else{
                return '/images/default.png' . self::getFileCache();
            }
        }
    }
    public static function getFileCache(){
        return '?v=' . System::$version;
    }

    public static function tag ($tag = null, $content = null, $htmlOptions = array()) {
        if (!empty($tag) && !empty($content)) {
            if(empty($htmlOptions)){
                $html = "<{$tag}>";
            }else{
                $html = "<{$tag}" . self::tagOptions($htmlOptions) . ">";
            }
            return "{$html}{$content}</{$tag}>";
        } else {
            return false;
        }
    }
    public static function tagOptions ($htmlOptions = array()) {
        if(!empty($htmlOptions)){
            $attribute = "";
            foreach ($htmlOptions as $key => $value) {
                if(!empty($value)){
                    $attribute .= " {$key}=\"{$value}\"";
                }
            }
            return $attribute;
        }
    }
    
    public static function serachLink($content = null, $htmlOptions = array()){
        if(!empty($content)){
            $linkTag = self::serachLinkSytex($content);
            if(!empty($linkTag)){
                if(!empty($htmlOptions)){
                    $replace = self::tag('a',trim($linkTag['text']),array_merge(array('href'=>$linkTag['link'],'target'=>'_blank'),$htmlOptions));
                }else{
                    $replace = self::tag('a',trim($linkTag['text']),array('href'=>$linkTag['link'],'target'=>'_blank'));
                }
                $html = str_replace($linkTag['search'], $replace, $content);
                unset($linkTag); unset($replace); unset($content);
                if(!empty(self::serachLinkSytex($html))){
                    return self::serachLink($html,$htmlOptions);
                } else { unset($content); return $html; }
            } else { return $content; }
        }
    }
    private static function serachLinkSytex($content = null){
        $start = strpos($content,'[');                  // ค้นหาตำแหน่งของ "["
        $end = strpos($content,']');                  // ค้นหาตำแหน่งของ "]"
        $and = strpos($content,'||');                 // ค้นหาตำแหน่งของ "|"
        if (!empty($start) && !empty($end) && !empty($and)) {
            $search = substr($content, $start, ($end - $start) + 1);
            $link = substr($content, ($start + 1), ($and - $start) - 1);
            $text = substr($content, ($and + 2), ($end - $and) - 2);
            unset($start); unset($end); unset($and); unset($content);
            return array('search' => $search ,'link' => $link, 'text' => $text);
        }else if (!empty($start) && !empty($end) && empty($and)) {
            $search = substr($content, $start, ($end - $start) + 1);
            $link = substr($content, ($start + 1), ($end - $start) - 1);
            unset($start); unset($end); unset($content);
            return array('search' => $search,'link' => $link, 'text' => $link);
        } else { unset($content); return false; }
    }
    
}