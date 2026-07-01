<?php 
session_start();
$_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];
require "../db_conn.php";

$showdata = "SELECT nabidky.*, ucet.Typ, ucet.Nazev, ucet.Profilovy_Obraz 
             FROM nabidky JOIN ucet ON nabidky.Ucet_ID = ucet.ID WHERE ucet.Typ = 'Firma'"; //Vytvoření základního SQL příkazu

$params = []; //Array do kterého se dodávají parametry

//Arraye pro ověřování zadaných parametrů
$allowed_date = array("Vytvoreno ASC", "Vytvoreno DESC");
$allowed_pay = array("Plat ASC", "Plat DESC");
$allowed_cities = array("Praha", "Zlín", "Brno", "Opava", "Karlovy Vary");
$allowed_obor = array("Informační Technologie", "Chemie a ekologie", "Designer", "Obchod", "Výuka a Škola", 
                      "Sociologie","Medicína","Obsluha");
$allowed_druh = array("Plný úvazek","Brigáda","Částečný úvazek", "Dočasný poměr", "Smlouva", "Praxe", 
                      "Freelance", "Home office");
$allowed_pay_range = array("10000 20000", "20000 30000", "30000 40000", "40000 50000", "50000 60000", "60000 70000", "70000 80000", "80000 90000","90000 100000");

//Vytvoření proměnných pro vkládání do params 
if(isset($_GET['DatumOrder'])){
  if(!in_array($_GET['DatumOrder'], $allowed_date)){$DatumOrder = "";}
  else{$DatumOrder = $_GET['DatumOrder'];}
}
if(isset($_GET['PlatOrder'])){
  if(!in_array($_GET['PlatOrder'], $allowed_pay)){$PlatOrder = "";}
  else{$PlatOrder = $_GET['PlatOrder'];}
}
if(isset($_GET['PlatRange'])){
  if(!in_array($_GET['PlatRange'], $allowed_pay_range)){$PlatRange = "";}
  else{$PlatRange = $_GET['PlatRange'];
       $PlatRange = explode(" ",$PlatRange);}
}
if(isset($_GET['OborTag'])){
  if(!in_array($_GET['OborTag'], $allowed_obor)){$OborTag = "";}
  else{$OborTag = $_GET['OborTag'];}
}
if(isset($_GET['DruhTag'])){
  if(!in_array($_GET['DruhTag'], $allowed_druh)){$DruhTag = "";}
  else{$DruhTag = $_GET['DruhTag'];}
}
if(isset($_GET['MestoTag'])){
  if(!in_array($_GET['MestoTag'], $allowed_cities)){$MestoTag = "";}
  else{$MestoTag = $_GET['MestoTag'];}
}
if(isset($_GET['searchtext'])){
  $SEARCHTEXT = $_GET['searchtext'];
}

//Ověřující if pro nezbytné parametry
if(!empty($OborTag) || !empty($DruhTag) || !empty($MestoTag) || !empty($PlatRange)){
  if(!empty($OborTag)){
    $showdata = $showdata . " AND nabidky.Obor = ?"; //Modifikace příkazu podle podmínky
    $params[] = $OborTag; //Vkládání parametru do arraye params
  }

  if(!empty($DruhTag)){
    $showdata = $showdata . " AND nabidky.Druh_Prace = ?";
    $params[] = $DruhTag;
  }

  if(!empty($MestoTag)){
    $showdata = $showdata . " AND nabidky.TAG_Mesto = ?";
    $params[] = $MestoTag;
  }
  if(!empty($PlatRange)){
    $showdata = $showdata . " AND Plat BETWEEN ? AND ?";
    $params[] = $PlatRange[0];
    $params[] = $PlatRange[1];
   }
}


if(!empty($SEARCHTEXT)){
  $search1 = "%" . trim($SEARCHTEXT) . "%"; //Vytvoření proměnné s vhodnou hodnotou pro SQL příkaz, kde klíčový text je hledán kolem jakéhokoliv jiného textu
  $showdata = $showdata ." AND Nadpis LIKE ?"; 
  $params[] = $search1; 
}

//Podmínky pro poslední parametry v SQL příkazu
if(!empty($DatumOrder) || !empty($PlatOrder)){

  $showdata = $showdata . " ORDER BY"; //Modifikace SQL příkazu pro poslední podmínky (ORDER BY)

  if(!empty($DatumOrder)){
    $showdata = $showdata . " " . $DatumOrder; //Přidávaní podmínek
  }

  if(!empty($PlatOrder)){
    if(!empty($DatumOrder)){ //Přidávaní správné syntaxe na základě existence minulé podmínky
      $showdata = $showdata . ","; 
    }
    $showdata = $showdata . " " . $PlatOrder;
  }

} 
else{$showdata = $showdata . " ORDER BY nabidky.Vytvoreno DESC"; } //Defaultní ORDER BY 

$result = $db->query($showdata, $params); //Vyzvednutí dat z databáze

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styleitems.css">
    <link rel="stylesheet" href="../stylelayout.css">
    <script src="../stylefunctions.js"></script> 
    <title>FineJob - Hledat práci</title>
</head>
<body>

 <div class="site">

  <?php include "../header.php"; ?>

  <main>
    
<!--------------------------------HORNI KONTENT STRANKY-------------------------------------->  
    
  <div class="bigbox-horizontal border-trans" style="flex-direction: row-reverse">
<!--------------------------------OBRAZEK S LOGEM------------------------------------->  
  <div class="box-horizontal col-3 border-trans">
  <img class="full-center" src="../WebPics/Logo3.png" style="width: 230px; height: 220px;">
  </div>
<!--------------------------------OBRAZEK S LOGEM END------------------------------------->  

<!--------------------------------------SEARCH BAR---------------------------------------->  
  <div class="box-horizontal col-7 border-trans">

   <div class="bigbox-horizontal border-trans">
      <div class="vertical-center stick-to-left box-rounded bg-color-orange Hpixelbox-5 Vpixelbox-1">
        <h1 class="oswald-Cfont full-center text-color-black">Hledání práce</h1>
      </div>
   </div>

    <form class="box-vertical Hpixelbox-7 box-rounded bg-color-orange" method="GET">
      <div class="box-horizontal Hpixelbox-6p5 border-trans">
       <input type="text" id="searchtext" name="searchtext" class="box-horizontal col-8 bg-color-gray box-rounded-left border-grayer" placeholder="Hledat...">
       <input type="submit" value="Hledat" class="box-horizontal bg-color-gray col-2 box-rounded-right border-grayer">
      </div>

      <div class="box-horizontal box-rounded" style="gap: 5px 5px;">
       <select id="DatumOrder" name="DatumOrder" class="box-horizontal bg-color-gray box-rounded border-grayer">
      <?php if($_GET['DatumOrder'] != ""):?>
        <option value="<?php echo $_GET['DatumOrder']?>"><?php if($_GET['DatumOrder'] == "Vytvoreno ASC"){echo "Nejstarší";}
                                                               if($_GET['DatumOrder'] == "Vytvoreno DESC"){echo "Nejnovější";} ?></option>
        <option value="">Datum</option>
      <?php else:?>
        <option value="">Datum</option>
      <?php endif;?>
        <option value="Vytvoreno ASC">Nejstarší</option>
        <option value="Vytvoreno DESC">Nejnovější</option>
       </select>

       <select id="PlatOrder" name="PlatOrder" class="box-horizontal bg-color-gray box-rounded border-grayer">
      <?php if($_GET['PlatOrder'] != ""):?>
        <option value="<?php echo $_GET['PlatOrder']?>"><?php if($_GET['PlatOrder'] == "Plat ASC"){echo "Nejmenší";}
                                                               if($_GET['PlatOrder'] == "Plat DESC"){echo "Největší";} ?></option>
        <option value="">Plat</option>
      <?php else:?>
        <option value="">Plat</option>
      <?php endif;?>
        <option value="Plat DESC">Největší</option>
        <option value="Plat ASC">Nejmenší</option>
       </select>

       <select id="PlatRange" name="PlatRange" class="box-horizontal bg-color-gray box-rounded border-grayer">
            <?php if($_GET['PlatRange'] != ""):?>
              <option value="<?php echo $_GET['PlatRange']?>"><?php echo $PlatRange[0] . "-" . $PlatRange[1] . " Kč"?></option>
              <option value="">Plat (Rozsah)</option>
            <?php else:?>
              <option value="">Plat (Rozsah)</option>
            <?php endif;?>
              <option value="10000 20000">10000-20000 Kč</option>
              <option value="20000 30000">20000-30000 Kč</option>
              <option value="30000 40000">30000-40000 Kč</option>
              <option value="40000 50000">40000-50000 Kč</option>
              <option value="50000 60000">50000-60000 Kč</option>
              <option value="60000 70000">60000-70000 Kč</option>
              <option value="70000 80000">70000-80000 Kč</option>
              <option value="80000 90000">80000-90000 Kč</option>
              <option value="90000 100000">90000-100000 Kč</option>
          </select>

       <select id="OborTag" name="OborTag" class="box-horizontal bg-color-gray box-rounded border-grayer">
      <?php if($_GET['OborTag'] != ""):?>
        <option value="<?php echo $_GET['OborTag']?>"><?php echo $_GET['OborTag']?></option>
        <option value="">Obor</option>
      <?php else:?>
        <option value="">Obor</option>
      <?php endif;?>
        <option value="Informační Technologie">Informační Technologie</option>
        <option value="Chemie a ekologie">Chemie a ekologie</option>
        <option value="Designer">Designer</option>
        <option value="Obchod">Obchod</option>
        <option value="Výuka a Škola">Výuka a Škola</option>
        <option value="Sociologie">Sociologie</option>
        <option value="Medicína">Medicína</option>
        <option value="Obsluha">Obsluha</option>
       </select>

       <select id="DruhTag" name="DruhTag" class="box-horizontal bg-color-gray box-rounded border-grayer">
      <?php if($_GET['DruhTag'] != ""):?>
        <option value="<?php echo $_GET['DruhTag']?>"><?php echo $_GET['DruhTag']?></option>
        <option value="">Druh práce</option>
      <?php else:?>
        <option value="">Druh práce</option>
      <?php endif;?>
        <option value="Plný úvazek">Plný úvazek</option>
        <option value="Brigáda">Brigáda</option>
        <option value="Částečný úvazek">Částečný úvazek</option>
        <option value="Dočasný poměr">Dočasný poměr</option>
        <option value="Smlouva">Smlouva</option>
        <option value="Praxe">Praxe</option>
        <option value="Freelance">Freelance</option>
        <option value="Home office">Home office</option>
       </select>

       <select id="MestoTag" name="MestoTag" class="box-horizontal bg-color-gray box-rounded border-grayer">
      <?php if($_GET['MestoTag'] != ""):?>
        <option value="<?php echo $_GET['MestoTag']?>"><?php echo $_GET['MestoTag']?></option>
        <option value="">Město</option>
      <?php else:?>
        <option value="">Město</option>
      <?php endif;?>
        <option value="Praha">Praha</option>
        <option value="Zlín">Zlín</option>
        <option value="Karlovy Vary">Karlovy Vary</option>
        <option value="Brno">Brno</option>
        <option value="Opava">Opava</option>
       </select>

      </div>
    </form>
   <div class="box-vertical border-trans">

    <?php if(isset($_SESSION['user_id'])):?>
     <?php if($_SESSION['usertype'] == "Firma"):?>
     <div class="bg-color-orange box-rounded" style="min-height: 40px;">
     <a href="../Psani nabidky/psat_nabidky_prace.php" class="text-color-white bg-color-orange box-horizontal border-trans" style="height: 100%;"><p class="vertical-center oswald-Cfont">Napsat Nabidku</p></a>
     </div>
     <?php endif;?>
    <?php else:?>
     <div class="bg-color-orange box-rounded" style="min-height: 40px;"> 
     <a href="../Sign Up (Firma)/signup_firma.php" class="text-color-white bg-color-orange box-horizontal border-trans" style="height: 100%;"><p class="vertical-center oswald-Cfont">Chci napsat nabídku práce</p></a> 
     </div>
     <?php endif;?>

   </div>
  
  </div>
<!--------------------------------------SEARCH BAR END---------------------------------------->  

  </div>

<!--------------------------------HORNI KONTENT STRANKY END-------------------------------------->  

<!--------------------------------------VYPISOVANI NABIDEK---------------------------------------->  

<div class="bigbox-vertical Rpadding-0p1 Lpadding-0p1 border-trans">

  <?php if($result->num_rows > 0):?>
   <?php while($row = $result->fetch_assoc()):?>

  <div class="bigbox-vertical Tmargin-0p5 Bmargin-0p25 box-rounded bg-color-gray">
    <h1 class="oswald-Cfont"><?php echo htmlspecialchars($row['Nadpis'])?></h1>
    <a href="../Profil/profil_selected.php?id=<?php echo $row['Ucet_ID'];?>" class="box-horizontal text-color-black no-text-decor border-trans null-padding">
     <img class="img-base box-rounded" src="<?php echo htmlspecialchars($row['Profilovy_Obraz'])?>" alt="PFP" style="width: 40px; height: 40px;">
    </a>
    <a href="../Profil/profil_selected.php?id=<?php echo $row['Ucet_ID'];?>" class="box-horizontal text-color-black no-text-decor border-trans null-padding">
     <h2 class="oswald-Cfont weight-small"><?php echo htmlspecialchars($row['Nazev'])?></h2>
    </a>

   
    <div class="collapsible-container collapsible-button box-vertical border-trans">
   
    <?php if(!empty($row['Obor']) || !empty($row['Druh_Prace']) || !empty($row['Plat']) || !empty($row['TAG_Mesto']) || !empty($row['TAG_Ulice'])):?>

    <div class="box-horizontal border-trans" style="gap: 5px 5px; padding-left: 0;">

     <?php if(!empty($row['TAG_Mesto'])):?>
     <h4 class="box-horizontal bg-color-grayer box-rounded oswald-Cfont weight-small"><?php echo htmlspecialchars($row['TAG_Mesto'])?></h4>
     <?php endif;?>
     <?php if(!empty($row['TAG_Ulice'])):?>
     <h4 class="box-horizontal bg-color-grayer box-rounded oswald-Cfont weight-small"><?php echo htmlspecialchars($row['TAG_Ulice'])?></h4>
     <?php endif;?>
     <?php if(!empty($row['Obor'])):?>
      <h3 class="box-horizontal bg-color-grayer box-rounded oswald-Cfont weight-small"><?php echo htmlspecialchars($row['Obor'])?></h3>
     <?php endif;?>
     <?php if(!empty($row['Druh_Prace'])):?>
     <h3 class="box-horizontal bg-color-grayer box-rounded oswald-Cfont weight-small"><?php echo htmlspecialchars($row['Druh_Prace'])?></h3>
     <?php endif;?>
     <?php if(!empty($row['Plat'])):?>
     <h3 class="box-horizontal bg-color-grayer box-rounded oswald-Cfont weight-small"><?php echo htmlspecialchars($row['Plat']) . " Kč"?></h3>
     <?php endif;?>
    </div>

    <?php endif;?>


     <h4 class="box-horizontal bg-color-grayer box-rounded oswald-Cfont weight-small"><?php echo htmlspecialchars($row['Vytvoreno'])?></h4>
    <div class="bigbox-vertical Collapsedbox-1p5 collapsible-content border-trans">
      <p class="oswald-Cfont weight-small"><?php echo nl2br(htmlspecialchars($row['Text']))?></p>
    </div>
     
     <div class="box-horizontal border-trans" style="gap: 0 5px;">

     <?php if(isset($_SESSION['user_id']) && isset($_SESSION['usertype']) && $_SESSION['usertype'] == "Zaměstnanec"):?>
      <?php if($row['Ucet_ID'] != $_SESSION['user_id']):?>
       <a href="../Direct Message/direct_message.php?message_to_id=<?php echo $row['Ucet_ID'];?>" class="box-horizontal bg-color-orange text-color-white box-rounded oswald-Cfont text-pageread">Odpovědět</a>
      <?php endif;?>
     <?php elseif(isset($_SESSION['usertype']) && $_SESSION['usertype'] != "Zaměstnanec"):?>

     <?php else:?>
      <a href="../Sign Up (Uzivatel)/signup_user.php" class="box-horizontal bg-color-orange text-color-white box-rounded oswald-Cfont text-pageread">Odpovědět</a>
     <?php endif;?>

     <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $row['Ucet_ID']):?>
      <a href="edit_nabidka_prace.php?id=<?php echo $row['ID'];?>" class="box-horizontal bg-color-orange box-rounded text-color-white oswald-Cfont text-pageread">Editovat</a>
     <?php endif;?>
    
     <?php if(isset($_SESSION['user_id']) && $row['Ucet_ID'] == $_SESSION['user_id']):?>
        <form action="delete_nabidka_prace.php" method="POST">

          <input type="hidden" name="nabidka_ID" value="<?php echo $row['ID']?>">
          <button class="box-horizontal bg-color-orange text-color-white text-full-center openpopup box-rounded text-color-white oswald-Cfont text-pageread" type="button">Odstranit</button>
         <div class="popup">
          <div class="box-vertical full-center bg-color-gray box-rounded">
 
          <label class="oswald-Cfont weight-small Bmargin-0p1" for="pass">Heslo</label>
          <input class="box-horizontal box-rounded border-gray Bmargin-0p1" type="password" id="pass" name="pass">
          <input class="box-horizontal Hpixelbox-1p5 bg-color-orange text-color-white text-full-center box-rounded oswald-Cfont weight-small Bmargin-0p1" type="submit" value="Potvrdit">
          <button class="box-horizontal Hpixelbox-1p5 bg-color-orange text-color-white text-full-center closepopup box-rounded oswald-Cfont weight-small" type="button">Zavřít</button>

         </div>
        </div>

      </form>
     <?php endif; ?>
     </div>
   </div> <!-- collapsible container end --->

  </div>



   <?php endwhile;?>
   <?php else: ?>
    <h1>NO RESULTS</h1>
  <?php endif;?>

</div>
<!--------------------------------------VYPISOVANI NABIDEK END---------------------------------------->  


  </main>

  <?php include "../footer.php"; ?>  

 </div>


    
</body>
</html>