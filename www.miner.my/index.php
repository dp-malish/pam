<?php
namespace lib\Def;
/*
Error_Reporting(E_ALL & ~E_NOTICE);ini_set('display_errors',1);*/

set_include_path(get_include_path().PATH_SEPARATOR.'../');spl_autoload_register();
$Opt=new Opt('sota');//Def opt

Cache_File::$cash=new Cache_File(['sota'],true);


//$AdminCook=new \lib\user\User();
//$Opt::$loginAdmin=$AdminCook->loginAdmin();




if($_SERVER['REQUEST_URI']!='/'){
    if(Route::requestURI(3)){
        switch(Route::$uri_parts[0]){
            //case 'sota'.Data::DatePass():$AdminCook->setCookieAdmin();Route::$index=1;break;
            //case $Opt::$setting:include'../modul/sota/admin/main.php';break;

            case 'pam':new \incl\miner\pam\Start();break;
            //default:new \incl\sota\shop\DefShop();
        }
    }
}else{Route::$index=1;}if(Route::$module404){Route::modul404();}
//if(Route::$index){include'../modul/win/main.php';}






require '../blocks/miner/common/head.php';
require '../blocks/miner/common/header.php';
require '../blocks/miner/common/l_col.php';
require '../blocks/miner/common/body.php';
require '../blocks/miner/common/footer.php';