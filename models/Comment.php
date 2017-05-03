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



    //Вернуть все коментарии для сообщений
    public function getAllComments($messages_id=[]){

        $array_in = '';
        foreach ($messages_id as $message_id){
            $array_in .= "'$message_id',";
        }
        $array_in = substr($array_in, 0, -1);

        $sql = "SELECT comments.content,
                       comments.id,
                       comments.message_id,
                       DATE_FORMAT(comments.created_at, '%e/%m/%y %k:%i') as date_time,
                       users.name as username,
                       users.photo,
                       users.id as user_id,
                       users.social_id
                FROM comments
                LEFT JOIN users
                ON comments.user_id=users.id
                WHERE comments.message_id IN ($array_in)
                ORDER BY comments.created_at";

        return $this->getAllResult($sql);
    }
}