<?php
namespace lib\Def;
class Optsql{
    const DB_HOST="localhost";
    const DB_PREFIX="xxx_";
    const DB_CHARSET="utf8";
    public $db_con;
    function __construct($ext){
        if(!$ext){
            switch($_SERVER['SERVER_NAME']){
            case 'miner.my':$this->db_con=['root','root','miner'];break;
            default:Route::location();
            }
        }else{
            switch($_SERVER['SERVER_NAME']){
                case 'miner.my':$this->db_con=['root','root','miner_img'];break;
                default:Route::location();
            }
        }
    }
}