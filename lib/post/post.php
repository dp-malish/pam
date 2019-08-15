<?php
/**
 * POST запросы общие ф-ции
 */
namespace lib\Post;
use lib\Def as Def;

class Post{
  function __construct(){if(Def\Opt::$site===''){new Def\Opt();}}

  static function issetPostArr(){//Проверка существования POST запроса
    return(!empty($_POST))?true:false;}

  static function issetPostKey($keys){//Проверка существования в POST запросе ключей (массив)
    $err=false;
    foreach($keys as $key){if(!array_key_exists($key,$_POST)){$err=true;}}
    return($err)?false:true;
  }

  static function answerErrJson($return=false){//Json ответ ошибки на пост запрос
    $answer=['err'=>true];
    $answer['errText']=Def\Validator::$ErrorForm;
    if($return)return $answer; else echo json_encode($answer);
  }
}