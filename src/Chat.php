<?php
namespace MyApp;
require "Config/config.php";
require "App/Lib/autoload.php";

use App\Models\ChatUsersModel;
use App\Models\ChatModel;
use App\Models\ProfileModel;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use App\Models\UsersModel;

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
       $this->clients->attach($conn);
       $token =  $conn->httpRequest->getUri()->getQuery();
       ChatUsersModel::updateConnectionId($token , $conn->resourceId) ;
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {

        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

            $data = json_decode($msg, true);
            if($data['command'] == "private")
            {
                pre($data);
                $fromId = $data['fromId'];
                $toId   = $data['toId'];
                $msg    = $data['msg'];
                $data['created'] = date("Y-m-d H:i:s",time());
                $chatModel = new ChatModel();
                $chatModel->data([
                    "fromId" => $data['fromId'],
                    "toId"   => $data['toId'],
                    "msg "   => $data['msg'],
                    "created" => date("Y-m-d H:i:s",time()) ,
                    "status"   => "read"
                ])->insertData("app_chat");
                $lastMessageId = $chatModel->lastId();
                
                $fromDetails = ChatUsersModel::getByQuery("select   acu.connectionId , au.userName  from app_chat_users acu inner join app_users au 
                 on  au.userId = acu.userId 
                    WHERE  acu.userId =  $fromId ");
                $fromUserName = $fromDetails[0]->userName;
                $toDetails = ChatUsersModel::getByQuery("select  acu.connectionId , au.userName  from app_chat_users acu inner join app_users au 
                on  au.userId = acu.userId 
                   WHERE  acu.userId =  $toId ");
                $toUserName = $toDetails[0]->userName;
                $receiverConnectionId = $toDetails[0]->connectionId;
                // data to send back());
                $tosenddata = [];
                $tosenddata['created'] =  date("Y-m-d H:i:s",time());
                $tosenddata['msg'] = $msg; 
                foreach ($this->clients as $client) {
                    if ($from == $client) {
                        // The sender is not the receiver, send to each client connected
                        $tosenddata['from'] = "Me";
        
                    }else
                    {
                        $tosenddata['from'] = $toUserName; 
                    }
                    // iam online so i open chat and send message so message will appear and sent
                    // iam online and he is open chat 
                    if($client->resourceId == $receiverConnectionId || $client == $from)
                    {
                        $msg = json_encode($tosenddata);
                        $client->send($msg);
                    }// iam not online so $client != from or iam online but not open chat // or he is online but mot open chat
                    if($client->resourceId != $receiverConnectionId AND $client == $from){
                        $chatModel->data([
                            "status" => "unread"
                        ])->where("id = ?"  , $lastMessageId)->updateData();
                    }
                }
            }else if($data['command'] == "close")
            {
                $userId = $data['userId'];
                ChatUsersModel::updateToLogout("userId" , $userId);
                foreach ($this->clients as $client)
                {
                    $msg = [];
                    $msg['loggedout'] = "yes";
                    $client->send(json_encode($msg));
                }
            }
            else if($data['command'] == "login")
            {
                $userId = $data['userId'];
                ChatUsersModel::updateToLogin("userId" , $userId);
                foreach ($this->clients as $client)
                {
                    $msg = [];
                    $msg['login'] = "yes";
                    $client->send(json_encode($msg));
                }
            }

    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        // $onclose = [];
        // $onclose["id"] = $conn->resourceId;
        // foreach ($this->clients as $client) {

        //   $msg = json_encode($onclose);
        //   $client->send($msg);
        // }
        ChatUsersModel::updateToLogout("connectionId" , $conn->resourceId);
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
