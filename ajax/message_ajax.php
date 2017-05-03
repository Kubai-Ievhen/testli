<?php
/**
 * Created by PhpStorm.
 * User: oem
 * Date: 02.05.17
 * Time: 13:48
 */
include_once ('../controllers/MessageController.php');

if($_SERVER["REQUEST_METHOD"] == 'POST'){
    $message = new MessageController();
    $data='';

    if ($_REQUEST['type'] == 'get'){
        $data = $message->getMessages();
    } elseif ($_REQUEST['type'] == 'add'){
        $data = $message->addMessage();
    } elseif ($_REQUEST['type'] == 'edit'){
        $data = $message->editMessage();
    } elseif ($_REQUEST['type'] == 'delete'){
        $data = $message->deleteMessage();
    }

    echo json_encode($data);
}
