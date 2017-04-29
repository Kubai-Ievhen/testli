<?php

/**
 * Created by PhpStorm.
 * User: oem
 * Date: 29.04.17
 * Time: 15:43
 */
//include_once ('../config/config.php');
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

    //Query parameters
    protected $queryParameters = [];

    //Constructor. Connecting to a database via PDO
     public function __construct(){
         // Read the Database parameters
         $db_options = require('../config/config.php');

         // Database parameters
         $this->host = $db_options['host'];
         $this->dbsystem = $db_options['dbsystem'];
         $this->dbname = $db_options['dbname'];
         $this->username = $db_options['username'];
         $this->password = $db_options['password'];

         //Connect to Database
         $this->db = new PDO("$this->dbsystem:host=$this->host;dbname=$this->dbname", $this->username, $this->password);

     }

     //Return the query result. For Select, Update, Insert
     protected function getResult($sql){
        return $this->db->query($sql);
     }

     //Execute the query. For Update, delete, Insert
     public function setExecute($sql){
         return $this->db->exec($sql);
     }

     //Count of query
    protected function getCount(){
        $sql = "SELECT * FROM $this->tablename ".$this->getParameters();
        return $this->setExecute($sql);
    }

     //Get all rows of table
     public function getAll(){
         $sql = "SELECT * FROM $this->tablename ".$this->getParameters();
         return $this->getResult($sql);
     }

     //get one row
     public function getOne(){
         return array_shift($this->getAll());
     }

     // Order By for SQL query
     protected function orderBy($column, $desc = false){
         $column = $this->db->quote($column);
         $this->queryParameters['orderBy'] = "ORDER BY $column ".$desc?'DESC':'';
     }

    // Where for SQL query
    protected function where($condition){
         $this->queryParameters['where'] = "WHERE ($condition) ";
     }

    // Where And for SQL query
    protected function andWhere($condition){
        $this->queryParameters['andWhere'][] = "AND ($condition) ";
    }

    // Get string of all parameters for SQL query
     protected function getParameters(){
         $sql_param='';

         if(isset($this->queryParameters['where'])){
             $sql_param .=' '.$this->queryParameters['where'];
         }

         if(isset($this->queryParameters['andWhere'])){
             $andWheres = $this->queryParameters['andWhere'];
             foreach ($andWheres as $andWhere){
                 $sql_param .=' '.$andWhere;
             }
         }

         if(isset($this->queryParameters['orderBy'])){
             $sql_param .=' '.$this->queryParameters['orderBy'];
         }

         return $sql_param;
     }

     // Add data for write to database
     protected function addData($column, $value){
         $this->queryParameters['add_rows'][] =['column' => $this->db->quote($column),
                                                  'value' => $this->db->quote($value)];
     }

     // write data to database
     protected function insertData(){
             $column_str = $value_str = '';

             $add_rows = $this->queryParameters['add_rows'];

             foreach ($add_rows as $add_row) {
                 $column_str .= $add_row['column'].', ';
                 $value_str .= $add_row['value'].', ';
             }

         $column_str = substr($column_str, 0, -1);
         $value_str = substr($column_str, 0, -1);

         $sql = "INSERT INTO $this->tablename ($column_str) values ($value_str)";

         return $this->getResult($sql);
     }

     protected function updateData($column, $data){
         $column = $this->db->quote($column);
         $data = $this->db->quote($data);

         $sql = "UPDATE $this->tablename SET $column = $data ".$this->getParameters();

         return $this->setExecute($sql);
     }

     public function deleteID($id){
         $id = $this->db->quote($id);

         $this->where("id = $id");

         $sql = "DELETE FROM $this->tablename ".$this->getParameters();

         return $this->setExecute($sql);
     }
}
