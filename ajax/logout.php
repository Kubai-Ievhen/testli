<?php
/**
 * Created by PhpStorm.
 * User: oem
 * Date: 05.05.17
 * Time: 22:22
 */

session_start();
print_r($_SESSION);
print_r($_COOKIE);
session_unset();

unset($_SESSION['user_id']);
unset($_SESSION['user_social_id']);

setcookie('userId','');
setcookie('userSocialId','');

print_r($_SESSION);
print_r($_COOKIE);
session_abort();
header('Location: ../views');