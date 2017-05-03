<?php

/**
 * Created by PhpStorm.
 * User: oem
 * Date: 29.04.17
 * Time: 15:43
 */

namespace Model;

class Model
{
    //host Database
    protected $host = 'localhost';

    //Database management system
    protected $dbsystem = 'mysql';

    //name Database
    protected $dbname = '';

    //Database username
    protected $username = 'root';

    //password of Database username
    protected $password = '';

    //Connection to the database
    protected $db;

    //Table name
    protected $tablename;

    //Constructor. Подключение к БД через API PDO
     public function __construct(){
         // Read the Database parameters
         $db_options = require('../config/DBconfig.php');

         // Database parameters
         $this->host = $db_options['host'];
         $this->dbsystem = $db_options['dbsystem'];
         $this->dbname = $db_options['dbname'];
         $this->username = $db_options['username'];
         $this->password = $db_options['password'];

         //Connect to Database
         $this->db = new \PDO(  "$this->dbsystem:host=$this->host;dbname=$this->dbname", $this->username, $this->password);

     }

     //Запрос в БД. Одним результатом
     protected function getResult($sql){
        $res = $this->db->query($sql);
        return $res->FETCH(\PDO::FETCH_ASSOC);
     }

    //Запрос в БД. Все результаты
     protected function getAllResult($sql){
        $res = $this->db->query($sql);
        return $res->FETCHALL(\PDO::FETCH_ASSOC);
     }

     //Запрос не возвращает результат
     public function setExecute($sql){
         return $this->db->exec($sql);
     }

    // Обновить запись
    public function editRow($content, $id){
        $sql = "UPDATE $this->tablename 
                SET content = '$content', created_at = created_at 
                WHERE (id = '$id')";
        return $this->setExecute($sql);
    }

    // Удалить запись
    public function deleteRow($id){
        $sql = "DELETE FROM $this->tablename
                WHERE id = '$id'";
        return $this->setExecute($sql);
    }
}
