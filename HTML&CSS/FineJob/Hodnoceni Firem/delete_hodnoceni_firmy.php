<?php 
session_start();
require "../db_conn.php";
$prevpage = $_SESSION['previous_page'];

if($_SERVER['REQUEST_METHOD'] == "POST"){


$POSTID = $_POST['hodnoceni_ID'];
$PASS = $_POST['pass'];
$USERID = $_SESSION['user_id'];

$result = $db->query("SELECT * FROM ucet WHERE ID = ?", [$USERID]);
if($result->num_rows === 1){
    $USER_DETAILS = $result->fetch_assoc();
    if(password_verify($PASS, $USER_DETAILS['Heslo'])){
        $db->query("DELETE FROM hodnoceni WHERE ID = ? AND Ucet_ID = ?", [$POSTID, $USERID]);
    }

}
else{
header("Location: $prevpage");    
exit();
}


}
header("Location: $prevpage");    
exit();



?>