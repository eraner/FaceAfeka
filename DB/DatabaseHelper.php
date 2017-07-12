<?php
/**
 * Database class for easy-to-use functions.
 */

class DatabaseHelper {

    const DB_HOST = 'localhost';
    const DB_USERNAME = 'root';
    const DB_PASSWORD = '';
    const DB_NAME = 'FaceAfeka';

    private $connection;

    function __construct()
    {
        $this->connection = mysqli_connect(self::DB_HOST, self::DB_USERNAME, self::DB_PASSWORD, self::DB_NAME );

        if($this->connection === false) {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }

    /** UTILS Functions:  */

    /***
     * Execute the input query and return the result.
     * @param $query
     * @return bool|mysqli_result
     */
    function db_query($query) {

        // Query the database
        $result = mysqli_query($this->connection, $query);

        return $result;
    }

    /* Returns the encrypted password of the given string. */
    function CalculatePassword($pass)
    {
        $pass= $pass.strrev($pass);
        $pass= md5($pass);  //encrypts the password
        return $pass;
    }

    function RegisterUser($user, $pass){
        $c_pass = $this->CalculatePassword($pass);

        $insert_q = "INSERT INTO Users (Username, Password) VALUES (";
        $insert_q .= "'".$user."', '".$c_pass."' );";
        //echo $insert_q;

        $result = $this->db_query($insert_q);

        return $result;
    }


}