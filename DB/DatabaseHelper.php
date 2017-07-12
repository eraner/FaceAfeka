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

    function __destruct()
    {
        mysqli_close($this->connection);
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

    /**
     * Returns the encrypted password of the given string. */
    function CalculatePassword($pass)
    {
        $pass= $pass.strrev($pass);
        $pass= md5($pass);  //encrypts the password
        return $pass;
    }

    /** Common Functions: */

    /***
     * Registering a new user to the system with his username and password.
     * @param $user
     * @param $pass
     * @return bool|mysqli_result
     */
    function RegisterUser($user, $pass){
        $c_pass = $this->CalculatePassword($pass);

        $insert_q = "INSERT INTO Users (Username, Password) VALUES (";
        $insert_q .= "'".$user."', '".$c_pass."' );";
        //echo $insert_q;

        $result = $this->db_query($insert_q);

        return $result;
    }

    /**
     * Check if the user exists in the system by username and password.
     * @return true/false.
     * @param $user
     * @param $pass
     */
    function ValidateUser($user, $pass){
        if ($user == "" || $pass == "")
            return false;

        $c_pass = $this->CalculatePassword($pass);
        $query = "SELECT username FROM Users WHERE (Username = '".$user."'";
        $query .= " AND Password = '".$c_pass."' );";

        $result = $this->db_query($query);
        if (mysqli_num_rows($result) == 1){
            return true;
        }
        return false;
    }
}