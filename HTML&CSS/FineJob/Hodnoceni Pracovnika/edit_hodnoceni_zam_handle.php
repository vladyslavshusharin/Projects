<?php 
session_start();
require "../db_conn.php";

$allowed_cities = array("Praha", "Zlín", "Brno", "Opava", "Karlovy Vary");
$allowed_obor = array("Informační Technologie", "Chemie a ekologie", "Designer", "Obchod", "Výuka a Škola", 
                      "Sociologie","Medicína","Obsluha");
$allowed_druh = array("Plný úvazek","Brigáda","Částečný úvazek", "Dočasný poměr", "Smlouva", "Praxe", 
                      "Freelance", "Home office");
$allowed_hodnoceni = array("Špatné", "Průměrné", "Výborné");

$HODNOCENI_ID = $_SESSION['editing_hodnoceni_id'];

if($_SERVER['REQUEST_METHOD'] == "POST"){

$NADPIS = trim($_POST['Nadpis']);
$TEXT = trim($_POST['hodnoceni_text']);

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

if(in_array($_POST['HodnoceniTag'], $allowed_hodnoceni)){
$HODNOCENI = trim($_POST['HodnoceniTag']);
}else{$HODNOCENI = null;}

if(isset($_POST['AnonymTag']) && in_array($_POST['AnonymTag'], $allowed_anonym)){
$ANONYM = trim($_POST['AnonymTag']);
}else{$ANONYM = "0";}

$UCETID = $_SESSION['user_id'];


if((!empty($PSC) || !empty($ULICE)) && empty($MESTO)){
 $_SESSION['error_lokalita'] = "Lokalita musí obsahovat i město!";
 header("Location: edit_hodnoceni_zam.php");
 exit();
}
else if(!empty($NADPIS) && !empty($TEXT) && !empty($HODNOCENI)){

$DATA = [];


$DATA[] = $NADPIS;


$DATA[] = $TEXT;


$DATA[] = $OBOR;


$DATA[] = $DRUH;


$DATA[] = $MESTO;

$DATA[] = $PSC;

$DATA[] = $ULICE;


 $DATA[] = $HODNOCENI;

 $DATA[] = $HODNOCENI_ID;


$SQL = "UPDATE hodnoceni SET Nadpis = ?, `Text` = ?, Obor = ?, Druh_Prace = ?, TAG_Mesto = ?, TAG_PSC = ?, TAG_Ulice = ?, Hodnoceni = ? WHERE ID = ?";
$db->query($SQL, $DATA);
unset($_SESSION['editing_hodnoceni_id']);
header("Location: ../Hodnoceni Pracovnika/hodnoceni_zamestnancu.php");

}else{
    $_SESSION['error_message'] = "Vyplňte nutná pole (Nadpis, text a hodnocení)";
    header("Location: edit_hodnoceni_zam.php");
    exit();
}


}

header("Location: ../Hodnoceni Pracovnika/hodnoceni_zamestnancu.php");
exit();




?>