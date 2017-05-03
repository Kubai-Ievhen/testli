<?php
/**
 * Created by PhpStorm.
 * User: oem
 * Date: 02.05.17
 * Time: 14:28
 */

include_once ('../controllers/UserController.php');

$user = new UserController();
//Данные пользователя
echo json_encode($user->user_data);