<?php
/**
 * Created by PhpStorm.
 * User: oem
 * Date: 29.04.17
 * Time: 18:57
 */

namespace Model;


class Comment extends Model
{
    public $id;

    private $TYPE_TO_MESS = 0; // if comment to message
    private $TYPE_TO_COMM = 1; // if comment to comment

    public function __construct($id = null)
    {
        parent::__construct();

        //name of using table
        $this->tablename = 'comments';

        $this->id = $id;
    }

    // add comment
    public function addComment($content, $user_id, $message_id, $comment_id=null){
        $this->addData('content', $content);
        $this->addData('user_id', $user_id);

        if (isset($comment_id)){
            $this->addData('comment_id', $comment_id);
        }

        $this->addData('comment_id', $comment_id);
        $this->addData('type', isset($comment_id)?$this->TYPE_TO_COMM:$this->TYPE_TO_MESS);
        $this->addData('message_id', $message_id);

        $new_comment = $this->insertData();

        $this->id = $new_comment['id'];

        return $new_comment;
    }

    //get all Comments
    public function getAllComment(){
        $this->orderBy('created_at', true);

        $comments_mess = $this->getAll();

        return $this->sortOutComments($comments_mess);
    }

    //get comments for message
    public function getMessComment($message_id){
        $this->where("message_id = $message_id");
        $this->orderBy('created_at', true);

        $comments_mess = $this->getAll();

        return $this->sortOutComments($comments_mess);
    }

    // update comment
    public function updateComment($content){
        $this->where("id = $this->id");

        return $this->updateData('content', $content);
    }

    //delete comment
    public function deleteComment(){
        return $this->deleteID($this->id);
    }

    //sort out comment
    private function sortOutComments($comments_mess){

        foreach ($comments_mess as $comment_mess){
            foreach ($comments_mess as $key => $comment_com){
                if($comment_com['type']==1 && $comment_mess['id'] == $comment_com['comment_id']){
                    $comment_mess['comments'][]= $comment_com;
                    unset($comments_mess[$key]);
                }
            }
        }

        return $comments_mess;
    }

}