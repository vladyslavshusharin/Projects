<?php 
session_start();
require "db_conn.php";
$prevpage = $_SESSION['previous_page'];

if($_SESSION['user_id']){

$userid = $_SESSION['user_id'];
$showdata = "SELECT * FROM ucet WHERE ID = ?";

$result = $db->query($showdata,[$userid]);
$PROFILDATA = $result->fetch_assoc();


if($_SERVER['REQUEST_METHOD'] == "POST"){

$PASS = trim($_POST['pass']);

if(!empty($PASS)){
    if(password_verify($PASS, $PROFILDATA['Heslo'])){
        try{
          $DELETESUBDATA1 = "DELETE FROM nabidky WHERE Ucet_ID = ?";
          $deletesubresult1 = $db->query($DELETESUBDATA1, [$userid]);

          $DELETESUBDATA2 = "DELETE FROM hodnoceni WHERE Ucet_ID = ?";
          $deletesubresult2 = $db->query($DELETESUBDATA2, [$userid]);

          $DELETESUBDATA3 = "DELETE FROM zpravy WHERE Prijimac_ID = ? OR Posilac_ID = ?";
          $deletesubresult3 = $db->query($DELETESUBDATA3, [$userid, $userid]);

          $DELETDATA = "DELETE FROM ucet WHERE ID = ?";
          $deleteresult = $db->query($DELETDATA, [$userid]);
          if($deletesubresult1 && $deletesubresult2 && $deletesubresult3 && $deleteresult){
            header("Location: logout.php");

          }else{throw new Exception("Nepodařilo se odstranit účet");}

        }catch(Exception $e){
         $_SESSION['delete_message'] = $e->getMessage();
         header("Location: $prevpage");
         exit();
         }

     }else{$_SESSION['delete_message'] = "Špatné heslo";
           header("Location: $prevpage");
           exit();}
   }else{$_SESSION['delete_message'] = "Zadejte heslo";
         header("Location: $prevpage");
         exit();}
}

}
else{
  header("Location: ../Main Page/mainpage.php");
  exit();
}






?>