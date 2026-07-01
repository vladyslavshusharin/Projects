<?php
session_start();

require "../db_conn.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){

$TYP = "Zaměstnanec"; //Ukládání hodnot z formuláře do proměnných
$FNAME = trim($_POST["fname"]);
$LNAME = trim($_POST["lname"]);
$MAIL = trim($_POST["mail"]);
$PASS = trim($_POST["pass"]);
$DATEOFB = trim($_POST["dateofb"]);
$DEFAULTPFP = "../ProfilePics/stockpfp.jpg";


if(!empty($FNAME) && !empty($LNAME) && !empty($MAIL) && !empty($PASS) && !empty($DATEOFB)){ //Ověřování 
    
    $result = $db->query("SELECT ID FROM ucet WHERE `E-mail` = ?", [$MAIL]); //Příkaz pro ověřování už existujícího učtu se stejným e-mailem

    if($result->num_rows > 0){ //Pokud účet najden, nevytvoří se nový účet
        $_SESSION["usersignup_error"] = "E-mail already in use!";
        header("Location: signup_user.php");
        exit();
    }else{ 
        $HASHPASS = password_hash($PASS, PASSWORD_DEFAULT); //Hashovaní hesla

        //Příkaz pro vytvoření účtu v databázi
        $db->query("INSERT INTO ucet (Typ, Jmeno, Prijmeni, Datum, `E-mail`, Heslo, Profilovy_Obraz) VALUES (?, ?, ?, ?, ?, ?, ?)", [$TYP, $FNAME, $LNAME, $DATEOFB, $MAIL, $HASHPASS, $DEFAULTPFP]);

        $result = $db->query("SELECT * FROM ucet WHERE `E-mail` = ?", [$MAIL]); //Vybraní dat vytvořeného účtu
        if($result->num_rows === 1){
            $USER_DETAILS = $result->fetch_assoc(); //Formátování dat
            
            //Vytvoření session proměnných z dat účtu pro automatické přihlášení
            $_SESSION['user_id'] = $USER_DETAILS['ID']; 
            $_SESSION['usermail'] = $USER_DETAILS['E-mail'];
            $_SESSION['usertype'] = $USER_DETAILS['Typ'];
            $_SESSION['name'] = $USER_DETAILS['Jmeno'];
            $_SESSION['surname'] = $USER_DETAILS['Prijmeni'];
            $_SESSION['pfp'] = $USER_DETAILS['Profilovy_Obraz'];
            $_SESSION['dateofb'] = $USER_DETAILS['Datum'];
         

            $redirect = $_SESSION['previous_page']; //Redirect po úspěšném vytvoření účtu
        if(!empty($redirect)){
            header("Location: $redirect");
        }else{
            header("Location: ../Main Page/mainpage.php");
        }
        }
    }





}else{
    $_SESSION["usersignup_error"] = "Please fill out all fields!"; //Redirect a zprává při nevyplnění všech polí
        header("Location: signup_user.php");
        exit();
}




}











?>