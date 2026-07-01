<?php 

require_once "connector.php";

class Message{

    public static function getMessages($convo_id){
        $db = new Database("127.0.0.1:3306", "root", "root", "vladyslavshusharin");
        $SQL = "SELECT Messages.*, Users.Username, Users.Nickname FROM Messages 
                JOIN Users 
                ON Messages.Sender_ID = Users.ID
                WHERE Messages.Conversation_ID = ? ORDER BY ID ASC";
        $result = $db->query($SQL, [$convo_id]);
        return $result;
    }

    public static function sendMessage($convo_id, $sender_id, $message){
        $db = new Database("127.0.0.1:3306", "root", "root", "vladyslavshusharin");
        $SQL = "INSERT INTO Messages (`Conversation_ID`, `Sender_ID`, `Message_content`) VALUES (?, ?, ?)";

        $result = $db->query($SQL, [$convo_id, $sender_id, $message]);
        return $result;
    }



}








?>