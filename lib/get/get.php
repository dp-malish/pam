<?php
namespace lib\Get;
use lib\Def as Def;

class Get{
    function __construct(){if(Def\Opt::$site===''){new Def\Opt();}}

    static function issetGetArr(){//Проверка существования GET запроса
        return(!empty($_GET))?true:false;}

    static function issetGetKey($keys){//Проверка существования в GET запросе ключей (массив)
        $err=false;
        foreach($keys as $key){if(!array_key_exists($key,$_GET)){$err=true;}}
        return($err)?false:true;
    }

}