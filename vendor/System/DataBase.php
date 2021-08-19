<?php
namespace System;

use PDO;
use PDOException;

class DataBase 
{

    private $app;
    private static $conn = null;
    private $table_name = null;
    private $data  = [];
    private $where= [];
    private $bindparam = [];
    private $lastid;
    private $select;
    private $limit;
    private $offset;
    private $join;
    private $order;
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->connect();
        
    }

    // $sql = "insert into $table_name" set column_name = ? , columne_name2 = ? 
    //         where column = ?";
      
    // $conn->prepare($sql);
    // $conn->binvalue()
    // $conn->execute();




    public function connect()
    {

        if(static::$conn == null)
        {
            $data = require_once("config.php");

            extract($data);
            try {
                static::$conn = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
                static::$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                static::$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
                static::$conn->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND,"SET NAMES utf8");


            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
        else
        {
            return static::$conn;
        }
    }

    public function table($table_name)
    {
        $this->table_name = $table_name;
        return $this;
    }

    public function insert($table_name = null)
    {
        $sql = "insert into ";
        if($this->table_name)
        {
            $sql.=$this->table_name;
        }
        else
        {
            $sql.=$table_name;
        }
        $sql .= " set ";
        if($this->data)
        {
            foreach($this->data as $key=>$value)
            {
                $sql .= " $key = ? ,";
            }
            $sql = rtrim($sql, " ,");
        }
        if($this->where)
        {
            foreach($this->where as $key=>$value)
            {
                $sql .= " $key = ? ,";
            }
            $sql = rtrim($sql, " ,");
        }
          $stmt =$this->query($sql,$this->bindparam);
          $this->lastid = static::$conn->lastInsertId();
          $this->reset();
          if($stmt->rowCount() > 0 )
          {
              return true;
          }
          else
          {
              return false;
          }


    }
    public function data($data)
    {

        if(is_array($data))
        {
            foreach(array_values($data) as $value)
            {
                $this->bindparam[]= $value;
            }
        }
        $this->data = $data;

        return $this;
    }
     public function where($where)
     {

        if(is_array($where))
        {
            foreach(array_values($where) as $value)
            {
                if(is_array($value))
                {
                    $this->bindparam[]= array_merge($this->bindparam , $value);
                }
                $this->bindparam[]= $value;
            }
        }
        $this->where = $where;
        return $this;
     }
     public function query(...$stmt)
     {

        $sql = array_shift($stmt);
        $bindparam = $stmt[0];
        $stmt2 = static::$conn->prepare($sql);
        if(!empty($this->bindparam))
        {
            foreach($bindparam as $key=>$value)
            {
    
                $stmt2->bindValue($key + 1 , $value);
            }
        }
        if($stmt2->execute())
        {
          $this->lastid = static::$conn->lastInsertId();
          $this->reset();
        }
        return $stmt2;
        
     }
     public function reset()
     {
         $this->table_name = null;
         $this->data = null;
         $this->where= null;
         $this->join = null;
         $this->bindparam = null;
     }

     public function update($table_name = null)
     {
         $sql = "update   ";
         if($this->table_name)
         {
             $sql.=$this->table_name;
         }
         else
         {
             $sql.=$table_name;
         }
         $sql .= " set ";
         if($this->data)
         {
            // 'status = offline '
            if(is_array($this->data))
            {
                foreach($this->data as $key=>$value)
                {
                    $sql .= " $key = ? ,";
                }
            }
            else
            {
                $sql .= $this->data;
            }

             $sql = rtrim($sql, " ,");
         }
         if($this->where)
         {
             $sql .= " where ";
            if(is_array($this->where))
            {
                foreach($this->where as $key=>$value)
                {
                    $sql .= " $key  ,";
                }
            }else
            {
                $sql.=$this->where;
            }
             $sql = rtrim($sql, " ,");
         }
         $this->query($sql,$this->bindparam);
         $this->reset();
     }

     public function select($select)
     {
        
        $this->select = $select;
        return $this;
     }

     public function from($table_name)
     {
         $this->table_name = $table_name;
         return $this;
     }
     public function join($join)
     {
        $this->join = $join;
        return $this;
     }
     public function limit($limit)
     {
         $this->limit = $limit;
         return $this;
     }
     public function offset($offset)
     {
         $this->offset = $offset;
         return $this;
     }
     public function order($order)
     {
         $this->order = $order;
         return $this;
     }
     public function prepareSelectStmt()
     {
         $sql = " SELECT ";
         // select " name , age " 
        if($this->select)
        {
            $sql.= $this->select;
        }
        if($this->table_name)
        {
            $sql.= " FROM ".$this->table_name;
        }
        if($this->join)
        {
            $sql.= $this->join;
        }
        if($this->offset)
        {
            $sql.= " OFFSET ".$this->offset;
        }
        if($this->where)
        {
            $sql .= " where ";
           if(is_array($this->where))
           {
               foreach($this->where as $key=>$value)
               {
                   $sql .= " $key  ,";
               }
           }else
           {
               $sql.=$this->where;
           }
            $sql = rtrim($sql, " ,");
        }
        if($this->order)
        {
            $sql.= " ORDER BY ".$this->order;
        }
        if($this->limit)
        {
            $sql.= " LIMIT ".$this->limit;
        }
 
        return $sql;
     }

     public function fetch()
     {
        $sql = $this->prepareSelectStmt();
        $stmt =  $this->query($sql,$this->bindparam);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        $this->reset();
        return $result;
     }
     public function fetchAll()
     {
        $sql = $this->prepareSelectStmt();
        $stmt =  $this->query($sql,$this->bindparam);
        $resultS = $stmt->fetchAll(PDO::FETCH_OBJ);
        $this->reset();
        return $resultS;
     }

     public function delete($table_name = null)
     {
         $sql = "delete  FROM ";
         if($this->table_name)
         {
             $sql.=$this->table_name;
         }
         else
         {
             $sql.=$table_name;
         }
         if($this->where)
         {
             $sql .= " where ";
             // where id != 3
             // [$id => 3]
             // where($id = ? =>  3)
             foreach($this->where as $key=>$value)
             {
                 $sql .= " $key  ,";
             }
             $sql = rtrim($sql, " ,");
         }


         $this->query($sql,$this->bindparam);
         $this->reset();
    }

}