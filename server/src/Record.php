<?php
namespace Srv;

use Srv\DB;

abstract class Record{
    
    static $__tablesToSave = [];
    
    protected static $_TABLE = null;
    protected static $_FIELDS = null;
    
    const INT = 1;
    const VARCHAR = 2;
    const TEXT = 3;
    const BOOL = 4; //tinyint(1)
    const ENUM = 5;
    
    const ERR_NONE = 0;
    const ERR_NOTFOUND = 1;
    
    private $_hash = null;
    private $protectedFields = [];
    private $data = [];
    private $updateData = [];
    private $error = Record::ERR_NONE;
    
    public function __construct($data=[]){
        if(static::$_FIELDS != null){
            foreach(static::$_FIELDS as $name=>$val){
                $this->data[$name] = isset_or($data[$name],$val);
            }
        }
        $this->_hash = md5(microtime().rand(99,9999));
        static::$__tablesToSave[$this->_hash] = $this;
    }
    
    public function __destruct(){
        //Remove from save array
        if(isset(static::$__tablesToSave[$this->_hash]))
            unset(static::$__tablesToSave[$this->_hash]);
    }
    
    public function save($pkey = 'id'){
        if(static::$_TABLE == null)
            throw new \Exception('Please set _TABLE');
        $this->beforeSave();
        $data = $this->data;
        unset($data[$pkey]);
        if(isset($this->data[$pkey]) && $this->data[$pkey]){
            if(!count($this->updateData))
                return;
            $this->beforeUpdate();
            $data = array_outer_combine($data, $this->updateData);
            DB::table(static::$_TABLE)->update($data)->where($pkey, $this->{$pkey})->execute();
            $this->updateData = [];
            $this->afterUpdate();
        }else{
            $this->beforeInsert();
            DB::table(static::$_TABLE)->insert($data)->execute();
            $pkeyid = intval(DB::lastInsertId());
            $this->data[$pkey] = $pkeyid;
            $this->afterInsert($pkeyid);
        }
        $this->afterSave();
    }
    
    public function remove($pkey = 'id'){
        if(!isset($this->data[$pkey]))
            return false;
        DB::table(static::$_TABLE)->delete()->where($pkey, $this->data[$pkey])->execute();
        if(isset(static::$__tablesToSave[$this->_hash]))
            unset(static::$__tablesToSave[$this->_hash]);
        return true;
    }
    
    public static function delete($closure=null){
        $query = DB::table(static::$_TABLE)->delete();
        if(is_callable($closure))
            $closure($query);
        $query->execute();
    }
    
    public static function count($closure=null){
        $query = DB::table(static::$_TABLE)->select();
        if(is_callable($closure))
            $closure($query);
        return $query->count();
    }
    
    public function reset($bypass = ['id']){
        foreach(static::$_FIELDS as $fild=>$val){
            if(in_array($fild, $bypass))
                continue;
            $this->__set($fild, $val);
        }
    }
    
    public static function exists($closure){
        $query = DB::table(static::$_TABLE)->select();
        if(is_callable($closure))
            $closure($query);
        return $query->exists();
    }
    
    public function getColumns(){
        return array_keys(static::$_FIELDS);
    }
    
    public function getLastError(){
        return $this->error;
    }
    
    protected function setPrivateFields($fields){
        $this->protectedFields = $fields;
    }
    
    protected function build($data){
        foreach($data as $n=>$v){
            if(!isset(static::$_FIELDS[$n]))
                continue;
            switch(gettype(static::$_FIELDS[$n])){
                case 'integer': $this->data[$n] = intval($v); break;
                case 'boolean': $this->data[$n] = ($v?true:false); break;
                case 'array': $this->data[$n] = json_decode($v, true); break;
                default: $this->data[$n] = $v; break;
            }
        }
    }
    
    public static function find($closure){
        $class_name = get_called_class();
        $query = DB::table(static::$_TABLE)->select();
        if(is_callable($closure))
            $closure($query);
        $data = $query->one();
        if(!empty($data)){
            $class = new $class_name();
            $class->build($data);
            $class->afterLoad();
            return $class;
        }else
            return FALSE;
    }
    
    public static function findAll($closure=null){
        $class_name = get_called_class();
        $query = DB::table(static::$_TABLE)->select();
        if(is_callable($closure))
            $closure($query);
        $rows = $query->get();
        if(!empty($rows)){
            $arr = [];
            foreach($rows as $data){
                $class = new $class_name();
                $class->build($data);
                $class->afterLoad();
                $arr[] = $class;
            }
            return $arr;
        }else
            return [];
    }
    
    public function __debugInfo(){
        return $this->data;
    }
    
    public function &__get($name){
        if(!array_key_exists($name, $this->data)){
            echo "Record_GET:Undefined column $name.";
            print_r(debug_backtrace());
            exit();
        }
        return $this->data[$name];
    }
    
    public function __set($name, $value){
        if(!array_key_exists($name, $this->data)){
            echo "Record_SET:Undefined column $name.";
            print_r(debug_backtrace());
            exit();
        }
        if(in_array($name, $this->protectedFields))
            throw new \Exception("This database filed is protected. You cant save data in $name");
        $this->updateData[] = $name;
        $this->data[$name] = $value;
    }
    
    public function __unset($name){
        if(isset($this->data[$name]))
            unset($this->data[$name]);
    }
    
    public function __isset($name){
        return isset($this->data[$name]);
    }
    
    public function getData($columns=false){
        if(!is_array($columns))
            return $this->data;
        $data = [];
        foreach($columns as $c)
            if(isset($this->data[$c]))
                $data[$c] = $this->data[$c];
        return $data;
    }
    
    public function setData($data){
        foreach(static::$_FIELDS as $fild=>$val)
            if(isset($data[$fild]))
                $this->__set($fild, $data[$fild]);
    }
    
    public function toString(){
        $str = '';
        foreach($this->data as $name=>$val)
            $str .= "$name = $val".PHP_EOL;
        return $str;
    }
    
    public function toArray($bypass=false){
        return $this->data;
    }
    
    //@Override
    public function afterLoad(){}
    
    //@Override
    public function beforeSave(){}
    
    //@Override
    public function beforeInsert(){}
    
    //@Override
    public function beforeUpdate(){}
    
    //@Override
    public function afterSave(){}
    
    //@Override
    public function afterInsert(){}
    
    //@Override
    public function afterUpdate(){}
    
    public static function __saveAllRecords(){
        foreach(static::$__tablesToSave as $t)
            $t->save();
    }
}