<?php
/**
 * Created by PhpStorm.
 * User: oem
 * Date: 29.04.17
 * Time: 18:05
 */

namespace Model;

include_once ('Comment.php');

class Message extends Model
{
    public function __construct()
    {
        parent::__construct();

        //name of using table
        $this->tablename = 'messages';
    }

    // Добавить сообщение
    public function addMessage($content, $user_id){
        $sql = "INSERT INTO $this->tablename (content , user_id) values ('$content', '$user_id')";

        return $this->setExecute($sql);
    }

    //Вернуть сообщения, с учетом пагинации
    public function getAllMessage($page = 1){

        $limit = $page>0?$page*10:10;

        $sql = "SELECT $this->tablename.id as message_id,
                       $this->tablename.content,
                       DATE_FORMAT($this->tablename.created_at, '%e/%m/%y %k:%i') as date_time,
                       users.name as username,
                       users.photo,
                       users.id as user_id,
                       users.social_id
                FROM $this->tablename
                LEFT JOIN users
                ON $this->tablename.user_id=users.id
                ORDER BY $this->tablename.created_at DESC 
                LIMIT $limit";

        $messages = $this->getAllResult($sql);

        $messages_id =[];
        foreach ($messages as $message){
            $messages_id[] = $message['message_id'];
        }

        $comment = new Comment();
        $comments = $comment->getAllComments($messages_id);
        $responses = $comment->getAllResponses($messages_id);

        if(count($responses)>0){
            foreach ($comments as $key_c=>$comment){
                $comments[$key_c]['responses'] =[];

                if(count($responses)>0){
                    foreach ($responses as $key_r=>$response){
                        if($comment['id'] == $response['to_comment']){
                            $comments[$key_c]['responses'][]=$response;

                            unset($response[$key_r]);
                        }
                    }
                }
            }
        }

        if(count($comments)>0){
            foreach ($messages as $key_m=>$message){
                $messages[$key_m]['comments'] =[];

                if(count($comments)>0){
                    foreach ($comments as $key_c=>$comment){
                        if($message['message_id'] == $comment['message_id']){
                            $messages[$key_m]['comments'][]=$comment;

                            unset($comments[$key_c]);
                        }
                    }
                }
            }
        }

        return $messages;
    }
}