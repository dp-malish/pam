<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 08.05.2019
 * Time: 16:30
 */

namespace incl\miner\Pam;
use lib\Def as Def;

class Start{

    private $table_name='def_content';

    private $title='Ремонт кровли - География работ';
    private $description='';

    private $menu=4;



    function __construct(){
        if(!isset(Def\Route::$uri_parts[1])){
            Def\Opt::$main_content='odfgdiomgjiodg   jijfg ifig if jgijfg ijfig ifgjifj fi ijo';
            //$this->viewList();
        }else Def\Route::$module404=true;
    }

    private function viewList(){
        Def\Opt::$main_content.='<section><h2>'.$this->title.'</h2><div class="cl"></div>'.$this->viewListContent().'<div class="cl"></div></section>';
    }

    private function viewListContent(){
        $res=Def\SQListatic::arrSQL_('SELECT link,title,caption FROM '.$this->table_name.' WHERE menu='.$this->menu);
        if($res){
            $content='';
            foreach($res as $k=>$v){
                $this->description.=$v['title'].', ';//добавить все
                $content.='<div class="fon_c"><a href="/'.$v['link'].'"><h4 class="ac">'.$v['caption'].'</h4></a><div class="cl"></div></div>';
            }

            Def\Opt::$title=$this->title;
            Def\Opt::$description=$this->description.='подробнее...';
            new \incl\stroy\Menu\DefMenu($res['menu']);
            return $content;
        }else Def\Route::$module404=true;
    }
}