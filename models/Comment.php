<?php
/**
 * Created by PhpStorm.
 * User: oem
 * Date: 29.04.17
 * Time: 18:57
 */

namespace Model;

include_once ('Model.php');

class Comment extends Model
{
    public function __construct()
    {
        parent::__construct();

        //name of using table
        $this->tablename = 'comments';
    }

    // Добавить коментарий
    public function addComment($content, $user_id, $message_id){
        $sql = "INSERT INTO $this->tablename (content , user_id, message_id) 
                values ('$content', '$user_id', '$message_id')";

        return $this->setExecute($sql);
    }

    // Добавить ответ
    public function addResponse($content, $user_id, $message_id, $to_comment, $to_user_id, $response_to){
        $sql = "INSERT INTO $this->tablename (content , user_id, message_id, type_comment, to_comment, to_user_id, response_to) 
                values ('$content', '$user_id', '$message_id', '1', '$to_comment', '$to_user_id', '$response_to')";

        return $this->setExecute($sql);
    }

    //Вернуть все коментарии для сообщений
    public function getAllResponses($messages_id=[]){

        $array_in = $this->getArrayIn($messages_id);

        $sql = "SELECT resp.content,
                       comm.content as response_to_cont,
                       resp.id,
                       resp.message_id,
                       resp.to_comment,
                       resp.to_user_id,
                       DATE_FORMAT(resp.created_at, '%e/%m/%y %k:%i') as date_time,
                       u1.name as username,
                       u2.name as tousername,
                       u1.photo,
                       u1.id as user_id,
                       u1.social_id
                FROM $this->tablename as resp
                LEFT JOIN users AS u1
                ON resp.user_id=u1.id
                LEFT JOIN users AS u2
                ON resp.to_user_id=u2.id
                LEFT JOIN $this->tablename AS comm
                ON resp.response_to=comm.id
                WHERE resp.message_id IN ($array_in)
                AND resp.type_comment = 1
                ORDER BY resp.created_at";

        return $this->getAllResult($sql);
    }

    //Вернуть все ответы для коментариев
    public function getAllComments($messages_id=[]){

        $array_in = $this->getArrayIn($messages_id);

        $sql = "SELECT $this->tablename.content,
                       $this->tablename.id,
                       $this->tablename.message_id,
                       DATE_FORMAT($this->tablename.created_at, '%e/%m/%y %k:%i') as date_time,
                       users.name as username,
                       users.photo,
                       users.id as user_id,
                       users.social_id
                FROM $this->tablename
                LEFT JOIN users
                ON $this->tablename.user_id=users.id
                WHERE $this->tablename.message_id IN ($array_in)
                AND type_comment = 0
                ORDER BY $this->tablename.created_at";

        return $this->getAllResult($sql);
    }

    private function getArrayIn($messages_id=[]){
        $array_in = '';

        foreach ($messages_id as $message_id){
            $array_in .= "'$message_id',";
        }

        return substr($array_in, 0, -1);
    }
}