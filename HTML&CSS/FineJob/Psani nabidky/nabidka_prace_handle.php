<?php 
session_start();
require "../db_conn.php";

//arraye pro ověření tagů
$allowed_cities = array("Praha", "Zlín", "Brno", "Opava", "Karlovy Vary"); 
$allowed_obor = array("Informační Technologie", "Chemie a ekologie", "Designer", "Obchod", "Výuka a Škola", 
                      "Sociologie","Medicína","Obsluha");
$allowed_druh = array("Plný úvazek","Brigáda","Částečný úvazek", "Dočasný poměr", "Smlouva", "Praxe", 
                      "Freelance", "Home office");

if($_SERVER['REQUEST_METHOD'] == "POST"){

$NADPIS = htmlspecialchars(trim($_POST['Nadpis'])); //Ukládání poslaných hodnot z formuláře 
$TEXT = htmlspecialchars(trim($_POST['nabidka_text']));

if(in_array($_POST['OborTag'], $allowed_obor)){ //Ověření hodnot
$OBOR = trim($_POST['OborTag']);
}else{$OBOR = "";} //Pokud nesprávná hodnota

if(in_array($_POST['MestoTag'], $allowed_cities)){
$MESTO = trim($_POST['MestoTag']);
}else{$MESTO = "";}
$PSC = trim($_POST['PSCTag']);
$ULICE = trim($_POST['UliceTag']);

if(in_array($_POST['DruhTag'], $allowed_druh)){
$DRUH = trim($_POST['DruhTag']);
}else{$DRUH = "";}

$ULICE = trim($_POST['UliceTag']);
$PLAT = trim($_POST['PlatTag']);
$UCETID = $_SESSION['user_id'];


if((!empty($PSC) || !empty($ULICE)) && empty($MESTO)){ //Nesmí být ulice/PSČ bez města
 $_SESSION['error_lokalita'] = "Lokalita musí obsahovat i město!";
 header("Location: psat_nabidky_prace.php");
 exit();
}
else if(!empty($NADPIS) && !empty($TEXT)){

$DATA = []; //Array pro data
$COLUMNS = []; //Array pro specifikaci sloupcu, které mají být naplněné
$VALUES = []; //Hodnoty (?), které jsou doplněné arrayem DATA

$DATA[] = $NADPIS;
$COLUMNS[] = "Nadpis";
$VALUES[] = "?";

$DATA[] = $TEXT;
$COLUMNS[] = "Text";
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
 if(!empty($ULICE)){
 $DATA[] = $ULICE;
 $COLUMNS[] = "TAG_Ulice";
 $VALUES[] = "?";
 }
 if(!empty($PSC)){
 $DATA[] = $PSC;
 $COLUMNS[] = "TAG_PSC";
 $VALUES[] = "?";
 }
}else{
 $DATA[] = $_SESSION['compcity'];
 $COLUMNS[] = "TAG_Mesto";
 $VALUES[] = "?";
}
if(!empty($PLAT)){
 $DATA[] = $PLAT;
 $COLUMNS[] = "Plat";
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

$SQLCOLUMNS = implode(", ", $COLUMNS); //Vytvaření string hodnoty z arraye COLUMNS
$SQLVALUES = implode(", ", $VALUES); //Vytvaření string hodnoty z arraye VALUES

$SQL = "INSERT INTO nabidky (" . $SQLCOLUMNS . ") VALUES (" . $SQLVALUES . ", CURRENT_DATE)"; //SQL Příkaz pro vytváření nabídky
$db->query($SQL, $DATA);

header("Location: ../Hledani Prace/hledat_praci.php"); //Redirect pri úspěšném vytvoření

}else{
    $_SESSION['error_message'] = "Vyplňte nutná pole (Nadpis a text)"; //Správá a redirect při nevyplnění nutných polí
    header("Location: psat_nabidky_prace.php"); 
    exit();
}


}

exit();




?>