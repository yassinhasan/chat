<?php

/*
 *  in controller class     public function __get($name)
    {
        return $this->app->getobject($name);
    }

*  ///////////////

    in cookie
        public function domainpath()
    {
        return $this->domainpath = dirname($this->app->request->server("SCRIPT_NAME"));
    }



    ////////////////////
    loader 

        // it will call method in controller like index or add or delete
    public function action($controller,$action,$args)
    {
        
            (object) $obj = $this->controller($controller);
            
            //  $obj->$action($args);
            return call_user_func([$obj , $action], $args);
            // return $obj->$action($args);
        //    return call_user_func_array([$obj,$action],$args);
        //    return call_user_func(array($obj,$action),$args);
      
          
 
    }

    //////////////////

    in route 
        $filterd_args[] = array_map("filter_string",$args[0]);
    $filterd_args[] =  array_map("filter_int",$args[1]);


    ///////////////////

    in session
        public function start()
    {
     
       if(!session_id())
       {
            ini_set("session.use_only_cookies",1);
           session_start();
       }
    }

        public function pull($key)
    {
        $value = $this->get($key);
        $this->remove($key);
        return $value;
    }

        public function destroy()
    {
        session_destroy();
        session_unset();
    }


    in url

        public function link($path)
    {

        $path = \trim($path,"/");
        $path = str_replace("\\", "/" , $path);
        
        $path =  $this->app->request->baseurl().$path;
        return $path;
    }
    public function redirect($path)
    {

        \header("location:".$this->link($path));
        exit;
    }

    ////////////////////

    in valdiation

        public function haserror($input)
    {
        return array_key_exists($input,$this->error);
    }
    public function adderror($input,$message)
    {
        // if it has error before dont add it 
        if(! $this->haserror($input))
        {
            $this->error[$input] = $message;
        }
    }

    //
        public function ismatched($firstinput,$secondinput,$custommessage =null)
    {
        $firstvalue = $this->inputvalue($firstinput);
        $secondvalue = $this->inputvalue($secondinput);

        if($firstvalue !== $secondvalue)
        {
            $message = isset($custommessage) ? $custommessage : sprintf(" %s is not matched with  %s" , $firstinput,$secondinput);
            
            $this->adderror($secondinput,$message);
        }
        return $this;
    }
    //
    
    // $this->validator->("email" , ["users" , "emai"]);
    // first email i will get value from it 
    // sendocd users this is table name
    // "last email " this is column
    public function uniqe($input , array $database,$custommessage = null)
    {
        $tablename = null;
        $column = null;
        $excpeition = null;
        $exception_value = null;
        $inputvalue = $this->inputvalue($input);
        if(count($database) == 2)
        {
            // $this->validator->("email" , ["users" , "emai"]);
            list($tablename , $column) = $database;
            $result = $this->app->db->select($input)->where("$column = ?" , $inputvalue)->fetch($tablename);
        }
         // $this->validator->("email" , ["users" , "email" , "id" , "id"]);
        elseif(count($database) == 4)
        {
            //  $this->validator->uniqe("email",["users","email","userid",$userid]);
            list($tablename , $column , $excpeition , $exception_value) = $database;
            $result = $this->app->db->select($input)->where(" $column = ? AND $excpeition != ? " , $inputvalue,$exception_value)->fetch($tablename);
        }


        /////////// 
        in helper
        if(!function_exists("_e"))
        {
            function _e($value)
            {
                return htmlspecialchars($value);
            }
        }

                    
        if(! function_exists("filter_int"))
        {
            function filter_int($id){
            return filter_var($id,FILTER_SANITIZE_NUMBER_INT);
            }
        }
        if(! function_exists("filter_string"))
        {
            function filter_string($id){
            return filter_var($id,FILTER_SANITIZE_STRING);
            }
        }

        ////////////////
        request
                // $script_name = $this->server("SCRIPT_NAME");
        if(strpos($request_uri,"?") !== false)
        {

            list($request_uri,$query_string) = explode("?",$request_uri);
            
        }

        /////////////
        response
                public function setheaders($key,$value)
        {
            return $this->headers[$key] = $value;
        }

        // header ("name: hasan");

        public function sendheaders()
        {
            foreach($this->headers as $header => $value)
            {
                header("$header: $value");
            }
        }

        ///////////////////
        in model
            public function __get($name)
    {
        return $this->app->getobject($name);
    }

    public function __call($mothod,$args)
    {
        return call_user_func_array([$this->app->db,$mothod],$args);
    }
    public function getall()
    {
        
      return $this->fetchall($this->tablename);
       
    }
    public function getbyid($id)
    {
        
      return $this->where("id = ? " , $id)->fetch($this->tablename);
       
    }

    public function idexists($id)
    {
      
      $id_exists = $this->select($id)->where("id = ? " , $id)->fetch($this->tablename);

    return  $id_exists ? true : false;
    }

        database 


*/