<?php
/**Для работы с таблицей изо*/
namespace lib\Img;

class SqlTableDef{
  static function getImgDirTable($table_name,$arr_img){/**Взять каталог по имени БД*/
    $res=array_search($table_name,$arr_img);
    return $arr_img[($res?$res:0)][2];
  }
}