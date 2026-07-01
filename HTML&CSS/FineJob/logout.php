<?php
session_start();

$redirect = $_SESSION['previous_page']; //Redirect po logoutu
        if(!empty($redirect)){
            header("Location: $redirect");
        }else{
            header("Location: Main Page/mainpage.php");
        }

unset($_SESSION); //Odstraneni sessionu
session_destroy();
session_write_close();

die;



?>