<?php

/**
 * Created by PhpStorm.
 * User: oem
 * Date: 29.04.17
 * Time: 16:49
 */
namespace Model;

class User extends Model
{
    public $isLogin = false;
    public $id = null;
    public $social_id = null;

    public function __construct($id = null, $social_id = null)
    {
        parent::__construct();

        //name of using table
        $this->tablename = 'users';

        $this->isLogin = isset($id)?$this->isLoginUser($id, $social_id):false;

        if($this->isLogin){
            $this->id = $id;
            $this->social_id = $social_id;
        }
    }

    // Add new user
    public function addNewUser($name, $photo, $social_id){
        $this->addData('name', $name);
        $this->addData('photo', $photo);
        $this->addData('social_id', $social_id);

        $user = $this->insertData();

        $this->isLogin = true;
        $this->id = $user['id'];
        $this->social_id = $user['social_id'];

        return $user;
    }

    //Get user
    public function getUserData(){
        $this->where("id = $this->id");
        $this->andWhere("social_id = $this->social_id");

        return $this->getOne();
    }

    //User is login?
    public function isLoginUser($id = null, $social_id = null){
        $id = isset($id)?$id:$this->id;
        $social_id = isset($social_id)?$social_id:$this->social_id;

        $id = $this->db->quote($id);
        $social_id = $this->db->quote($social_id);

        $this->where("id = $id");
        $this->andWhere("social_id = $social_id");

        return $this->getCount()>0;
    }
}