<?php

session_start();

require "../db_conn.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){

$USERMAIL = trim($_POST["usermail"]); //Ukládání zadaných dat z formuláře do proměnných
$PASS = trim($_POST["pass"]);

if(!empty($USERMAIL) && !empty($PASS)){ //Ověření zadaných údajů ve formuláři


$result = $db->query("SELECT * FROM ucet WHERE `E-mail` = ?", [$USERMAIL]); //Nalezení účtu

if($result->num_rows === 1){ //Pokud učet je najden
    $USER_DETAILS = $result->fetch_assoc(); //Formátování dat

    if(password_verify($PASS, $USER_DETAILS['Heslo'])){ //Verifikace hesla
        if($USER_DETAILS['Typ'] == "Zaměstnanec"){ //Pokud jde o zaměstnance
            $_SESSION['user_id'] = $USER_DETAILS['ID'];
            $_SESSION['usermail'] = $USER_DETAILS['E-mail'];
            $_SESSION['usertype'] = $USER_DETAILS['Typ'];
            $_SESSION['name'] = $USER_DETAILS['Jmeno'];
            $_SESSION['surname'] = $USER_DETAILS['Prijmeni'];
            $_SESSION['pfp'] = $USER_DETAILS['Profilovy_Obraz'];
            $_SESSION['dateofb'] = $USER_DETAILS['Datum'];
        }
        if($USER_DETAILS['Typ'] == "Firma"){ //Pokud jde o firmu
            $_SESSION['user_id'] = $USER_DETAILS['ID'];
            $_SESSION['usermail'] = $USER_DETAILS['E-mail'];
            $_SESSION['usertype'] = $USER_DETAILS['Typ'];
            $_SESSION['name'] = $USER_DETAILS['Nazev'];
            $_SESSION['compcity'] = $USER_DETAILS['Mesto'];
            $_SESSION['citypsc'] = $USER_DETAILS['PSC'];
            $_SESSION['street'] = $USER_DETAILS['Ulice'];
            $_SESSION['pfp'] = $USER_DETAILS['Profilovy_Obraz'];
            $_SESSION['dateofc'] = $USER_DETAILS['Datum'];
        }
        
//Ano počet redirectu (velmi cybersecurity)
        $redirect = $_SESSION['previous_page']; 
        if(!empty($redirect)){ //Pokud úspěšné přihlášení
            header("Location: $redirect");
        }else{
            header("Location: ../Main Page/mainpage.php");
        }
    }else{ //Pokud špatné heslo
        $_SESSION['login_error'] = "Incorrect credentials!";
        header("Location: login.php");
        exit();
    }
}else{ //Pokud účet nenajden
    $_SESSION['login_error'] = "Incorrect credentials!";
    header("Location: login.php");
    exit();
}


}else{ //Pokud nevyplněná pole
    $_SESSION['login_error'] = "Fill out all fields!";
    header("Location: login.php");
    exit();
}


}






?>