<?php 

require_once "connector.php";

class Conversation{

    public static function getUserConvos($user_id){
         $db = new Database("127.0.0.1:3306", "root", "root", "vladyslavshusharin");
         $SQL = "SELECT Conversation_participants.Conversation_ID,
                       Conversation_participants_SECOND.User_ID, 
                       Users.Username, Users.Nickname
                       FROM Conversation_participants
                       JOIN Conversation_participants AS Conversation_participants_SECOND
                       ON Conversation_participants_SECOND.Conversation_ID = Conversation_participants.Conversation_ID
                       JOIN Users
                       ON Users.ID = Conversation_participants_SECOND.User_ID
                       WHERE Conversation_participants.User_ID = ? AND Conversation_participants_SECOND.User_ID != ?";
        $result = $db->query($SQL, [$user_id, $user_id]);
        return $result;
    }

    public static function checkUserConvo($friend_id, $user_id){
      $db = new Database("127.0.0.1:3306", "root", "root", "vladyslavshusharin");
      $SQL = "SELECT Conversation_participants.Conversation_ID, Conversation_participants_SECOND.User_ID, Users.Username, Users.Nickname
	                FROM Conversation_participants
                    JOIN Conversation_participants AS Conversation_participants_SECOND
	                ON Conversation_participants_SECOND.Conversation_ID = Conversation_participants.Conversation_ID
	                JOIN Users
	                ON Users.ID = Conversation_participants_SECOND.User_ID
                    WHERE Conversation_participants.User_ID = ? AND Conversation_participants_SECOND.User_ID = ?";
      $result = $db->query($SQL, [$friend_id, $user_id]);
      if($result->num_rows > 0){
        return true;
      }else{
        return false;
      }
    }

    public static function createConvo(){
      $db = new Database("127.0.0.1:3306", "root", "root", "vladyslavshusharin");
      $SQL = "INSERT INTO Conversations () VALUES ()";
      $result = $db->query($SQL, []);
      if($result){
        $newID = $db->getInsertId();  
        return $newID;
      }
      
    }

    public static function addUserToConvo($user_id, $convo_id){
      $db = new Database("127.0.0.1:3306", "root", "root", "vladyslavshusharin");
      $SQL = "INSERT INTO Conversation_participants (`User_ID`, `Conversation_ID`) VALUES (?, ?)";
      $result = $db->query($SQL, [$user_id, $convo_id]);
      return $result;
    }



}








?>