<?php

/**
 * Created by PhpStorm.
 * User: oem
 * Date: 29.04.17
 * Time: 20:05
 */
include_once ('../models/Message.php');
include_once ('../controllers/UserController.php');

class MessageController
{
    public $user;
    private $message;
    private $comment;

    public function __construct()
    {
        $this->message = new \Model\Message();
        $this->comment = new \Model\Comment();
        $this->user = new UserController();
    }

    //Сообщения для отображения
    public function getMessages(){
        $page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
        return $this->message->getAllMessage($page);
    }

    //Добавить сообщение
    public function addMessage(){
        $this->message->addMessage($_REQUEST['message'], $this->user->user_id);
        return $this->getMessages();
    }

    //Изменить сообщение
    public function editMessage(){
        $this->message->editRow($_REQUEST['message'], $_REQUEST['message_id']);
        return $this->getMessages();
    }

    //Удалить сообщение
    public function deleteMessage(){
        $this->message->deleteRow($_REQUEST['message_id']);
        return $this->getMessages();
    }
}