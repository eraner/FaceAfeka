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

    /**
     * Checks if username is available (not exists in DB already).
     * @return false if exists or empty name,
     * @return true if available.
     * @param $username
     */
    function IsUsernameAvailable($username){
        if($username == ''){
            return false;
        }
        $query = "SELECT username FROM Users WHERE Username = '".$username."'";
        $result = $this->db_query($query);
        if(mysqli_num_rows($result) >= 1) {
            /**Not Available*/
            return false;
        }else{
            /** Available*/
            return true;
        }
    }



    function GetUsersFriends($user){
        $friends = array();
        $select_query = "SELECT user2 FROM Friends WHERE (User1 = '".$user."' );";
        $result = $this->db_query($select_query);

        while ($row = $result->fetch_assoc()){
            $friends[] = $row["user2"];
        }

        $select_query = "SELECT user1 FROM Friends WHERE (User2 = '".$user."' );";
        $result = $this->db_query($select_query);
        while ($row = $result->fetch_assoc()){
            $friends[] = $row["user1"];
        }

        return $friends;
    }

    /**
     * @return true/false.
     * @param $publisher - name of uploader.
     * @param $status - string of status.
     * @param $imgSrc - string representing path to img (can be "").
     * @param $privacy - Public/Private.
     */
    function InsertNewPost($status, $imgSrc, $publisher, $privacy){

        $status = addslashes($status);
        $imgSrc = addslashes($imgSrc);
        $publisher = addslashes($publisher);

        $insert_q = "INSERT INTO Posts (Status, ImgSrc, Publisher, Privacy, Date) VALUES (";
        $insert_q .= "'".$status."', '".$imgSrc."', '".$publisher."', '".$privacy."', now() );";

        $result = $this->db_query($insert_q);

        return $result;
    }

    /**@return string which is a list for the query.
     * @param $users
     */
    function MakeUserList($users){
        $numOfUsers = count($users);
        $userList = "( ";
        for($i=1 ; $i < $numOfUsers ; $i++)
            if( $i != $numOfUsers-1 )
                $userList .= "'".$users[$i]."', ";
            else
                $userList .= "'".$users[$i]."' )";

        return $userList;
    }

    /**Gets Array of friends and returns array of posts of friends.
     * first friend is the user all the others are his friends
     * @return PostDetails[] - on success - Array of StatusDetails from requested publisher (can be empty list),
     *          fail return -1;
     * @param $publisher - username of publisher.
     */
    function GetFriendsPosts($friends){
        if($friends==null || count($friends) < 1){
            return -1;
        }
        $posts = array();

        $user = $friends[0];

        $friendsList = $this->MakeUserList($friends);
        echo $friendsList;
        $select_query = "SELECT * FROM Posts WHERE ((Publisher) IN ".$friendsList." AND Privacy='Public') ";
        $select_query .= " OR (Publisher='".$user."') ORDER BY Date DESC;";

        $result = $this->db_query($select_query);

        if(!$result){
            return $posts;
        }

        while ($row = $result->fetch_assoc()){
            $postId = $row['PostID'];
            $comment_query = "SELECT * FROM Comments WHERE (PostID = ".$postId.") ORDER BY Date ASC;;";
            $comments_result = $this->db_query($comment_query);
            $comments = array();
            while ($com = $comments_result->fetch_assoc()){
                $comments[] = new Comment($com['PostID'], $com['Comment'], $com['Username'], $com['Date']);
            }

            $posts[] = new PostDetails($row['Status'], $row['ImgSrc'], $row['Publisher'],
                $row['Likes'], $row['Date'], $row['Privacy'], $comments);
        }

        return $posts;
    }

    /**
     * @param $excludedUsers list of users to exclude from the list
     * @return array of users without the excluded users.
     */
    function GetFilteredUsers($excludedUsers){
        $users = array();
        $excludedUsers = $this->MakeUserList($excludedUsers);

        $select_query = "SELECT Username FROM Friends WHERE Username NOT IN $excludedUsers ";
        $result = $this->db_query($select_query);
        if(!$result){
            return $users;
        }
        while ($row = $result->fetch_assoc()){
            $users[] = $row['Username'];
        }
        return $users;
    }
}