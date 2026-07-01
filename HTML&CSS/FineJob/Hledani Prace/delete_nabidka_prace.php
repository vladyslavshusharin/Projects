<?php 
session_start();
require "../db_conn.php";
$prevpage = $_SESSION['previous_page'];

if($_SERVER['REQUEST_METHOD'] == "POST"){


$POSTID = $_POST['nabidka_ID']; //Ukládání POST hodnot do proměnných 
$PASS = $_POST['pass'];
$USERID = $_SESSION['user_id'];

$result = $db->query("SELECT * FROM ucet WHERE ID = ?", [$USERID]); //Hledání uživatele podle jeho session user id
if($result->num_rows === 1){
    $USER_DETAILS = $result->fetch_assoc(); //Formátování dat řádku do PHP arraye USER_DETAILS
    if(password_verify($PASS, $USER_DETAILS['Heslo'])){ //Verifikace hesla
        $db->query("DELETE FROM nabidky WHERE ID = ? AND Ucet_ID = ?", [$POSTID, $USERID]); //Odstranění nabídky podle její ID
    }

}
else{
header("Location: $prevpage"); //Vrátit na minulou stránku pokud špatné heslo   
exit();
}


}
header("Location: $prevpage");
exit();



?>