<?php 
require "Model/user.php";
require "Model/conversation.php";
require "Model/friends.php";

class UserController{
    public function ShowDashboard(){
        $user_details = User::getUserDetails($_SESSION['user_id'])->fetch_assoc();
        $friends = Friends::getFriends($_SESSION['user_id']);
        $convos = Conversation::getUserConvos($_SESSION['user_id']);
        require "View/harmony.php";
    }

    public function Signin(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $EMAIL = trim($_POST['usermail']);
            $PASS = trim($_POST['pass']);

            $data = User::Login($EMAIL);
            if($data->num_rows === 1){
                $USER_DETAILS = $data->fetch_assoc();
                if(password_verify($PASS, $USER_DETAILS['Password'])){
                    $_SESSION['user_id'] = $USER_DETAILS['ID'];
                    $_SESSION['username'] = $USER_DETAILS['Username'];
                    $_SESSION['usermail'] = $USER_DETAILS['Email'];
                    $_SESSION['nickname'] = $USER_DETAILS['Nickname'];

                    header("Location: index.php");
                }else{
                    $_SESSION['errorMsg'] = "Incorrect credentials";
                    require "View/login.php";
                }
            }else{
                $_SESSION['errorMsg'] = "Incorrect credentials";
                require "View/login.php";
            }
        }else{
            
            require "View/login.php";
        }
        
        
    }

    public function Logout(){
        unset($_SESSION); //Odstraneni sessionu
        session_destroy();
        session_write_close();
        header("Location: index.php");
        die;
    }

    public function LoadDashboard(){
        $user_details = User::getUserDetails($_SESSION['user_id'])->fetch_assoc();
        $friends = Friends::getFriends($_SESSION['user_id']);
        $convos = Conversation::getUserConvos($_SESSION['user_id']);
        require "View/dashboard.php";
    }

    public function LoadSearch(){
        require "View/search.php";
    }

    public function LoadProfile(){
        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            $USER_ID = $_GET['UserID'];

            $user = User::getUserDetails($USER_ID);
            $users_friends = Friends::getFriends($USER_ID);

            if($user->num_rows === 1){
                $user_exist = true;
                $user_details = $user->fetch_assoc();
                require "View/profile.php";
            }else{
                $user_exist = false;
                require "View/profile.php";
            }
        }
        
    }

    public function Signup(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $EMAIL = $_POST['usermail'];
            $USERNAME = $_POST['username'];
            $PASS = $_POST['pass'];
            $NICKNAME = $_POST['nickname'];

            if(!empty($EMAIL) && !empty($USERNAME) && !empty($PASS) && !empty($NICKNAME)){
            $userExist = User::existingUser($EMAIL, $USERNAME);
            if($userExist){
                $errorMsg = "User or email already exists";
                require "View/signup.php";
            }else{
                $HASHPASS = password_hash($PASS, PASSWORD_DEFAULT);
                $createUser = User::CreateUser($USERNAME, $EMAIL, $HASHPASS, $NICKNAME);
                if($createUser){
                    $this->Signin();
                }else{
                    $errorMsg = "Failed creating account";
                    require "View/signup.php";
                }
            }
            }else{
                $errorMsg = "Fill out all fields!";
                require "View/signup.php";
            }

        }else{
            require "View/signup.php";
        }
    }


    public function UpdateProfile(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $NICKNAME = $_POST['new_nickname'];
            $USER_ID = $_SESSION['user_id'];

            if(!empty($NICKNAME)){
            $update = User::setUserDetails($NICKNAME, $USER_ID);
            if($update){
                $updatedMsg = "Updated profile";
                $_SESSION['nickname'] = $NICKNAME;
            }else{
                $errorMsg = "Failed to update";
             }
            }else{
                $errorMsg = "Failed to update";
            }
        }
    }

}

    



?>