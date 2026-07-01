<?php 
session_start();
require "../db_conn.php";

//Arraye pro ověření zadaných tagů
$allowed_cities = array("Praha", "Zlín", "Brno", "Opava", "Karlovy Vary"); 
$allowed_obor = array("Informační Technologie", "Chemie a ekologie", "Designer", "Obchod", "Výuka a Škola", 
                      "Sociologie","Medicína","Obsluha");
$allowed_druh = array("Plný úvazek","Brigáda","Částečný úvazek", "Dočasný poměr", "Smlouva", "Praxe", 
                      "Freelance", "Home office");

$NABIDKA_ID = $_SESSION['editing_nabidka_id']; //Ukládání ID vybrané nabídky do proměnné

if($_SERVER['REQUEST_METHOD'] == "POST"){


//Ukládání zadaných hodnot z formuláře    
$NADPIS = trim($_POST['Nadpis']);
$TEXT = trim($_POST['nabidka_text']);

if(in_array($_POST['OborTag'], $allowed_obor)){
$OBOR = trim($_POST['OborTag']);
}else{$OBOR = null;}

if(in_array($_POST['MestoTag'], $allowed_cities)){
$MESTO = trim($_POST['MestoTag']);
}else{$MESTO = null;}

if(empty($_POST['PSCTag'])){
$PSC = null; 
}else{$PSC = trim($_POST['PSCTag']);}

if(empty($_POST['UliceTag'])){
$ULICE = null; 
}else{$ULICE = trim($_POST['UliceTag']);}

if(in_array($_POST['DruhTag'], $allowed_druh)){
$DRUH = trim($_POST['DruhTag']);
}else{$DRUH = null;}

if(empty($_POST['PlatTag'])){
$PLAT = null;
}else{$PLAT = trim($_POST['PlatTag']);}

$UCETID = $_SESSION['user_id'];


if((!empty($PSC) || !empty($ULICE)) && empty($MESTO)){ //Ověřování lokality (Nesmí být zadané PSČ/Ulice bez města)
 $_SESSION['error_lokalita'] = "Lokalita musí obsahovat i město!";
 header("Location: edit_nabidka_prace.php");
 exit();
}
else if(!empty($NADPIS) && !empty($TEXT)){
 
$DATA = []; //Array pro držení zadaných dat z formuláře


$DATA[] = $NADPIS;


$DATA[] = $TEXT;


$DATA[] = $OBOR;


$DATA[] = $DRUH;


if(!empty($MESTO)){
 $DATA[] = $MESTO;


 $DATA[] = $PSC;


 $DATA[] = $ULICE;


}else{
 $DATA[] = $_SESSION['compcity'];


 $DATA[] = $PSC;


 $DATA[] = $ULICE;

}
 $DATA[] = $PLAT;

 $DATA[] = $NABIDKA_ID;

//SQL příkaz pro aktualizování nabídky v databázi
$SQL = "UPDATE nabidky SET Nadpis = ?, `Text` = ?, Obor = ?, Druh_Prace = ?, TAG_Mesto = ?, TAG_PSC = ?, TAG_Ulice = ?, Plat = ? WHERE ID = ?";
$db->query($SQL, $DATA);
unset($_SESSION['editing_nabidka_id']);
header("Location: ../Hledani Prace/hledat_praci.php");

}else{
    $_SESSION['error_message'] = "Vyplňte nutná pole (Nadpis a text)"; //Redirect při nevyplnění nutných údajů
    header("Location: edit_nabidka_prace.php");
    exit();
}


}

header("Location: ../Hledani Prace/hledat_praci.php");
exit();




?>