<?php 
require "Model/conversation.php";

class ConversationController{
    public function LoadConvos(){
        $convo = Conversation::getUserConvos($_SESSION['user_id']);

        require "View/convolist.php";
    }

    public function CreateConvo(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $FRIEND_ID = $_POST['Friend_ID'];
            $USER_ID = $_SESSION['user_id'];
            $convoExist = Conversation::checkUserConvo($FRIEND_ID, $USER_ID);
            if(!$convoExist && $FRIEND_ID != $USER_ID){
                $convo_id = Conversation::createConvo();
                if($convo_id > 0){
                    $adduser = Conversation::addUserToConvo($USER_ID, $convo_id);
                    $addfriend = Conversation::addUserToConvo($FRIEND_ID, $convo_id);
                    if($adduser && $addfriend){
                    
                    }   
                }
            }else{
                $_SESSION['errorMsg'] = "Convo already exists";
            }

            
        }

        
    }

}



?>