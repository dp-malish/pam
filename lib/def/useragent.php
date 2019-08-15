<?php
namespace lib\Def;
class UserAgent{//Проработан
    static $HTTP_USER_AGENT;
    static $isBot=false;

    function __construct(){self::$HTTP_USER_AGENT=Validator::html_cod($_SERVER['HTTP_USER_AGENT']);}
/**************
 * Поисковый робот определить
**************/
    function isBot(){
        $bots=['rambler','googlebot','mediapartners','aport','yahoo','msnbot','mail.ru','yetibot','ask.com','liveinternet.ru','yandexbot','google page speed','bing.com'];
        foreach($bots as $bot){if(mb_stripos(self::$HTTP_USER_AGENT,$bot)!==false){self::$isBot=true;}}
        return self::$isBot;
    }
    /*****************************
     * Определить мобильный гаджет
     *****************************/
    function isMobile(){
        if(isset($_COOKIE['mob'])){
            $mob=htmlspecialchars($_COOKIE['mob'],ENT_QUOTES);
            if(!preg_match("/[^0-1]+/",$mob)){return($mob)?true:false;}else{exit;}
        }else{return $this->mobileDetect();}
    }
    private function mobileDetect(){$mob=0;
        $mob_agent=['ipad','iphone','android','pocket','palm','windows ce','windowsce','cellphone','opera mobi','ipod','small','sharp','sonyericsson','symbian','opera mini','nokia','htc_','samsung','motorola','smartphone','blackberry','playstation portable','tablet browser'];
        $agent=strtolower(self::$HTTP_USER_AGENT);
        foreach($mob_agent as $v){if(strpos($agent,$v)!==false){$mob=1;}}
        setcookie('mob',$mob, time()+28144000,'/','.'.$_SERVER['SERVER_NAME']);
        return $mob;
    }
}