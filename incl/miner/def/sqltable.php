<?php
namespace incl\sota\Def;
class SqlTable extends \lib\Img\SqlTableDef{
    const IMG=[
      ['default_img','Общие','/img/site/pic.php?id=']
    ];
    static function getImgDirTable($table_name,$arr_img=self::IMG){
        return parent::getImgDirTable($table_name,$arr_img);
    }
}