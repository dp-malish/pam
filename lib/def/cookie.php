<?php
/**
 * Created by PhpStorm.
 * User: Дом
 * Date: 04.10.2018
 * Time: 16:36
 */

namespace lib\Def;


class Cookie{

    static function setCookie($c_name,$c_val,$c_time_expired=604800){//неделя деф
        /**
         * $c_name - имя куки
         * $c_val - значение куки         *
         * $c_time_expired - кол-во сек. до истечения куков int
        */
        setcookie($c_name,$c_val, time()+$c_time_expired,'/','.'.$_SERVER['SERVER_NAME']);
    }

}