<?php
/**Вывести список статей в рубрике*/
namespace incl\sota\Def;
use lib\Def as Def;

class ViewList extends ViewArticle{

  private $msg=2;
  private $table_name='def_content';

  private $title='';
  private $description='';
  private $keywords='';

  protected function viewList($table_name_img,$start=1){
    Def\Str_navigation::navigation(Def\Route::$uri_parts[0],$this->table_name,$start,$this->msg,true);
    Def\Opt::$main_content.='<section><h2>Обзоры</h2><div class="fon"><h3>Аксессуары для рыбалки</h3></div>'.Def\Str_navigation::$navigation.'<div class="cl"></div>'.$this->viewListContent($table_name_img,$start).'<div class="cl"></div>'.Def\Str_navigation::$navigation.'</section>';
  }

  private function viewListContent($table_name_img,$start){
    $res=Def\SQListatic::arrSQL_('SELECT id,link,link_name,title,meta_d,meta_k,caption,
	img_s,img_alt_s,img_title_s,short_text FROM '.$this->table_name.' ORDER BY id DESC LIMIT '.Def\Str_navigation::$start_nav.','.$this->msg);
    if($res){
      $content='';
      foreach($res as $k=>$v){
        if($res['img_s']!=''){$img_s='<img class="fl five img_link" src="'.SqlTable::getImgDirTable($table_name_img).$res['img'].'" alt="'.$res['img_alt'].'" title="'.$res['img_title'].'">';}else{$img_s='';}
        $this->description.=$v['link_name'].', ';//добавить все

        $content.='<div class="fon_c"><article>'.$img_s.'<a href="/'.Def\Route::$uri_parts[0].'/'.$v['link'].'"><h4>'.$v['caption'].'</h4></a>'.$v['short_text'].'</article><div class="cl"></div></div>';
      }
      if($start!=1)$this->title.=' страница '.$start;
      Def\Opt::$title=$this->title;
      Def\Opt::$description=$this->description.='подробнее...';
      Def\Opt::$keywords=$this->keywords;

      return $content;
    }else Def\Route::$module404=true;
  }

}