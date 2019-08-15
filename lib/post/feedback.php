<?php
namespace lib\Post;
use lib\Def as Def;
class Feedback extends Post{

    static function feedback(){$err=false;
        if(self::issetPostKey(['name','mail','theme','sms','captcha'])){
            if(Def\Validator::auditCaptcha($_POST['captcha'])){
                $name=Def\Validator::auditFIO($_POST['name']);
                if(!$name){$err=true;}
                $mail=Def\Validator::auditMail($_POST['mail']);
                if(!$mail){$err=true;}
                $theme=Def\Validator::auditText($_POST['theme'],'тема');
                if(!$theme){$err=true;}
                $sms=Def\Validator::auditTextArea($_POST['sms'],'сообщение');
                if(!$sms){$err=true;}
                if(!$err){//добавить в БД
                    $ip=Def\Validator::getIp();
                    $DB=new Def\SQLi();
                    $sql='SELECT id FROM feedback WHERE captcha=? AND readed IS NULL';
                    $sql=$DB->realEscape($sql,Def\Validator::$captcha);
                    if($DB->intSQL($sql)!=''){//Ошибка капчи
                      $err=true;
                      Def\Validator::$ErrorForm[]='Не верно введена капча';
                    }else{
                        $sql='INSERT INTO feedback(captcha,name,mail,theme,text,ip,data)VALUES(?,?,?,?,?,?,?)';
                        $param=[Def\Validator::$captcha,$name,$mail,$theme,$sms,$ip,time()];
                        $sql=$DB->realEscape($sql,$param);
                        if(!$DB->boolSQL($sql)){
                          $err=true;
                          Def\Validator::$ErrorForm[]='Ошибка соединения, повторите попытку позже...';}
                    }
                }
            }else{$err=true;}
        }else{$err=true;}
        return($err)?false:true;
    }
}