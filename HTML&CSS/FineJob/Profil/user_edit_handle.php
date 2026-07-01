<?php 
session_start();
require "../db_conn.php";
require "upload_image.php";
require "upload_doc.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){

$TYP = "Zaměstnanec";  				// Vkládání poslaných dat do proměnných (oříznuté mezery)
$FNAME = trim($_POST["fname"]);
$LNAME = trim($_POST["lname"]);
$MAIL = trim($_POST["mail"]);
$PASS = trim($_POST["pass"]);
$POPIS = trim($_POST["popis"]);
$DATUM = trim($_POST['dateofb']);
$ID = $_SESSION['user_id'];

if(!empty($FNAME) && !empty($LNAME) && !empty($MAIL) && !empty($PASS) && !empty($DATUM)){ //Data, která musí být uvedená

$result = $db->query("SELECT ID, Heslo FROM ucet WHERE ID = ?", [$ID]); //Hledání účtu uživatele v databázi

 if($result->num_rows === 1){ //Pokud je najden
  $USER_DETAILS = $result->fetch_assoc(); //Formátování dat pro využítí zde
  if(password_verify($PASS, $USER_DETAILS['Heslo'])){ //Ověřování hesla
  	$SQL = "UPDATE ucet SET Jmeno = ?, Prijmeni = ?, `E-Mail` = ?, Popis = ?, Datum = ?"; //Příkaz pro aktualizaci dat účtu

  	$SQL = $SQL . " WHERE ID = ? AND Typ = ?"; //Přidání podmínek pro ID a typ (Možná má duvod proč je to tady, nechci to rozbít, nepamatuji proč)

  	$db->query($SQL, [$FNAME, $LNAME, $MAIL, $POPIS, $DATUM, $ID, $TYP]); //Vykonání příkazu do databáze

  	$result = $db->query("SELECT * FROM ucet WHERE ID = ?", [$ID]); //Vybírání aktualizovaných dat
  	if($result->num_rows === 1){
  		$NEW_USER_DETAILS = $result->fetch_assoc(); 		//Formátování pro využití zde a aktulizace SESSION proměnných
  			$_SESSION['user_id'] = $NEW_USER_DETAILS['ID'];
            $_SESSION['usermail'] = $NEW_USER_DETAILS['E-mail'];
            $_SESSION['name'] = $NEW_USER_DETAILS['Jmeno'];
            $_SESSION['surname'] = $NEW_USER_DETAILS['Prijmeni'];
            $_SESSION['dateofb'] = $NEW_USER_DETAILS['Datum'];
  	}

	// PFP Change
	if(isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE){ //Pokud uživatel přidal novou profilovou fotku
		$uploadedPhoto = uploadFile($_FILES['photo']); //uploadFile pro uploadování fotky a vrácení asociativního arraye

		if(!$uploadedPhoto['success']) { //Pokud nastane chyba
         $_SESSION['image_error'] = "Chyba při nahrávání obrázku: " . $uploadedPhoto['message'];
		 header("Location: profil_edit_user.php");
         exit;

		}else{ //Pokud ne, obnovíme/přidáme cestu k fotce do účtu uživatele v databázi
		 $FullPath = $uploadedPhoto['path'];

		 try{
			$uploadres = $db->query("UPDATE ucet SET Profilovy_Obraz = ? WHERE ID = ?", [$FullPath, $ID]);

			if(!$uploadres){
			 $_SESSION['image_error'] = "Nepodařilo se uploadnout nový profilový obraz";
			 header("Location: profil_edit_user.php");
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
			header("Location: profil_edit_user.php");
			exit;
			 }
	    }
	 	
	 }


	// Dokument upload
	if(isset($_FILES['dokument']) && $_FILES['dokument']['error'] !== UPLOAD_ERR_NO_FILE){ //Pokud uživatel přidal dokument
		$uploadedDoc = uploadDoc($_FILES['dokument']); //uploadDoc pro uploadování dokumentu a vrácení asociativního arraye

		if(!$uploadedDoc['success']) { //Pokud nastane chyba
         $_SESSION['doc_error'] = "Chyba při nahrávání dokumentu: " . $uploadedDoc['message'];
		 header("Location: profil_edit_user.php");
         exit;

		}else{ //Pokud ne, obnovíme/přidáme cestu k dokumentu do účtu uživatele v databázi
		 $FullPath = $uploadedDoc['path'];

		 try{
			$uploadres = $db->query("UPDATE ucet SET Soubor_Dokument = ? WHERE ID = ?", [$FullPath, $ID]);

			if(!$uploadres){
			 $_SESSION['doc_error'] = "Nepodařilo se uploadnout nový dokument";
			 header("Location: profil_edit_user.php");
			 exit;
			}

			}catch(Exception $e){

			$_SESSION['doc_error'] = "Chyba: " . $e->getMessage();
			exit;
			}
	    }
	 	
	 }

  	header("Location: profil.php");
	exit;
  }else{
	$_SESSION['error_message'] = "Špatné heslo!"; //Redirect při špatném heslu
	header("Location: profil_edit_user.php");}

 }

}else{
	$_SESSION['error_message'] = "Základní údaje musí být vyplněné!"; //Redirect při nevyplnění požadovaných údajů
	header("Location: profil_edit_user.php");
}







}






//Zapomněl jsem odstranění starých fotek/dokumentů :)))

?>





