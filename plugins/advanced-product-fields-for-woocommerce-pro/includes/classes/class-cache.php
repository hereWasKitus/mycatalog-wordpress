<?php

namespace SW_WAPF_PRO\Includes\Classes {

    class Cache
    {
        protected static $cache = array();
        protected static $clones = array();
		protected static $files = array();

        public static function add_clone($key,$data){
        	self::$clones[$key] = $data;
        }

        public static function get_clone($key) {
        	if(!isset(self::$clones[$key]))
        		return false;

        	return self::$clones[$key];
        }

        public static function set_files($files) {
        	self::$files = $files;
        }

        public static function get_files(){
        	return self::$files;
        }

        public static function set($key, $item) {
            self::$cache[$key] = $item;
        }

        public static function get($key, $default = false) {

            if(!isset(self::$cache[$key]))
                return $default;

            return self::$cache[$key];
        }

        public static function clear() {
            self::$cache = array();
        }

    }
}
