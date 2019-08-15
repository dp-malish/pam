<?php
namespace lib\Def;
/**
 * Str_navigation::navigation($uri_parts[0],'article',1,$msg,true);
 * Str_navigation::navigation($uri_parts[0],'article',$uri_parts[1],$msg,true);
 * Str_navigation::$navigation;
 * @param
 * $uri- для ссылки в навигации
 * $table_name - таблица БД
 * $page - страница отсчёта (где находишься)
 * $msg - кол-во на странице сообщений
 * $fon - с фоном или без
 * @param $nav - разновидность навигации
 */
class Str_navigation{
    public static $navigation=null;//строка навигации
    public static $start_nav=1;
    public static function navigation($uri,$table_name,$page=1,$msg=13,$fon=false,$nav=0){
        if(is_null($uri))$uri='';else $uri=$uri.'/';
        $res=SQListatic::intSQL_('SELECT COUNT(id) FROM '.$table_name);
        if($res){$total=(int)(($res-1)/$msg)+1;
        self::$start_nav=$page*$msg-$msg;
        //Стрелки назад
        if($page!=1){
            $first='<a href="/'.$uri.'" title="Перейти на первую страницу">&lt;&lt;</a>';
            $first_pre='<a href="/'.$uri.($page-1!=1?$page-1:'').'" title="Перейти на предыдущую страницу">&lt;</a>';$pervpage=true;
        }else $pervpage='';
        //Стрелки вперед
        if($page!=$total){
            $last='<a href="/'.$uri.$total.'" title="Перейти на последнюю страницу">&gt;&gt;</a>';
            $last_pre='<a href="/'.$uri.($page+1).'">&gt;</a>';$lastpage=true;
        }else $lastpage='';
        //Находим две ближайшие станицы с обоих краев, если они есть
        $pageoneleft='';
        for($i=1;$i<6;$i++){if($page-$i==1)$pageoneleft='<a href="/'.$uri.'">1</a>';}
        $page4left=($page-4 >1)?'<a href="/'.$uri.($page-4).'">'.($page-4).'</a>':'';
        $page3left=($page-3 >1)?'<a href="/'.$uri.($page-3).'">'.($page-3).'</a>':'';
        $page2left=($page-2 >1)?'<a href="/'.$uri.($page-2).'">'.($page-2).'</a>':'';
        $page1left=($page-1 >1)?'<a href="/'.$uri.($page-1).'">'.($page-1).'</a>':'';
        $page4right=($page+4 <=$total)?'<a href="/'.$uri.($page+4).'">'.($page + 4).'</a>':'';
        $page3right=($page+3 <=$total)?'<a href="/'.$uri.($page+3).'">'.($page + 3).'</a>':'';
        $page2right=($page+2 <=$total)?'<a href="/'.$uri.($page+2).'">'.($page+2).'</a>':'';
        $page1right=($page+1 <=$total)?'<a href="/'.$uri.($page+1).'">'.($page+1).'</a>':'';
        $fon_print=($fon?'fon_c ':'');
        if($total>1 && $total>=$page){
            if($nav==0){
                if($pervpage)$pervpage=$first.'&nbsp;&nbsp;&nbsp;'.$first_pre.'&nbsp;&nbsp;';
                if($lastpage)$lastpage='&nbsp;&nbsp;'.$last_pre.'&nbsp;&nbsp;&nbsp;'.$last;
                if($pageoneleft!='')$pageoneleft.=' | ';
                if($page4left)$page4left.=' | ';
                if($page3left)$page3left.=' | ';
                if($page2left)$page2left.=' | ';
                if($page1left)$page1left.=' | ';
                if($page4right)$page4right=' | '.$page4right;
                if($page3right)$page3right=' | '.$page3right;
                if($page2right)$page2right=' | '.$page2right;
                if($page1right)$page1right=' | '.$page1right;
                self::$navigation='<div class="'.$fon_print.'ac nav_link"><p>'.$pervpage.$pageoneleft.$page4left.$page3left.$page2left.$page1left.'<b>'.$page.'</b>'.$page1right.$page2right.$page3right.$page4right.$lastpage.'</p></div>';
            }else{
                if($pervpage)$pervpage='<span>'.$first.'</span>'.'<span>'.$first_pre.'</span>';
                if($lastpage)$lastpage='<span>'.$last_pre.'</span><span>'.$last.'</span>';
                if($pageoneleft!='')$pageoneleft='<span>'.$pageoneleft.'</span>';
                if($page4left)$page4left='<span>'.$page4left.'</span>';
                if($page3left)$page3left='<span>'.$page3left.'</span>';
                if($page2left)$page2left='<span>'.$page2left.'</span>';
                if($page1left)$page1left='<span>'.$page1left.'</span>';
                if($page4right)$page4right='<span>'.$page4right.'</span>';
                if($page3right)$page3right='<span>'.$page3right.'</span>';
                if($page2right)$page2right='<span>'.$page2right.'</span>';
                if($page1right)$page1right='<span>'.$page1right.'</span>';
                self::$navigation='<div class="'.$fon_print.'nav1">'.$pervpage.$pageoneleft.$page4left.$page3left.$page2left.$page1left.'<span>'.$page.'</span>'.$page1right.$page2right.$page3right.$page4right.$lastpage.'</div>';
            }
        }
    }}
}