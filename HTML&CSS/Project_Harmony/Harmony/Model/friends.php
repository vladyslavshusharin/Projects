<?php 

require_once "connector.php";

class Friends{

    public static function getFriends($user_id){
        $db = new Database("127.0.0.1:3306", "root", "root", "vladyslavshusharin");
        $SQL = "SELECT
                    CASE
                    WHEN Friends.User_ID = ?
                    THEN Friends.Friend_ID
                    ELSE Friends.User_ID
                    END AS Other_User_ID,
                    Users.*
                    FROM Friends
                    JOIN Users ON Users.ID = (
                    CASE
                    WHEN Friends.User_ID = ?
                    THEN Friends.Friend_ID
                    ELSE Friends.User_ID
                    END
                    )
                    WHERE (Friends.User_ID = ? OR Friends.Friend_ID = ?) AND Friends.Status = ?
                    GROUP BY Other_User_ID;";
        $result = $db->query($SQL, [$user_id, $user_id, $user_id, $user_id, "accepted"]);
        return $result;
    }

    public static function getPending($user_id){
        $db = new Database("127.0.0.1:3306", "root", "root", "vladyslavshusharin");
        $SQL = "SELECT Friends.Friend_ID, Users.* FROM Friends 
                JOIN Users ON Users.ID = Friends.Friend_ID 
                WHERE  Friends.User_ID = ? AND Friends.Status = ?";
        $result = $db->query($SQL, [$user_id, "pending"]);
        return $result;
    }

    public static function getIncoming($user_id){
        $db = new Database("127.0.0.1:3306", "root", "root", "vladyslavshusharin");
        $SQL = "SELECT Friends.User_ID, Users.* FROM Friends 
                JOIN Users ON Users.ID = Friends.User_ID 
                WHERE Friends.Friend_ID = ? AND Friends.Status = ?";
        $result = $db->query($SQL, [$user_id, "pending"]);
        return $result;
    }

    public static function addFriend($user_id, $incoming_id){
        $db = new Database("127.0.0.1:3306", "root", "root", "vladyslavshusharin");
        $SQL = "UPDATE Friends SET Friends.Status = ? WHERE Friends.User_ID = ? AND Friends.Friend_ID = ?";

        $result = $db->query($SQL, ["accepted", $incoming_id, $user_id]);
        return $result;
    }

    public static function removeFriend($user_id, $friend_id){
        $db = new Database("127.0.0.1:3306", "root", "root", "vladyslavshusharin");
        $SQL = "DELETE FROM Friends WHERE (User_ID = ? AND Friend_ID = ?) 
                                                       OR (User_ID = ? AND Friend_ID = ?)";
        $result = $db->query($SQL, [$user_id, $friend_id, $friend_id, $user_id]);
        return $result;
    }

    public static function sendRequest($user_id, $friend_name){
        $db = new Database("127.0.0.1:3306", "root", "root", "vladyslavshusharin");
        $SQL1 = "SELECT ID FROM Users WHERE Username = ? AND ID != ?";
        $friend_id = $db->query($SQL1, [$friend_name, $user_id])->fetch_assoc();
        $CHECK = "SELECT Friends.User_ID, Friends.Friend_ID from Friends WHERE (User_ID = ? AND Friend_ID = ?) 
                                                                            OR (User_ID = ? AND Friend_ID = ?)";
        $exists = $db->query($CHECK, [$user_id, $friend_id['ID'], $friend_id['ID'], $user_id]);                                                                    

        if($exists->num_rows === 0){
        $SQL2 = "INSERT INTO Friends (`Status`, `User_ID`, `Friend_ID`) VALUES (?, ?, ?)";
        $result = $db->query($SQL2, ["pending", $user_id, $friend_id['ID']]);
        return $result;
        }else{
            return false;
        }
    }



}








?>