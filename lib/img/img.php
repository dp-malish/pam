<?php
namespace lib\Img;
use lib\Def as Def;
class Img{

    // Изображение отсутствует +
    static function badImg(){
        $im=imagecreatetruecolor(80,30);
        $bgc=imagecolorallocate($im,235,255,205);
        $tc=imagecolorallocate($im,0,0,100);
        imagefilledrectangle($im,0,0,80,30,$bgc);
        imagestring($im,5,4,7,'No image',$tc);
        header("Content-type: image/png");header('Cache-Control: public, max-age=100');
        imagepng($im,NULL,2);
    }// Изображение отсутствует конец


    /**************
     * @param int $id
     * @param string $DBTable
     * @param string $font
     *
     * Взять изо из БД
     *
     *************/
    //SQL
    static function getImg($id=1,$DBTable='default_img',$font='../../../img/font/Rosamunda Two.ttf'){
        try{$DB=new Def\SQLi(true);$mob=new Def\UserAgent();$mob=$mob->isMobile();
            $res=$DB->strSQL('SELECT png,content FROM '.$DBTable.' WHERE id ='.$DB->realEscapeStr($id));
            if(!$res){self::badImg();}else{
                ($res['png']=='1')?header('Content-Type: image/png'):header('Content-Type: image/jpeg');
                header('Cache-Control: public, max-age=29030400');
                $im=imagecreatefromstring($res['content']);
                if(!is_null($font)){
                $x=imagesx($im);$y=imagesy($im);
                ($x>1000)?$koef_font=25:$koef_font=12;$font_size=(int)($x/$koef_font);
                ($x>1000)?$rotate=8:$rotate=1;
                ($x>1000)?$koef_sdviga=0.38:$koef_sdviga=0.55;$x=$x-($x*$koef_sdviga);
                $y=$y-($y*0.043);
                $color=imagecolorallocate($im,255,215,0);
                $text=$_SERVER['HTTP_HOST'];
                imagettftext($im,$font_size,$rotate,$x,$y,$color,$font,$text);}
                if($res['png']=='1'){($mob)?imagepng($im,NULL,6):imagepng($im,NULL,1);}
                else{($mob)?imagejpeg($im,NULL,59):imagejpeg($im,NULL,91);}imagedestroy($im);
            }
        }catch(Exception $e){}
    }
    //End SQL
/************************************
* Работа с изо из каталога
************************************/
    //Взять изо Jpg из каталога +
    static function getImgJpg($img,$dir){
        $ext=false;
        if(file_exists($dir.$img.'.jpg'))$ext='.jpg';
        elseif(file_exists($dir.$img.'.jpeg'))$ext='.jpeg';
        else self::badImg();
        if($ext){
            $mob=new Def\UserAgent();
            $im=imagecreatefromjpeg($dir.$img.$ext);
            header("Content-type: image/jpeg");header('Cache-Control: public, max-age=29030400');
            ($mob->isMobile())?imagejpeg($im,NULL,49):imagejpeg($im,NULL,70);
            imagedestroy($im);
        }
    }//Взять изо Jpg из каталога конец

    //Взять изо Png8 из каталога
    static function getImgPng8($img,$dir){
        $im=@imagecreatefrompng($dir.$img.'.png');
        if($im){
            $mob=new Def\UserAgent();
            header('Content-Type: image/png');header('Cache-Control: public, max-age=29030400');
            ($mob->isMobile())?imagepng($im,NULL,6):imagepng($im,NULL,3);
            imagedestroy($im);
        }else self::badImg();
    }//Взять изо Png8 из каталога конец

    //Взять изо Png24 из каталога
    static function getImgPng24($img,$dir){
        if(file_exists($dir.$img.'.png')){
            $i=@imagecreatefrompng($dir.$img.'.png');
            $mob=new Def\UserAgent();
            imageAlphaBlending($i,true);
            imageSaveAlpha($i,true);
            header('Content-Type: image/png');header('Cache-Control: public, max-age=29030400');
            ($mob->isMobile())?imagepng($i,NULL,6):imagepng($i,NULL,3);
            imagedestroy($i);
        }else self::badImg();
    }//Взять изо Png24 из каталога конец
}