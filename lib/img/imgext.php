<?php
namespace lib\Img;
/*
 *
 *
 * */
use lib\Def as Def;

class ImgExt{

    public $img=1;
    public $imgExt=[];
    protected $badf=[".php",".phtml",".php3",".php4",".html",".txt",".lnk"];


    private static $SqlTable='';

    static function SqlTable(){//костыль для разделения файлов сайтов по папкам incl
            self::$SqlTable='incl\\'.Def\Opt::$dir_name_site.'\def\SqlTable';
            self::$SqlTable=self::$SqlTable::IMG;
    }


    static function getImgDir($post){//взять каталог рисунка /img/site/pic.php?id=
        if(self::$SqlTable=='')self::SqlTable();
        $dir=Def\Validator::html_cod($post);
        $count=count(self::$SqlTable);
        if(!Def\Validator::paternInt($dir)){return false;
        }elseif($count>=0 && $count<$dir){return false;
        }else{return self::$SqlTable[$dir][2];}
    }
    static function getImgSection($post){//взять описание каталог рисунка'Общие'
        if(self::$SqlTable=='')self::SqlTable();
        $post=Def\Validator::html_cod($post);
        $count=count(self::$SqlTable);
        if(!Def\Validator::paternInt($post)){return false;
        }elseif($count>=0 && $count<$post){return false;
        }else{return self::$SqlTable[$post][1];}
    }
    static function getMaxIdDir($post){//Узнать максимальное количество картинок в одной таблице БД
        $post=Def\Validator::html_cod($post);
        $table=self::getImgTableName($post);
        if($table){
            $dir=self::getImgDir($post);
            $DB=new Def\SQLi(true);
            $maxId=$DB->intSQL('SELECT id FROM '.$table.' ORDER BY id DESC LIMIT 1');
            if($maxId)return[$dir,$maxId];else{Def\Validator::$ErrorForm[]='Неизвестная ошибка!';return false;}
        }else{Def\Validator::$ErrorForm[]='Ошибочка!';return false;}
    }
    static function getMaxIdDirExt($post){
      if(self::$SqlTable=='')self::SqlTable();
        $res=false;
        $post=Def\Validator::html_cod($post);
        $count=count(self::$SqlTable);
        for($i=0;$i<$count;$i++){if(self::$SqlTable[$i][2]==$post)$res=self::$SqlTable[$i][0];}
        if($res){$DB=new Def\SQLi(true);
            $res=$DB->intSQL('SELECT id FROM '.$res.' ORDER BY id DESC LIMIT 1');
            if($res)return $res;else{Def\Validator::$ErrorForm[]='Неизвестная ошибка!';return false;}
        }else return false;
    }
    function insImg($postTable,$postImg,$upd=0){//загрузить/обновить картинку
        try{
            $err=false;
            if(\lib\Post\Post::issetPostKey([$postTable]) && !empty($_FILES)){
                $table=self::getImgTableName($_POST[$postTable]);
                if($table){
                    if($this->auditBlackListImg($postImg)){
                        $extFile=$this->getImgExt($postImg);
                        if($extFile===false){$err=true;
                        }else{
                            $upd=Def\Validator::html_cod($upd);
                            if(Def\Validator::paternInt($upd)){
                                $content=file_get_contents($_FILES[$postImg]['tmp_name']);
                                unlink($_FILES[$postImg]['tmp_name']);
                                $DB=new Def\SQLi(true);
                                $file_name=$DB->realEscapeStr(Def\Validator::html_cod($_FILES[$postImg]['name']));
                                $content=$DB->realEscapeStr($content);
                                if($upd==0){
                                    if($DB->boolSQL('INSERT INTO '.$table.' VALUES(NULL,'.$file_name.','.$extFile.','.$content.');')){
                                        $this->img=$DB->lastId();
                                    }else{$err=true;}
                                }elseif($upd>0){
                                    $upd=$DB->realEscapeStr($upd);
                                    if($DB->boolSQL('UPDATE '.$table.' SET name_file='.$file_name.',png='.$extFile.',content='.$content.' WHERE id='.$upd.';')){
                                        $this->img=$upd;
                                    }else{$err=true;}
                                }
                            }else{$err=true;}
                        }
                    }else{$err=true;}
                }else{$err=true;}
            }else{$err=true;}
            return($err)?false:true;
        }catch(Exception $e){return false;}
    }
    function insImgExt($postTable,$postImg){//Загрузить группу картинок
        try{
            $err=false;
            if(\lib\Post\Post::issetPostKey([$postTable]) && !empty($_FILES)){
                $table=self::getImgTableName($_POST[$postTable]);
                if($table){
                    $count=count($_FILES[$postImg]['name']);
                    for($i=0;$i<$count;$i++){
                        if($this->auditBlackListImg($postImg,$i)){
                            $extFile=$this->getImgExt($postImg,$i);
                            if($extFile!==false){
                                $content=file_get_contents($_FILES[$postImg]['tmp_name'][$i]);
                                unlink($_FILES[$postImg]['tmp_name'][$i]);
                                $DB=new Def\SQLi(true);
                                $file_name=$DB->realEscapeStr(Def\Validator::html_cod($_FILES[$postImg]['name'][$i]));
                                $content=$DB->realEscapeStr($content);
                                if($DB->boolSQL('INSERT INTO '.$table.' VALUES(NULL,'.$file_name.','.$extFile.','.$content.');')){
                                    $this->imgExt[]=$DB->lastId();
                                }else{Def\Validator::$ErrorForm[]='Ошибка базы данных';}
                            }
                        }
                    }
                    //return $count;
                }else{$err=true;}
            }else{$err=true;}
            return($err)?false:true;
        }catch(Exception $e){return false;}
    }


    static function getImgTableName($post){//Взять название таблицы БД
        if(self::$SqlTable=='')self::SqlTable();
        $table=Def\Validator::html_cod($post);
        $count=count(self::$SqlTable);
        if(!Def\Validator::paternInt($table)){Def\Validator::$ErrorForm[]='не таблица...';return false;
        }elseif($count>=0 && $count<$table){Def\Validator::$ErrorForm[]='не таблица';return false;
        }else{return self::$SqlTable[$table][0];}
    }
    private function auditBlackListImg($postName,$arr=false){//Проверить валидность запрещённых расширений
      $err=false;
        foreach($this->badf as $v){
            if($arr===false){
                if(preg_match("/$v\$/i",$_FILES[$postName]['name'])){Def\Validator::$ErrorForm[]='Вы пытаетесь загрузить недопустимый файл.';$err=true;}
            }else
                if(preg_match("/$v\$/i",$_FILES[$postName]['name'][$arr])){Def\Validator::$ErrorForm[]='Вы пытаетесь загрузить недопустимый файл - '.$_FILES[$postName]['name'][$arr];$err=true;
                }
        }return($err)?false:true;
    }
    private function getImgExt($postName,$arr=false){//Узнать расширение загружаемого рисунка
      $err=false;
        if($arr===false){
            if(substr($_FILES[$postName]['type'],0,5)=='image'){
                $imgInfo=getimagesize($_FILES[$postName]['tmp_name']);
            }else{Def\Validator::$ErrorForm[]='Не доустимый формат изображения';$err=true;}
        }else{
            if(substr($_FILES[$postName]['type'][$arr],0,5)=='image'){
                $imgInfo=getimagesize($_FILES[$postName]['tmp_name'][$arr]);
            }else{Def\Validator::$ErrorForm[]='Не доустимый формат изображения - '.$_FILES[$postName]['name'][$arr];$err=true;}
        }
        if($err)return false;
        else{
            if($imgInfo['mime']=='image/png')return 1;
            elseif($imgInfo['mime']=='image/jpeg')return'NULL';
            else{Def\Validator::$ErrorForm[]='Не доустимое расширение изображения - '.($arr!==false?$_FILES[$postName]['name'][$arr]:'');return false;}
        }
    }

}