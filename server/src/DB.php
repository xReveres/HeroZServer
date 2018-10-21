<?php
namespace Srv;

use PDO;
use Srv\Config;
use \ClanCats\Hydrahon\Builder;
use \ClanCats\Hydrahon\Query\Sql\FetchableInterface;

class DB{
    
    static $connection;
    static $db;
    
    public static $queryLog = [];
    
    public static function __init(){
        if(Config::get('database.type') === 'mysql')
            static::$connection = new PDO('mysql:host='.Config::get('database.hostname').';dbname='.Config::get('database.database'), Config::get('database.username'), Config::get('database.password'));
        else
            static::$connection = new PDO('sqlite:'.(BASE_DIR.'/data/'.Config::get('database.file','database').'.sqlite'));
        static::$connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
        static::$connection->exec('SET NAMES '.Config::get('database.charset'));

        static::$db = new Builder('mysql', function($query, $queryString, $queryParameters)
        {
            $statement = static::$connection->prepare($queryString);
            $statement->execute($queryParameters);
            if(intval($statement->errorCode()) != 0){
                static::$queryLog[] = ['error'=>$statement->errorInfo(), 'query'=>$queryString];
            }else
                static::$queryLog[] = $queryString;
            //file_put_contents(SERVER_DIR.'/log.txt',$queryString.PHP_EOL.implode(',',$statement->errorInfo()).PHP_EOL.PHP_EOL,FILE_APPEND);
            
            if ($query instanceof FetchableInterface)
                return $statement->fetchAll(PDO::FETCH_ASSOC);
        });
    }
    
    public static function table($table){
        if(Config::exists('database.prefix') && strlen(Config::get('database.prefix')))
            $prefix = rtrim(Config::get('database.prefix'),'_').'_';
        else
            $prefix = '';
        return static::$db->table($prefix.$table);
    }
    
    public static function sql($sql, $data=false){
        static::$queryLog[] = $sql;
        if(!$data)
            $stmt = static::$connection->query($sql);
        else{
            $stmt = static::$connection->prepare($sql);
            $stmt->execute($data);
        }
        return $stmt;
    }
    
    public static function quote($string){
        return static::$connection->quote($string);
    }
    
    public static function errorCode(){
        return static::$connection->errorCode();
    }
    
    public static function errorInfo(){
        return static::$connection->errorInfo()?:'';
    }
    
    public static function currDatetime(){
        return date('Y-m-d H:i:s');
    }
    
    public static function Func(){
        return call_user_func_array(
            array(new \ReflectionClass('\ClanCats\Hydrahon\Query\Sql\Func'), 'newInstance'),
            func_get_args()
        );
    }
    
    public static function Expr(){
        return call_user_func_array(
            array(new \ReflectionClass('\ClanCats\Hydrahon\Query\Expression'), 'newInstance'),
            func_get_args()
        );
    }
    
    public static function lastInsertId(){
        return static::$connection->lastInsertId();
    }
    
    public static function debugQueryLog(){
        return static::$queryLog;
    }
}