<?php
namespace lib\Def;
class Data{
    static function IntToStrMap($int){return date('Y-m-d',$int);}
    static function IntToStrDate($int){return date('d-m-Y',$int);}
    static function IntToStrTime($int){return date('H:i:s',$int);}
    static function IntToStrDateTime($int){return date('H:i:s d-m-Y',$int);}
    static function StrDateTimeToInt($str){return strtotime($str);}//"2006-07-31 22:45:59"
    static function DatePass(){return date('j')+date('n');}
}