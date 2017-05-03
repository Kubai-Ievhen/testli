<?php

/**
 * Created by PhpStorm.
 * User: oem
 * Date: 29.04.17
 * Time: 16:49
 */
namespace Model;
include_once ('Model.php');

class User extends Model
{
    public $isLogin = false;
    public $id = null;
    public $social_id = null;
    public $user_data = null;

    public function __construct($id = null, $social_id = null)
    {
        parent::__construct();

        //name of using table
        $this->tablename = 'users';
        $this->user_data = $this->getUser($social_id);
        $this->isLogin = isset($id)?count($this->user_data)>0:false;

        if($this->isLogin){
            $this->id = $id;
            $this->social_id = $social_id;
        }
    }

    // Данные пользователя
    public function getUser($social_id){
        $sql = "SELECT * FROM $this->tablename WHERE social_id = '$social_id' LIMIT 1";
        return $this->getResult($sql);
    }

    //Обновить данные пользователя, при необходимости
    public function updateUser($new_user_data){
        $name = $new_user_data['first_name'].' '.$new_user_data['last_name'];
        $photo = $new_user_data['photo'];
        $social_id = $new_user_data['uid'];
        $sql = "UPDATE $this->tablename SET `name`= '$name', photo = '$photo'  WHERE social_id = '$social_id' LIMIT 1";
        return $this->getResult($sql);
    }

    // Добавить нового пользователя
    public function addNewUser($user_data){
        $name = $user_data['first_name'].' '.$user_data['last_name'];
        $photo = $user_data['photo'];
        $social_id = $user_data['uid'];
        $sql = "INSERT INTO $this->tablename (`name` , photo, social_id) values ('$name', '$photo', '$social_id')";
        $this->setExecute($sql);
        $user = $this->getUser($social_id);

        $this->isLogin = true;
        $this->id = $user['id'];
        $this->social_id = $user['social_id'];

        return $user;
    }

}