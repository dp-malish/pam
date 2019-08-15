<?php
/**Def статью показать*/

namespace incl\sota\Def;
use lib\Def as Def;

class DefContent extends ViewArticle{

  function __construct(){
    if(!isset(Def\Route::$uri_parts[1])){
      $this->viewText('def_content','default_img');
    }else Def\Route::$module404=true;
  }

}