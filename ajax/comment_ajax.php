<?php
/**
 * Created by PhpStorm.
 * User: oem
 * Date: 02.05.17
 * Time: 13:48
 */
include_once ('../controllers/CommentController.php');

if($_SERVER["REQUEST_METHOD"] == 'POST'){

    $comment = new CommentController();
    $data='';

    if ($_REQUEST['type'] == 'add'){
        $data = $comment->addComment();
    } elseif ($_REQUEST['type'] == 'edit'){
        $data = $comment->editComment();
    } elseif ($_REQUEST['type'] == 'delete'){
        $data = $comment->deleteComment();
    }

    echo json_encode($data);
}
