<?php 
session_start();
require "../db_conn.php";

$allowed_cities = array("Praha", "Zlín", "Brno", "Opava", "Karlovy Vary");
$allowed_obor = array("Informační Technologie", "Chemie a ekologie", "Designer", "Obchod", "Výuka a Škola", 
                      "Sociologie","Medicína","Obsluha");
$allowed_druh = array("Plný úvazek","Brigáda","Částečný úvazek", "Dočasný poměr", "Smlouva", "Praxe", 
                      "Freelance", "Home office");
$allowed_hodnoceni = array("Špatné", "Průměrné", "Výborné");
$allowed_anonym = array("1", "0");

if($_SERVER['REQUEST_METHOD'] == "POST"){

$NADPIS = htmlspecialchars(trim($_POST['Nadpis']));
$TEXT = htmlspecialchars(trim($_POST['nabidka_text']));

if(in_array($_POST['OborTag'], $allowed_obor)){
$OBOR = trim($_POST['OborTag']);
}else{$OBOR = "";}

if(in_array($_POST['MestoTag'], $allowed_cities)){
$MESTO = trim($_POST['MestoTag']);
}else{$MESTO = "";}
$PSC = trim($_POST['PSCTag']);
$ULICE = trim($_POST['UliceTag']);

if(in_array($_POST['DruhTag'], $allowed_druh)){
$DRUH = trim($_POST['DruhTag']);
}else{$DRUH = "";}

if(in_array($_POST['HodnoceniTag'], $allowed_hodnoceni)){
$HODNOCENI = trim($_POST['HodnoceniTag']);
}else{$HODNOCENI = "";}

if(in_array($_POST['AnonymTag'], $allowed_anonym)){
$ANONYM = trim($_POST['AnonymTag']);
}


$UCETID = $_SESSION['user_id'];

if((!empty($PSC) || !empty($ULICE)) && empty($MESTO)){
 $_SESSION['error_lokalita'] = "Lokalita musí obsahovat i město!";
 header("Location: psat_hodnoceni_firmy.php");
 exit();
}
else if(!empty($NADPIS) && !empty($TEXT) && !empty($HODNOCENI)){

$DATA = [];
$COLUMNS = [];
$VALUES = [];

$DATA[] = $NADPIS;
$COLUMNS[] = "Nadpis";
$VALUES[] = "?";

$DATA[] = $TEXT;
$COLUMNS[] = "Text";
$VALUES[] = "?";

$DATA[] = $HODNOCENI;
$COLUMNS[] = "Hodnoceni";
$VALUES[] = "?";

if(!empty($OBOR)){
 $DATA[] = $OBOR;
 $COLUMNS[] = "Obor";
 $VALUES[] = "?";
}
if(!empty($MESTO)){
 $DATA[] = $MESTO;
 $COLUMNS[] = "TAG_Mesto";
 $VALUES[] = "?";
  if(!empty($PSC)){
  $DATA[] = $PSC;
  $COLUMNS[] = "TAG_PSC";
  $VALUES[] = "?";
 }
 if(!empty($ULICE)){
  $DATA[] = $ULICE;
  $COLUMNS[] = "TAG_Ulice";
  $VALUES[] = "?";
 }
}
if(!empty($DRUH)){
 $DATA[] = $DRUH;
 $COLUMNS[] = "Druh_Prace";
 $VALUES[] = "?";
}

if(!empty($ANONYM)){
 $DATA[] = $ANONYM;
 $COLUMNS[] = "Anonym";
 $VALUES[] = "?";
}

$DATA[] = $UCETID;
$COLUMNS[] = "Ucet_ID";
$VALUES[] = "?";

$COLUMNS[] = "Vytvoreno";

$SQLCOLUMNS = implode(", ", $COLUMNS);
$SQLVALUES = implode(", ", $VALUES);

$SQL = "INSERT INTO hodnoceni (" . $SQLCOLUMNS . ") VALUES (" . $SQLVALUES . ", CURRENT_DATE)";
$db->query($SQL, $DATA);

header("Location: ../Hodnoceni Firem/hodnoceni_firem.php");

}else{
    $_SESSION['error_message'] = "Vyplňte nutná pole (Nadpis, text a lokaci)";
    header("Location: psat_hodnoceni_firmy.php");
    exit();
}


}
exit();





?>