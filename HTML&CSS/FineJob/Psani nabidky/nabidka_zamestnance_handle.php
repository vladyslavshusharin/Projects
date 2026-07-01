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

if($_SERVER['REQUEST_METHOD'] == "POST"){

$NADPIS = htmlspecialchars(trim($_POST['Nadpis']));
$TEXT = htmlspecialchars(trim($_POST['nabidka_text']));

if(in_array($_POST['OborTag'], $allowed_obor)){
$OBOR = trim($_POST['OborTag']);
}else{$OBOR = "";}

if(in_array($_POST['MestoTag'], $allowed_cities)){
$MESTO = trim($_POST['MestoTag']);
}else{$MESTO = "";}

if(in_array($_POST['DruhTag'], $allowed_druh)){
$DRUH = trim($_POST['DruhTag']);
}else{$DRUH = "";}

if(in_array($_POST['VzdelaniTag'], $allowed_vzdelani)){
$VZDELANI = trim($_POST['VzdelaniTag']);
}else{$VZDELANI = "";}

if(in_array($_POST['ZkusenostTag'], $allowed_zkusenost)){
$ZKUSENOST = trim($_POST['ZkusenostTag']);
}else{$ZKUSENOST = "";}


$UCETID = $_SESSION['user_id'];

if(!empty($NADPIS) && !empty($TEXT) && !empty($MESTO)){

$DATA = [];
$COLUMNS = [];
$VALUES = [];

$DATA[] = $NADPIS;
$COLUMNS[] = "Nadpis";
$VALUES[] = "?";

$DATA[] = $TEXT;
$COLUMNS[] = "Text";
$VALUES[] = "?";

$DATA[] = $MESTO;
$COLUMNS[] = "TAG_Mesto";
$VALUES[] = "?";

if(!empty($OBOR)){
 $DATA[] = $OBOR;
 $COLUMNS[] = "Obor";
 $VALUES[] = "?";
}
if(!empty($VZDELANI)){
 $DATA[] = $VZDELANI;
 $COLUMNS[] = "Vzdelani";
 $VALUES[] = "?";
}
if(!empty($ZKUSENOST)){
 $DATA[] = $ZKUSENOST;
 $COLUMNS[] = "Zkusenost";
 $VALUES[] = "?";
}
if(!empty($DRUH)){
 $DATA[] = $DRUH;
 $COLUMNS[] = "Druh_Prace";
 $VALUES[] = "?";
}

$DATA[] = $UCETID;
$COLUMNS[] = "Ucet_ID";
$VALUES[] = "?";

$COLUMNS[] = "Vytvoreno";

$SQLCOLUMNS = implode(", ", $COLUMNS);
$SQLVALUES = implode(", ", $VALUES);

$SQL = "INSERT INTO nabidky (" . $SQLCOLUMNS . ") VALUES (" . $SQLVALUES . ", CURRENT_DATE)";
$db->query($SQL, $DATA);

header("Location: ../Hledani Pracovnika/hledat_zamestnance.php");

}else{
    $_SESSION['error_message'] = "Vyplňte nutná pole (Nadpis, text a lokaci)";
    header("Location: psat_nabidky_zamestnancu.php");
}






}






?>