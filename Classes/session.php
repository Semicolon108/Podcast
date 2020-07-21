<?php
    class SessionWrapper
    {
        private static $isSessionStarted = false;

        public static function start()
        {
            if(self::$isSessionStarted == false)
            {
                session_start();
                self::$isSessionStarted = true;
            }
        }
        public static function destroy()
        {
            if(self::$isSessionStarted == true)
            {
                session_destroy();
                self::$isSessionStarted == false;
            }
        }
        public static function set($key,$value)
        {
            $_SESSION[$key] = $value;
        }
        public static function get($key)
        {
            if(isset($_SESSION[$key]))
            {
                return $_SESSION[$key];
            }    
        }
    }
?>