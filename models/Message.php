<?php
/**
 * Created by PhpStorm.
 * User: oem
 * Date: 29.04.17
 * Time: 18:05
 */

namespace Model;


class Message extends Model
{
    public $id;

    public function __construct($id = null)
    {
        parent::__construct();

        //name of using table
        $this->tablename = 'messages';

        $this->id = $id;
    }

    // add message
    public function addMessage($content, $user_id){
        $this->addData('content', $content);
        $this->addData('user_id', $user_id);

        $new_message = $this->insertData();

        $this->id = $new_message['id'];

        return $new_message;
    }

    //get all messages
    public function getAllMessage(){
        $this->orderBy('created_at', true);

        return $this->getAll();
    }

    //update messag
    public function updateMessage($content){
        $this->where("id = $this->id");

        return $this->updateData('content', $content);
    }

    //delete message
    public function deleteMessage(){
        return $this->deleteID($this->id);
    }
}