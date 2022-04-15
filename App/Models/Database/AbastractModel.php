<?php
namespace App\Models\Database;
use App\Models\Database\CommonMehtods;
use PDO;
use Config\connection;


abstract class AbastractModel extends CommonMehtods
{
    public function query(...$query)
    {

        static::$conn = connection::getInstance();
        $sql = array_shift($query);
        
        $stmt = static::$conn->prepare($sql); 
        if(!empty($query))
        {
            if(is_array($query[0]))
            {
                static::$bindings = $query[0];
            }else
            {
                static::$bindings = $query;            
            } 
            if(null !== static::$bindings)
            {
                foreach(static::$bindings as $key => $value)
                {
                    $stmt->bindValue($key +1 , $value);
                }
            }                       
        }   
        try {

            $stmt->execute();
        } catch (\PDOException $e) {
            pre(static::$bindings);
            echo $sql;
            echo $e->getMessage();
        }
        self::$sql = $sql;
        self::$stmt = $stmt;
        return $this;
    }
    public static function byQuery($sql)
    {

        static::$conn = connection::getInstance();
        $stmt = static::$conn->prepare($sql);  
        try {

            $stmt->execute();
        } catch (\PDOException $e) {
            pre(static::$bindings);
            echo $sql;
            echo $e->getMessage();
        }
    }
    /**
     * @return mix|false
     */
    public function fetchAll()
    {
        if(! static::$sql)
        {

            $sql = "";
            if(static::$select)
            {
                $sql .= static::$select;
            }else
            {
                $sql .= "SELECT  * ";
            }
            $sql .= " FROM ";
            if(static::$table)
            {
                $sql .= static::$table ;
            }else
            {
                $sql .= static::$tableName;
            }
            if(static::$where)
            {
                $sql .= static::$where;
            }
            $this->query($sql , static::$bindings);
        }

        $stmt = static::$stmt;
        $results = $stmt->fetchAll(PDO::FETCH_CLASS , static::getClassName());
        if(empty($results) OR  !array($results))
        {
            
            return false;
        }
        return $results;  
        
    }
    public function fetch()
    {
        if(! static::$sql)
        {

            $sql = "";
            if(static::$select)
            {
                $sql .= static::$select;
            }else
            {
                $sql .= "SELECT  * ";
            }
            $sql .= " FROM ";
            if(static::$table)
            {
                $sql .= static::$table ;
            }else
            {
                $sql .= static::$tableName;
            }
            if(static::$where)
            {
                $sql .= static::$where;
            }
            $this->query($sql , static::$bindings);
        }

        $stmt = static::$stmt;
        $results = $stmt->fetchAll(PDO::FETCH_CLASS , static::getClassName());
        $result =  array_shift($results); 
        if(empty($result) OR  !array($result))
        {
            return false;
        }
        return $result;   
    }

    public function insertData($table = null)
    {

       $sql = " INSERT INTO ";
       if($table == null)
       {
           $sql .= static::$tableName." SET " ;
       }else
       {
           $sql .= $table." SET ";
       }
        $sql .= static::$insert ;
        $this->query($sql,static::$bindings);
        $stmt = static::$stmt;
        static::$lastId  = static::$conn->lastInsertId();
        $this->reset();
        return $stmt->rowCount() > 0 ;
    
    }
    public function updateData()
    {

       $sql = " UPDATE  ";
       if(static::$table)
       {
           $sql .= static::$table;
       }else
       {
           $sql .= static::$tableName." SET ";
       }
        if(static::$insert)
        {
            $sql .=static::$insert ;
        }
        if(static::$where)
        {
            $sql .= static::$where;
        }
        
        $this->query($sql,static::$bindings);
        $stmt = static::$stmt;
        static::$lastId  = static::$conn->lastInsertId();
        $this->reset();
        return $stmt->rowCount() > 0 ;
    
    }
    public function deleteData()
    {
        if(! static::$sql)
        {  
             $sql = " DELETE FROM   ";
            if(static::$table)
            {
                $sql .= static::$table;
            }else
            {
                $sql .= static::$tableName."  ";
            }

            if(static::$where)
            {
                $sql .= static::$where;
            }
            $this->query($sql,static::$bindings);
        }
        $stmt = static::$stmt;
        static::$lastId  = static::$conn->lastInsertId();
        $this->reset();
        return $stmt->rowCount() > 0 ;
    
    }
    public  function insert()
    {
        static::$conn = connection::getInstance();
        $sth =  static::$conn->prepare(static::prepareInsertSql());
        $this->bindValues($sth);
        $sth->execute();
       static::$lastId = static::$conn->lastInsertId();
        return $sth->rowCount() > 0 ;
    }
    public  function update($pk)
    {
        static::$conn = connection::getInstance();
        $sth =   static::$conn->prepare(static::prepareUpdateSql($pk));
        $this->bindValues($sth);
        $sth->execute();
        static::$lastId  = static::$conn->lastInsertId();
        return $sth->rowCount() > 0 ;
    }
    public static function delete($pk)
    {
        static::$conn = connection::getInstance();
        $sth =   static::$conn->prepare(static::prepareDeleteSql($pk));
        $sth->execute();
        static::$lastId  = static::$conn->lastInsertId();
        return $sth->rowCount() > 0 ;
    }
    public static function getAll()
    {
        static::$conn = connection::getInstance();
        $sth =   static::$conn->prepare(static::prepareSelectAllSql());
        $sth->execute();
        $results = $sth->fetchAll(PDO::FETCH_CLASS , static::getClassName());
        if(empty($results) OR  !array($results))
        {
            
            return false;
        }
        return $results;        


    }
    public static function getByPk($pk) 
    {
        static::$conn = connection::getInstance();
        $sth =   static::$conn->prepare(self::prepareSelectSql($pk));
        $sth->execute();
        $results = $sth->fetchAll(PDO::FETCH_CLASS , static::getClassName());
        $result =  array_shift($results); 
        if(empty($result) OR  !array($result))
        {
            return false;
        }
        return $result;   
                    
    }
    public static function getBy($select  = null , $where = []) 
    {
        
        static::$conn = connection::getInstance();
        $sth =   static::$conn->prepare(static::prepareBySelectSql($select, $where));
        $sth->execute();
        $results = $sth->fetchAll(PDO::FETCH_CLASS , static::getClassName());
        if(empty($results) OR  !array($results))
        {
            return false;
        }
        return $results;   
                    
    }
    public static function getByQuery($select  = null , $where = [] ) 
    {
        static::$conn = connection::getInstance();
        
        $sth =   static::$conn->prepare(static::prepareQuerySelectSql($select, $where));
        $sth->execute();
        
        $results = $sth->fetchAll(PDO::FETCH_CLASS , static::getClassName());
        if(empty($results) OR  !array($results))
        {
            return false;
        }
        return $results;   
                    
    }

    public static function creatTable($tableName , $option = array() ) 
    {
        static::$conn = connection::getInstance();
        $sql = "
        CREATE  TABLE IF NOT EXISTS  `$tableName` (
            ";

        if(!empty($option))
        {
            foreach($option as $column => $type)
            {
                $sql .= " `$column` $type , ";
            }
        $sql = trim($sql , ", ");
        $sql .= " )" ;   
        }
        $sth =   static::$conn->prepare($sql);
        return$sth->execute();

    }

    public function save($id= null)
    {
        if(null == $id)
        {
            
        }
    }


}