<?php
namespace lib\Def;
class Validator{
	static $ErrorForm=[];static $captcha=null;

	static function html_cod($s){return trim(htmlspecialchars($s,ENT_QUOTES));}
	static function html_decod($s){return htmlspecialchars_decode($s,ENT_QUOTES);}
	static function issetCookie($str){return(isset($_COOKIE[$str]))?self::html_cod($_COOKIE[$str]):false;}
	static function getIp(){return self::html_cod($_SERVER['REMOTE_ADDR']);}
	//**************************
	/*Если $dlina=0 возвращает длинну строки иначе
	проверка на пустую строку(0) или превышающую $dlina (2)
	Если стр в допуске возвращает (1)*/
	static function LengthStr($s,$dlina=0){
	if($s==''){$res=0;}else{
		$res=mb_strlen($s,'UTF-8');
		if($dlina>0){$res<=$dlina?$res=1:$res=2;}
	}return $res;
	}
	//preg_match  true:хорошо  false:плохо
	static function paternInt($s){return(preg_match("/^[0-9]+$/u",$s))?true:false;}
	static function paternIntMinus($s){return(preg_match("/^[0-9\-]+$/u",$s))?true:false;}
	static function paternFloat($s){return(preg_match("/^[0-9\-\.\,]+$/u",$s))?true:false;}
	static function paternStrLink($s){return(preg_match("/^[0-9А-Яа-яЁёa-zA-Z_\-]+$/u",$s))?true:false;}
	static function paternStrRusText($s){return(preg_match("/^[0-9А-Яа-яЁёa-zA-Z_\-\–\n\s\(\)\.,!?:;«»]+$/u",$s))?true:false;}
	static function paternMobTel($s){return(preg_match("/^[0-9\-\+]+$/u",$s))?true:false;}
	//**************************
	static function auditFIO($s){$s=Validator::html_cod($s);$l=self::LengthStr($s,130);
		if($l==0){self::$ErrorForm[]='Незаполненное поле ФИО';return false;}
		elseif($l==2){self::$ErrorForm[]='Максимальная длина поля ФИО - 100 символов';return false;}
		else{if(self::paternStrRusText($s)){return $s;}else{self::$ErrorForm[]='В поле ФИО используются недопустимые символы';return false;}}
	}
	static function auditMail($str){
		$str=Validator::html_cod($str);
		$l=self::LengthStr($str,130);
		if($l==0){self::$ErrorForm[]='Неверно заполненно поле email';return false;}
		elseif($l==2){self::$ErrorForm[]='Максимальная длина поля email - 100 символов';return false;}
		else{
			$str=mb_strtolower($str);
			if(mb_substr_count($str,'@','UTF-8')==1){return $str;}else{
				self::$ErrorForm[]='Не корректно заполненно поле email';return false;
			}
		}
	}
	static function auditText($str,$errField,$dlina=130){
		$str=Validator::html_cod($str);
		$l=self::LengthStr($str,$dlina);
		$printDlina=$dlina-10;
		if($l==0){self::$ErrorForm[]='Незаполненное поле '.$errField;return false;}
		elseif($l==2){self::$ErrorForm[]='Максимальная длина поля '.$errField.' - '.$printDlina.' символов';return false;}
		else{
			if(self::paternStrRusText($str)){return $str;}else{
				self::$ErrorForm[]='В поле '.$errField.' используются недопустимые символы';
				return false;
			}
		}
	}
	static function auditTextArea($str,$errField,$dlina=1030){
		$str=Validator::html_cod($str);
		$l=self::LengthStr($str,$dlina);
		$printDlina=$dlina-30;
		if($l==0){self::$ErrorForm[]='Незаполненное поле '.$errField;return false;}
		elseif($l==2){self::$ErrorForm[]='Максимальная длина поля '.$errField.' - '.$printDlina.' символов';return false;}
		else{return	$str;}
	}
	static function auditCaptcha($str){
		$err=false;
		$captcha=null;
		$str=self::html_cod($str);
		if(self::paternInt($str)){
			self::$captcha=$str;
			$captcha=\lib\img\Captcha::dp_md_hash($str);
		}else{$err=true;}
		$cook=self::issetCookie('dp_ses');
		if(!$cook){$err=true;}elseif($captcha!=$cook){$err=true;}
		if($err){self::$ErrorForm[]='Не верно введена капча';}
		return(!$err)?true:false;
	}
}