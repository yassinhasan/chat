<?php
namespace App\Models\Database;
use PDO;
class CommonMehtods  
{
    protected static $primaryKey;
    protected static $tableName;
    protected static $lastId;
    protected static $stmt  = null;
    protected static $sql  = null;
    public  static  $conn = null;
    protected static $bindings = [];
    protected static $where  = [];
    protected static $data = [] ;
    protected static $join = [];
    protected static $select ;
    protected static $table;
    protected static $insert;
    const FILTER_STR = PDO::PARAM_STR;
    const FILTER_INT = PDO::PARAM_INT;
    const FILTER_BOOL = PDO::PARAM_BOOL;
    const FILTER_FLOAT = 4;

    public function reset()
    {
        static::$bindings = null;
        static::$where = null;
    }
    public function table($table)
    {
        static::$table = $table;
        return $this;
    }
    public function from($table)
    {
        static::$table = $table;
        return $this;
    }
    public function data(array $data)
    {
        $sql = ""; 
        foreach($data as $key=>$value)
        {
                
                $sql .= $key. " = ? , ";
                $this->addToBindings($value);
        }
        $sql = trim($sql , ", ");
        static::$insert = $sql;
        return $this;
    }
    public function select($select = null)
    {
        $sql = " SELECT ";
        if($select)
        {
            $sql .= $select;
        }else
        {
             $sql .= " * ";
        }
        static::$select = $sql;
        return $this;
    }
    public function where(...$where)
    {
        static::$where = " WHERE  ";
        static::$where  .= array_shift($where);
        if(!empty($where))
        {
            if(is_array($where[0]) AND count($where) == 1)
            {
                if(!empty(static::$bindings))
                {
                    static::$bindings = array_merge(static::$bindings ,  $where[0]);
                }else
                {
                    static::$bindings = $where[0];
                }
            }else
            {
            
                static::$bindings[ ] =$where[0];
            }            
        }
        return $this;

    }
    public function addToBindings($value)
    {
     static::$bindings[] = $value;  
    }
    public static function getClassName() : string
    {
       return  get_called_class();
    }
    protected static function prepareBindValues() : string
    {
       
        $sql = "" ;
        foreach(get_called_class()::tableSchema() as $schemma => $filter)
        {
           $sql .= " `$schemma`" . " = :$schemma , ";
        }
        return trim($sql, ", ");
    }
    protected static function prepareInsertSql() : string
    {
        $sql = " INSERT INTO  " .get_called_class()::$tableName . " SET  ";
        $sql .= static::prepareBindValues(get_called_class()::tableSchema());
        return $sql;
    }
    protected static function prepareUpdateSql($pk): string
    {
        $sql = " UPDATE  " .get_called_class()::$tableName . " SET  ";
        $sql .= self::prepareBindValues(get_called_class()::tableSchema());
        $sql .= " WHERE ".static::$primaryKey. " = ".  $pk; 
        return $sql;
    }
    protected static  function prepareDeleteSql($pk): string
    {
        $sql = " DELETE FROM  " .get_called_class()::$tableName;
        $sql .= " WHERE ".static::$primaryKey. " = ".  $pk; 
        return $sql;
    }
    protected static  function prepareSelectAllSql(): string
    {
        $sql = " SELECT * FROM  " .get_called_class()::$tableName ;
        return $sql;
    }
    protected static  function prepareSelectSql($key): string
    {
        $sql = " SELECT * FROM  " .get_called_class()::$tableName;
        $sql .= " WHERE ".static::$primaryKey. " = ".  $key; 
        return $sql;
    }
    protected static  function prepareBySelectSql($select, array $wheres  = []): string
    {

        $sql = " SELECT " ;
        if(!$select)
        {
             $sql .= " * " ;   
        }else
        {
            $sql .= "$select" ;
        }
        $sql .= " FROM  ".get_called_class()::$tableName;
        if(!empty($wheres))
        {
            $sql .=" WHERE ";

            if(array_keys($wheres) !== range(0,count($wheres) -1))
            {
                foreach($wheres  as $key=>$value)
                {
                    if(is_numeric($value))
                    {
                       
                        $sql .= $key." ".$value; 
                    }else
                    {
         
                      $sql .= $key."  ".$value." ";  
                    }
                       
                }            
            }else
            {
                $sql .=  $wheres[0]."  ".$wheres[1];   
            } 
        }
        return $sql;
    }
    protected static  function prepareQuerySelectSql($select, array $wheres  = []): string
    {

        $sql = $select;
        if(!empty($wheres))
        {
            $sql .=" WHERE ";

            if(array_keys($wheres) !== range(0,count($wheres) -1))
            {
                foreach($wheres  as $key=>$value)
                {
                    if(is_numeric($value))
                    {
                        $sql .= $key." ".$value; 
                    }else
                    {
                      $sql .= $key."  ".$value." ";  
                    } 
                }            
            }else
            {
                $sql .=  $wheres[0]." ".$wheres[1];   
            } 
        }
        return $sql;
    }

    public function bindValues($stmt)
    {
        foreach(get_called_class()::tableSchema() as $key => $filter)
        {

            if($filter == 4)
            {
                $sanitizedValue = filter_var( $this->$key, FILTER_SANITIZE_NUMBER_FLOAT , FILTER_FLAG_ALLOW_FRACTION);
                $stmt->bindValue(":$key" , `$sanitizedValue`);
            }
           
            $stmt->bindValue(":$key" , $this->$key, $filter);
        }   
    }
    public function lastId()
    {
        return static::$lastId;
    }

}