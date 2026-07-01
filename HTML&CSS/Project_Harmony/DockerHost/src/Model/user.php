<?php 


require_once "db_conn.php";

class User{

    public static function getAll(){
        global $db;
        $SQL = "SELECT Users.ID, Users.Username, Users.Email FROM Users";
        $result = $db->query($SQL, []);
        return $result;
    }

    public static function getUserDetails($user_id){
        global $db;
        $SQL = "SELECT Users.ID, Users.Username, Users.Nickname, Users.Email FROM Users WHERE Users.ID = ?";
        $result = $db->query($SQL, [$user_id]);
        return $result;
    }

    public static function setUserDetails($nickname, $user_id){
        global $db;
        $SQL = "UPDATE Users SET Users.Nickname = ? WHERE Users.ID = ?";
        $result = $db->query($SQL, [$nickname, $user_id]);
        return $result;
    }

    public static function Login($email){
        global $db;
        $SQL = "SELECT * FROM Users WHERE Email = ?";
        $result = $db->query($SQL, [$email]);
        return $result;
    }

    public static function getUser($user_id){
        global $db;
        $SQL = "SELECT Users.ID, Users.Username, Users.Nickname FROM Users WHERE Users.ID = ?";
        $result = $db->query($SQL, [$user_id]);
        return $result;
    }

    public static function existingUser($mail, $username){
        global $db;
        $SQL = "SELECT * FROM Users WHERE Email = ? OR Username = ?";
        $result = $db->query($SQL, [$mail, $username])->fetch_assoc();
        if($result){
            return true;
        }
        if(!$result){
            return false;
        }
    }

    public static function CreateUser($username, $mail, $pass, $nickname){
        global $db;
        $SQL = "INSERT INTO Users (`Username`, `Email`, `Password`, `Nickname`) VALUES (?, ?, ?, ?)";
        $result = $db->query($SQL, [$username, $mail, $pass, $nickname]);
        return $result;
    }

}








?>