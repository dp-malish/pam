<?php
/**
 * Created by PhpStorm.
 * User: Дом
 * Date: 17.08.2018
 * Time: 12:13
 */
namespace lib\Def;

class Cache_Arr extends Cache_File{
    protected $dir_arr;

    function __construct($dir=[],$add=false){//задать каталог для кеша
        parent::__construct($dir, $add);
        $this->dir_arr=$this->dir.'arr/';
    }
    /** Взять ассоц массив из файла
     * @param $cache_file_arr string ввод имя файла
     * @return ассоциативный массив arr
     */
    protected function IsSetCacheFileArr($cache_file_arr){
        $cache_file=$this->dir_arr.$cache_file_arr;
        if(file_exists($cache_file))return json_decode(file_get_contents($cache_file),true);
        else return false;
    }
    /** Положить ассоц массив в файл
     * ввод имени файла и ассоцмативного массива
     * @param $cache_file_arr string
     * @param $assoc_arr Array
     * @return true || false
     */
    protected function SetCacheFileArr($cache_file_arr,$assoc_arr){
        return file_put_contents($this->dir_arr.$cache_file_arr,json_encode($assoc_arr));
    }
    /***********************************************************/
    /***********************************************************/
    /***********************************************************/
    /**
     * @param $cache_file_arr Array
     * @param $DBTable string
     * @return Array типа $f[1]["name"]
     */
    function getCacheAssocArr($cache_file_arr,$DBTable){
        $f=$this->IsSetCacheFileArr($cache_file_arr);
        if(!$f){
            $f=SQListatic::arrSQL_('SELECT * FROM '.$DBTable);
            $this->SetCacheFileArr($cache_file_arr,$f);
        }return $f;
    }
    /**
     * @param $cache_file_arr Array
     * @param $DBTable string
     * @return Array типа $f[1]["name"]
     */
    function getCacheAssocArrID($cache_file_arr,$DBTable,$fieldName='id'){
        $f=$this->IsSetCacheFileArr($cache_file_arr);
        if(!$f){
            $temp_arr=SQListatic::arrSQL_('SELECT * FROM '.$DBTable);
            //Пересортировать массив, чтоб вынести Id для поиска
            foreach($temp_arr AS $v){
                $id=$v[$fieldName];
                unset($v[$fieldName]);
                $f[$id]=$v;
            }
            $this->SetCacheFileArr($cache_file_arr,$f);
        }
        return $f;
    }
}