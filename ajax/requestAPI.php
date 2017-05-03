<?php
/**
 * Created by PhpStorm.
 * User: oem
 * Date: 30.04.17
 * Time: 14:39
 */

include_once ('../controllers/UserController.php');

$user = new UserController();

if (!isset($_REQUEST['code'])) {
//Авторизация через VK
    $authorize_url = $user->getLoginURL();
    header("Location: $authorize_url");
} else {
//    Переход на страницу сообщений
    $test = $user->loginUser($_REQUEST['code']);
    header('Location: ../views/message');
}