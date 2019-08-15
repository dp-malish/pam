<?php
/**
 * Проверкка неоходимости сжимать файл перед отправкой
 */
namespace lib\Def;
class Gzip extends Cache_File{
    protected function SendGzip($f){//Отправить строку
      //Проверкка неоходимости сжимать строку перед отправкой
        $gzip=Validator::html_cod($_SERVER["HTTP_ACCEPT_ENCODING"]);
        if(strpos($gzip,'x-gzip')!==false)$encoding='x-gzip';
        else if(strpos($gzip,'gzip')!==false)$encoding='gzip';else $encoding=false;
        if($encoding){$l_str=strlen($f);
            if($l_str>2048){header('Content-Encoding: '.$encoding);echo("\x1f\x8b\x08\x00\x00\x00\x00\x00");$f=gzcompress($f,3);
        }}echo $f;
    }
    protected function CashArrFile($arr_file){//Создать и Вернуть кеш массива файлов
        ob_start();
        foreach($arr_file as $v){include $v;}
        $f=ob_get_contents();ob_end_clean();
        return $f;
    }
}