<?php 
session_start();
require "../db_conn.php";

$allowed_cities = array("Praha", "Zlín", "Brno", "Opava", "Karlovy Vary");
$allowed_obor = array("Informační Technologie", "Chemie a ekologie", "Designer", "Obchod", "Výuka a Škola", 
                      "Sociologie","Medicína","Obsluha");
$allowed_druh = array("Plný úvazek","Brigáda","Částečný úvazek", "Dočasný poměr", "Smlouva", "Praxe", 
                      "Freelance", "Home office");
$allowed_zkusenost = array("0 let","1 rok","2 roky","3 roky","4 roky","5 let","5+ let","10 let","10+ let","20 let","20+ let");
$allowed_vzdelani = array("Student", "Zaměstnanec", "Junior", "Medior", "Senior","PhD","MUDr","Ing");

$NABIDKA_ID = $_SESSION['editing_nabidka_id'];

if($_SERVER['REQUEST_METHOD'] == "POST"){

$NADPIS = trim($_POST['Nadpis']);
$TEXT = trim($_POST['nabidka_text']);

if(in_array($_POST['OborTag'], $allowed_obor)){
$OBOR = trim($_POST['OborTag']);
}else{$OBOR = null;}

if(in_array($_POST['MestoTag'], $allowed_cities)){
$MESTO = trim($_POST['MestoTag']);
}else{$MESTO = null;}

if(in_array($_POST['DruhTag'], $allowed_druh)){
$DRUH = trim($_POST['DruhTag']);
}else{$DRUH = null;}

if(in_array($_POST['VzdelaniTag'], $allowed_vzdelani)){
$VZDELANI = trim($_POST['VzdelaniTag']);
}else{$VZDELANI = null;}

if(in_array($_POST['ZkusenostTag'], $allowed_zkusenost)){
$ZKUSENOST = trim($_POST['ZkusenostTag']);
}else{$ZKUSENOST = null;}

$UCETID = $_SESSION['user_id'];




if((!empty($PSC) || !empty($ULICE)) && empty($MESTO)){
 $_SESSION['error_lokalita'] = "Lokalita musí obsahovat i město!";
 header("Location: edit_nabidka_prace.php");
 exit();
}
else if(!empty($NADPIS) && !empty($TEXT) && !empty($MESTO)){

$DATA = [];
$COLUMNS = [];
$VALUES = [];

$DATA[] = $NADPIS;


$DATA[] = $TEXT;


$DATA[] = $OBOR;


$DATA[] = $DRUH;


$DATA[] = $MESTO;


$DATA[] = $VZDELANI;


$DATA[] = $ZKUSENOST;


$DATA[] = $NABIDKA_ID;



$SQL = "UPDATE nabidky SET Nadpis = ?, `Text` = ?, Obor = ?, Druh_Prace = ?, TAG_Mesto = ?, Vzdelani = ?, Zkusenost = ? WHERE ID = ?";
$db->query($SQL, $DATA);
unset($_SESSION['editing_nabidka_id']);
header("Location: ../Hledani Pracovnika/hledat_zamestnance.php");

}else{
    $_SESSION['error_message'] = "Vyplňte nutná pole (Nadpis, text a lokaci)";
    header("Location: edit_zamestnanec.php");
    exit();
}


}

header("Location: ../Hledani Pracovnika/hledat_zamestnance.php");
exit();




?>