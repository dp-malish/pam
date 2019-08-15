<?php
/*Отправить JavaScript*/
namespace lib\Js;
use lib\Def as Def;

class Js extends Def\Gzip{
    function SendJs($f){//Просто отправить Jscript
        header("Content-type: text/javascript; charset=UTF-8");header('Cache-Control: public, max-age=14515200');
        $f=$this->SendHTML($f);
        $this->SendGzip($f);
    }
    function SendJsArr($arr){
        header("Content-type: text/javascript; charset=UTF-8");header('Cache-Control: public, max-age=14515200');
        $f=$this->CashArrFile($arr);
        $this->SendGzip($f);
    }
}