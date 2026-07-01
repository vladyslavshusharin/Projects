<?php 
session_start();
require "../db_conn.php";
require "upload_image.php";


if($_SERVER["REQUEST_METHOD"] == "POST"){

$allowed_cities = array("Praha", "Zlín", "Brno", "Opava", "Karlovy Vary");

$TYP = "Firma";
$COMPNAME = trim($_POST["compname"]);
$MAIL = trim($_POST["mail"]);
$PASS = trim($_POST["pass"]);
$POPIS = trim($_POST["popis"]);
$ODKAZ = trim($_POST["odkaz"]);
$DATUM = trim($_POST["dateofc"]);
$CITY = trim($_POST["city"]);
$PSC = trim($_POST["psc"]);
$STRT = trim($_POST["strt"]);
$ID = $_SESSION['user_id'];

if(!empty($COMPNAME) && !empty($MAIL) && !empty($PASS) && !empty($CITY) && !empty($PSC) && !empty($STRT) && !empty($DATUM) && in_array($CITY, $allowed_cities)){

$result = $db->query("SELECT ID, Heslo FROM ucet WHERE ID = ?", [$ID]);

 if($result->num_rows === 1){
  $USER_DETAILS = $result->fetch_assoc();
  if(password_verify($PASS, $USER_DETAILS['Heslo'])){
  	$SQL = "UPDATE ucet SET Nazev = ?, `E-Mail` = ?, Popis = ?, Odkaz = ?, Datum = ?, Mesto = ?, PSC = ?, Ulice = ?";

  	$SQL = $SQL . " WHERE ID = ? AND Typ = ?";

  	$db->query($SQL, [$COMPNAME, $MAIL, $POPIS, $ODKAZ, $DATUM, $CITY, $PSC, $STRT, $ID, $TYP]);

  	$result = $db->query("SELECT * FROM ucet WHERE ID = ?", [$ID]);
  	if($result->num_rows === 1){
  		$NEW_USER_DETAILS = $result->fetch_assoc();
  			$_SESSION['user_id'] = $NEW_USER_DETAILS['ID'];
            $_SESSION['usermail'] = $NEW_USER_DETAILS['E-mail'];
            $_SESSION['usertype'] = $NEW_USER_DETAILS['Typ'];
            $_SESSION['name'] = $NEW_USER_DETAILS['Nazev'];
            $_SESSION['compcity'] = $NEW_USER_DETAILS['Mesto'];
            $_SESSION['citypsc'] = $NEW_USER_DETAILS['PSC'];
            $_SESSION['street'] = $NEW_USER_DETAILS['Ulice'];
            $_SESSION['pfp'] = $NEW_USER_DETAILS['Profilovy_Obraz'];
            $_SESSION['dateofc'] = $NEW_USER_DETAILS['Datum'];
  	}

    // PFP change
    if(isset($_FILES['photo_firma']) && $_FILES['photo_firma']['error'] !== UPLOAD_ERR_NO_FILE){
		$uploadedPhoto = uploadFile($_FILES['photo_firma']);

		if(!$uploadedPhoto['success']) {
         $_SESSION['image_error'] = "Chyba při nahrávání obrázku: " . $uploadedPhoto['message'];
		 header("Location: profil_edit_firma.php");
         exit;

		}else{
		 $FullPath = $uploadedPhoto['path'];

		 try{
			$uploadres = $db->query("UPDATE ucet SET Profilovy_Obraz = ? WHERE ID = ?", [$FullPath, $ID]);

			if(!$uploadres){
			 $_SESSION['image_error'] = "Nepodařilo se uploadnout nový profilový obraz";
			 header("Location: profil_edit_firma.php");
			 exit;
			}else{
			 $result = $db->query("SELECT * FROM ucet WHERE ID = ?", [$ID]);

  				if($result->num_rows === 1){
  					$NEW_USER_DETAILS = $result->fetch_assoc();
  					$_SESSION['pfp'] = $NEW_USER_DETAILS['Profilovy_Obraz'];
  				}
			}

			}catch(Exception $e){

			$_SESSION['image_error'] = "Chyba: " . $e->getMessage();
			header("Location: profil_edit_firma.php");
			exit;
			 }
	    }
	 	
	 }

  	header("Location: profil.php");
  }else{
	$_SESSION['error_message'] = "Špatné heslo!";
	header("Location: profil_edit_firma.php");}

 }

}else{
	$_SESSION['error_message'] = "Základní údaje musí být vyplněné!";
	header("Location: profil_edit_firma.php");
}







}








?>
