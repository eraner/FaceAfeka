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
        $query = "SELECT username FROM Users WHERE BINARY Username  = '".$username."'";
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

    /** Inserting a new Post.
     * @return true/false.
     * @param $publisher - name of uploader.
     * @param $status - string of status.
     * @param $imgSrc - string representing path to img (can be "").
     * @param $privacy - Public/Private.
     */
    function InsertNewPost($status, $imgSrc, $publisher, $privacy){
        $imgsCount = count($imgSrc);
        $imgsAll = "";
        for ($i =0; $i < $imgsCount; $i++){
            if ($i == 0 ){
                $imgsAll .= $imgSrc[$i];
            }else{
                $imgsAll .= ",".$imgSrc[$i];
            }
        }

        $status = addslashes($status);
        $imgsAll = addslashes($imgsAll);
        $publisher = addslashes($publisher);

        $insert_q = "INSERT INTO Posts (Status, ImgSrc, Publisher, Privacy, Date) VALUES (";
        $insert_q .= "'".$status."', '".$imgsAll."', '".$publisher."', '".$privacy."', now() );";

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
                $c_date = $this->GetFormattedDate($com['Date']);
                $comments[] = new Comment($com['PostID'], $com['Comment'], $com['Username'], $c_date);
            }


            $f_date = $this->GetFormattedDate($row['Date']);
            $posts[] = new PostDetails($row['PostID'], $row['Status'], $row['ImgSrc'], $row['Publisher'],
                $row['Likes'], $f_date, $row['Privacy'], $comments);
        }

        return $posts;
    }

    /**
     * @param $hint  to get sub string.
     * @return array of users matches the hint.
     */
    function GetFilteredUsers($hint){
        $users = array();
        if($hint=='*'){
            $select_query ="SELECT * FROM Users";
        }else
        $select_query ="SELECT * FROM Users WHERE Username like '" . $hint . "%' ORDER BY Username";
        $result = $this->db_query($select_query);

        if(!$result){
            return $users;
        }
        while ($row = $result->fetch_assoc()){
            $users[] = $row['Username'];
        }

        return $users;
    }

    /**
     * Inserting a new Comment.
     * @param $postID
     * @param $comment
     * @param $username
     * @return bool|mysqli_result
     */
    function InsertNewComment($postID, $comment, $username){

        $comment = addslashes($comment);
        $username = addslashes($username);

        $insert_q = "INSERT INTO Comments (PostID, Comment, Username, Date) VALUES (";
        $insert_q .= $postID.", '".$comment."', '".$username."', now() );";

        $result = $this->db_query($insert_q);
        return $result;
    }

    /**
     * make friends.
     * @param $friend1
     * @param $friend2
     * @return bool|mysqli_result
     */
    function MakeFriends($friend1, $friend2){
        $friend1 = addslashes($friend1);
        $friend2 = addslashes($friend2);
        $insert_q = "INSERT INTO friends VALUES ('".$friend1."', '".$friend2."')";

        $result = $this->db_query($insert_q);
        return $result;
    }
    
    function GetFormattedDate($date){
        $temp = DateTime::createFromFormat('Y-m-d H:i:s', $date);
        return date_format($temp, 'F jS Y \a\t g:ia');
    }

    /**
     * @param $postID
     * @return int num of likes.
     *          if -1 - Error.
     */
    function GetLikes($postID){
        $query = "SELECT Likes FROM Posts WHERE PostID = $postID";
        $result = $this->db_query($query);

        if(!$result){
            return -1;
        }
        $row = $result->fetch_assoc();
        return $row['Likes'];
    }

    /**
     * @param $postID
     * @param $likes
     * @return bool|mysqli_result
     */
    function SetLikes($postID, $likes){
        $query = "UPDATE Posts SET Likes = ".$likes." WHERE PostID = ".$postID.";";
        $result = $this->db_query($query);

        if($result)
            return $likes;
        else
            return -1;
    }
}