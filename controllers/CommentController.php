<?php

/**
 * Created by PhpStorm.
 * User: oem
 * Date: 29.04.17
 * Time: 20:06
 */
include_once ('../models/Message.php');
include_once ('../controllers/MessageController.php');

class CommentController
{
    private $user;
    private $message;
    private $comment;

    public function __construct()
    {
        $this->message = new MessageController();
        $this->comment = new \Model\Comment();
    }

    //Добавить коментарий
    public function addComment(){
        $this->comment->addComment($_REQUEST['comment'], $this->message->user->user_id, $_REQUEST['message_id']);
        return $this->message->getMessages();
    }

    //Добавить ответ
    public function addResponse(){
        $this->comment->addResponse($_REQUEST['comment'],
                                    $this->message->user->user_id,
                                    $_REQUEST['message_id'],
                                    $_REQUEST['to_comment'],
                                    $_REQUEST['to_user_id'],
                                    $_REQUEST['response_to']);
        return $this->message->getMessages();
    }

    //Изменить коентарий
    public function editComment(){
        $this->comment->editRow($_REQUEST['comment'], $_REQUEST['comment_id']);
        return $this->message->getMessages();
    }

//    Удалить коментарий
    public function deleteComment(){
        $this->comment->deleteRow($_REQUEST['comment_id']);
        return $this->message->getMessages();
    }
}