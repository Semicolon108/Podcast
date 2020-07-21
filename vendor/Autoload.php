<?php
    spl_autoload_register(function($class){
        $url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        if(strpos($url,'View') !== false){
            if(strpos($url,'Admin') !== false){
                if(strpos($url,'concept-master') !== false){
                    if(strpos($url,'pages') !== false){
                        require_once "../../../../Classes/".$class.".php";
                        return;
                    }elseif(strpos($url,'Login')){
                        require_once "../../../../Classes/".$class.".php";
                        return;
                    }else{
                        require_once "../../../Classes/".$class.".php";
                    }
                }else{
                    require_once "../../Classes/".$class.".php";
                }
            }else{
                require_once "../Classes/".$class.".php";
            }
        }elseif(strpos($url,'Classes')){
            require_once $class.".php";
        }elseif(strpos($url,'src') !== false){
            require_once "../Classes/".$class.".php";
        }
    })
?>