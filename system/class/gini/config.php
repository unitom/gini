<?php

namespace Gini {
    
    class Config {
    
        static $items = [];
    
        static function export() {
            return self::$items;
        }
    
        static function import($items){
            self::$items = $items;
        }
    
        static function clear() {
            self::$items = [];    //清空
        }
        
        static function get($key) {
            list($category, $key) = explode('.', $key, 2);
            if ($key === null) return self::$items[$category];            
            return self::$items[$category][$key];
        }
    
        static function set($key, $val) {
            list($category, $key) = explode('.', $key, 2);
            if ($key) {
                if ($val === null) {
                    unset(self::$items[$category][$key]);
                }
                else {
                    self::$items[$category][$key]=$val;
                }
            }
            else {
                if ($val === null) {
                    unset(self::$items[$category]);
                }
                else {
                    self::$items[$category];
                }
            }
        }
        
        static function append($key, $val){
            list($category, $key) = explode('.', $key, 2);
            if (self::$items[$category][$key] === null) {
                self::$items[$category][$key] = $val;
            } 
            elseif (is_array(self::$items[$category][$key])) {
                self::$items[$category][$key][] = $val;
            }
            else {
                self::$items[$category][$key] .= $val;
            }
        }
    
        static function setup() {
            self::clear();
            $exp = 300;
            $config_file = APP_PATH . '/cache/config.json';
            if (file_exists($config_file)) {
                self::$items = (array)@json_decode(file_get_contents($config_file), true);
            }
        }

    }

}

namespace {
    
    function _CONF($key, $value=null) {
        if (is_null($value)) {
            return \Gini\Config::get($key);
        }
        else {
            \Gini\Config::set($key, $value);
        }
    }
    
}