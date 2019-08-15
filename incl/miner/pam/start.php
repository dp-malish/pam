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
            $user_agent = $_SERVER["HTTP_USER_AGENT"];
            if (strpos($user_agent, "Firefox") !== false) $browser = "Firefox";
            elseif (strpos($user_agent, "OPR") !== false) $browser = "Opera";
            elseif (strpos($user_agent, "Chrome") !== false) $browser = "Chrome";
            elseif (strpos($user_agent, "MSIE") !== false) $browser = "Internet Explorer";
            elseif (strpos($user_agent, "Safari") !== false) $browser = "Safari";
            else $browser = "Неизвестный";
            Def\Opt::$main_content.="<br>Ваш браузер: $browser ".$user_agent;
            $DB=new Def\SQLi();

            //$user_agent='sd';

            $sql='INSERT INTO user_agent (browser) VALUES ('.$DB->realEscapeStr($user_agent).');';

            $res=$DB->boolSQL($sql);

            if($res)Def\Opt::$main_content.='<br><br>111<br><br>';
            else Def\Opt::$main_content.='<br><br>000<br><br>';

            Def\Opt::$main_content.=$sql.'<br>';
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