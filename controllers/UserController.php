<?php
/**
 * Created by PhpStorm.
 * User: oem
 * Date: 29.04.17
 * Time: 20:05
 */

include_once ('../models/User.php');
include_once ('VKController.php');

class UserController
{
    public  $user_id;
    public  $user_social_id;
    public  $user;
    public  $user_data;
    private $login_url;
    private $vk;

    public function __construct()
    {
        session_start();
        $this->user_id = isset($_SESSION['user_id'])?$_SESSION['user_id']:isset($_COOKIE['userId'])?$_COOKIE['userId']:null;
        $this->user_social_id = isset($_SESSION['user_social_id'])?$_SESSION['user_social_id']:isset($_COOKIE['userSocialId'])?$_COOKIE['userSocialId']:null;

        $this->user = new \Model\User($this->user_id, $this->user_social_id);

        $this->user_data     = $this->user->user_data;

        $this->vk = new \Controller\VKController();
    }

    // URL авторизации пользователя
    public function getLoginURL(){
        $this->login_url = $this->vk->getAuthorizeURL();
        return $this->login_url;
    }

    //Добавление.авторизация пользователя
    public function loginUser($request_API_code){
        $access_token = $this->vk->getAccess($request_API_code);

        $user_data =[];

        if($access_token != 'error'){
            $user_social_data = $this->vk->api('users.get', array(
                'uid'       => $access_token['user_id'],
                'fields'    => 'uid,first_name,last_name, photo'
            ));

            $this->user_social_id = $user_social_data['response'][0]['uid'];

            $user_data = $this->user->getUser($this->user_social_id);

            if(!empty($user_data)){
                $this->user_id = $user_data['id'];
                $this->user->isLogin = true;

                $name = $user_social_data['response'][0]['first_name'].' '.$user_social_data['response'][0]['last_name'];

                if ($user_data['photo'] != $user_social_data['response'][0]['photo'] || $name != $user_data['name']){
                    $this->user->updateUser($user_social_data['response'][0]);
                }
            } else {
                $this->user->addNewUser($user_social_data['response'][0]);
            }

            $user_data = $this->user->getUser($this->user_social_id);

            $_SESSION['user_id'] = $user_data['id'];
            $_SESSION['user_social_id'] = $user_data['social_id'];

            setcookie('userId', $user_data['id'], time()+6e7);
            setcookie('userSocialId', $user_data['social_id'], time()+6e7);
        }
        return $user_data;
    }
}