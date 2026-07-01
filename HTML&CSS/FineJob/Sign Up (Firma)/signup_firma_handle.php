<?php
session_start();

require "../db_conn.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){



$TYP = "Firma";
$COMPNAME = trim($_POST["compname"]);
$MAIL = trim($_POST["mail"]);
$PASS = trim($_POST["pass"]);
$DATEOFC = trim($_POST["dateofc"]);
$CITY = trim($_POST["city"]);
$PSC = trim($_POST["psc"]);
$STRT = trim($_POST["strt"]);
$DEFAULTPFP = "../ProfilePics/stockpfp.jpg";

 if(!empty($COMPNAME) && !empty($MAIL) && !empty($PASS) && !empty($DATEOFC) && !empty($CITY) && !empty($PSC) && !empty($STRT)){

    $correctcity = false;
    $allowedcities = array("Praha", "Zlín", "Brno", "Opava", "Karlovy Vary");

    $result = $db->query("SELECT ID FROM ucet WHERE `E-mail` = ?", [$MAIL]);

    if($result->num_rows > 0){
        $_SESSION["firmsignup_error"] = "E-mail already in use!";
        header("Location: signup_firma.php");
        exit();
    }

    
     if(in_array($CITY, $allowedcities)){
      $correctcity = true;
     }
    
    if(!$correctcity){
     $_SESSION["firmsignup_error"] = "Error input";
     header("Location: signup_firma.php");
     exit();
    }else{
        $HASHPASS = password_hash($PASS, PASSWORD_DEFAULT);

        $db->query("INSERT INTO ucet (Typ, Nazev, Datum, `E-mail`, Heslo, Mesto, PSC, Ulice, Profilovy_Obraz) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", [$TYP, $COMPNAME, $DATEOFC, $MAIL, $HASHPASS, $CITY, $PSC, $STRT, $DEFAULTPFP]);

        $result = $db->query("SELECT * FROM ucet WHERE `E-mail` = ?", [$MAIL]);
        if($result->num_rows === 1){
            $USER_DETAILS = $result->fetch_assoc();

            $_SESSION['user_id'] = $USER_DETAILS['ID'];
            $_SESSION['usermail'] = $USER_DETAILS['E-mail'];
            $_SESSION['usertype'] = $USER_DETAILS['Typ'];
            $_SESSION['name'] = $USER_DETAILS['Nazev'];
            $_SESSION['compcity'] = $USER_DETAILS['Mesto'];
            $_SESSION['citypsc'] = $USER_DETAILS['PSC'];
            $_SESSION['street'] = $USER_DETAILS['Ulice'];
            $_SESSION['pfp'] = $USER_DETAILS['Profilovy_Obraz'];
            $_SESSION['dateofc'] = $USER_DETAILS['Datum'];

            $redirect = $_SESSION['previous_page'];
        if(!empty($redirect)){
            header("Location: $redirect");
        }else{
            header("Location: ../Main Page/mainpage.php");
        }
        }
    }




 }else{
    $_SESSION["firmsignup_error"] = "Please fill out all fields!";
        header("Location: signup_firma.php");
        exit();
 }

}


?>