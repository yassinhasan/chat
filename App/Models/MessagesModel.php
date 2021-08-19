<?php
namespace App\Models;

use System\Models;

class MessagesModel extends Models
{
    protected $tablename = "messages";
    public function insert($id)
    {
        //	id		outgoing_id	incoming_id	msg	msg_time	

        
        $outgoing_id =$this->app->session->get('outgoing_id');
        $msg =$this->app->request->post('msg');
        $result = $this->app->db->data([
            "unique_id" => \time(),
            "outgoing_id" => $outgoing_id,
            "incoming_id" => $id,
            "msg" => $msg,
            'msg_time' => time()
           
        ])->insert($this->tablename);
        return $result;
    }

    public function getMessage($outgoing_id,$incoming_id)
    {
        /*	
	
            id
            unique_id
            msg_time
            outgoing_id
            incoming_id
            msg
            msg_time
            outgoing_id
            incoming_id
            msg
        */
        $messages = $this->app->db->select("*")->from('messages')->where("outgoing_id =$outgoing_id AND incoming_id = $incoming_id OR  outgoing_id =$incoming_id AND incoming_id = $outgoing_id")->fetchAll();
        return $messages;
    }
    
}