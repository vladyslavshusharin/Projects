<?php 
session_start();
$_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];
require "../db_conn.php";

$showdata = "SELECT nabidky.*, ucet.Typ, ucet.Jmeno, ucet.Prijmeni, ucet.Profilovy_Obraz 
             FROM nabidky JOIN ucet ON nabidky.Ucet_ID = ucet.ID WHERE ucet.Typ = 'Zaměstnanec'";
          
$params = [];       

$allowed_date = array("Vytvoreno ASC", "Vytvoreno DESC");
$allowed_obor = array("Informační Technologie", "Chemie a ekologie", "Designer", "Obchod", "Výuka a Škola", 
                      "Sociologie","Medicína","Obsluha");
$allowed_druh = array("Plný úvazek","Brigáda","Částečný úvazek", "Dočasný poměr", "Smlouva", "Praxe", 
                      "Freelance", "Home office");
$allowed_cities = array("Praha", "Zlín", "Brno", "Opava", "Karlovy Vary");
$allowed_zkusenost = array("0 let","1 rok","2 roky","3 roky","4 roky","5 let","5+ let","10 let","10+ let","20 let","20+ let");
$allowed_vzdelani = array("Student", "Zaměstnanec", "Junior", "Medior", "Senior","PhD","MUDr","Ing");

if(isset($_GET['DatumOrder'])){
  if(!in_array($_GET['DatumOrder'], $allowed_date)){$DatumOrder = "";}
  else{$DatumOrder = $_GET['DatumOrder'];}
}
if(isset($_GET['OborTag'])){
  if(!in_array($_GET['OborTag'], $allowed_obor)){$OborTag = "";}
  else{$OborTag = $_GET['OborTag'];}
}
if(isset($_GET['DruhTag'])){
  if(!in_array($_GET['DruhTag'], $allowed_druh)){$DruhTag = "";}
  else{$DruhTag = $_GET['DruhTag'];}
}
if(isset($_GET['ZkusenostTag'])){
  if(!in_array($_GET['ZkusenostTag'], $allowed_zkusenost)){$ZkusenostTag = "";}
  else{$ZkusenostTag = $_GET['ZkusenostTag'];}
}
if(isset($_GET['VzdelaniTag'])){
  if(!in_array($_GET['VzdelaniTag'], $allowed_vzdelani)){$VzdelaniTag = "";}
  else{$VzdelaniTag = $_GET['VzdelaniTag'];}
}
if(isset($_GET['MestoTag'])){
  if(!in_array($_GET['MestoTag'], $allowed_cities)){$MestoTag = "";}
  else{$MestoTag = $_GET['MestoTag'];}
}
if(isset($_GET['searchtext'])){
  $SEARCHTEXT = $_GET['searchtext'];
}

if(!empty($OborTag) || !empty($DruhTag) || !empty($VzdelaniTag) || !empty($ZkusenostTag) || !empty($MestoTag)){
  if(!empty($OborTag)){
    $showdata = $showdata . " AND nabidky.Obor = ?";
    $params[] = $OborTag;
  }

  if(!empty($DruhTag)){
    $showdata = $showdata . " AND nabidky.Druh_Prace = ?";
    $params[] = $DruhTag;
  }

  if(!empty($VzdelaniTag)){
    $showdata = $showdata . " AND nabidky.Vzdelani = ?";
    $params[] = $VzdelaniTag;
  }

  if(!empty($ZkusenostTag)){
    $showdata = $showdata . " AND nabidky.Zkusenost = ?";
    $params[] = $ZkusenostTag;
  }

  if(!empty($MestoTag)){
    $showdata = $showdata . " AND nabidky.TAG_Mesto = ?";
    $params[] = $MestoTag;
  }
}

if(!empty($SEARCHTEXT)){
  $search1 = "%" . trim($_GET['searchtext']) . "%";
  $showdata = $showdata ." AND Nadpis LIKE ?";
  $params[] = $search1;
}

if(!empty($DatumOrder)){

  $showdata = $showdata . " ORDER BY";

  if(!empty($DatumOrder)){
    $showdata = $showdata . " " . $DatumOrder;
  }

} 
else{$showdata = $showdata . " ORDER BY nabidky.Vytvoreno ASC"; }

$result = $db->query($showdata, $params);

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
    <title>FineJob - Hledat zaměstnance</title>
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
        <h1 class="oswald-Cfont full-center text-color-black">Hledání zaměstanců</h1>
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

       <select id="VzdelaniTag" name="VzdelaniTag" class="box-horizontal bg-color-gray box-rounded border-grayer">
      <?php if($_GET['VzdelaniTag'] != ""):?>
        <option value="<?php echo $_GET['VzdelaniTag']?>"><?php echo $_GET['VzdelaniTag']?></option>
        <option value="">Vzdělání</option>
      <?php else:?>
        <option value="">Vzdělání</option>
      <?php endif;?>
        <option value="Student">Student</option>
        <option value="Zaměstnanec">Zaměstnanec</option>
        <option value="Junior">Junior</option>
        <option value="Medior">Medior</option>
        <option value="Senior">Senior</option>
        <option value="PhD">PhD</option>
        <option value="MUDr">MUDr</option>
        <option value="Ing">Ing</option>
       </select>

       <select id="ZkusenostTag" name="ZkusenostTag" class="box-horizontal bg-color-gray box-rounded border-grayer">
      <?php if($_GET['ZkusenostTag'] != ""):?>
        <option value="<?php echo $_GET['ZkusenostTag']?>"><?php echo $_GET['ZkusenostTag']?></option>
        <option value="">Zkušenost</option>
      <?php else:?>
        <option value="">Zkušenost</option>
      <?php endif;?>
        <option value="0 let">0</option>
        <option value="1 rok">1 rok</option>
        <option value="2 roky">2 roky</option>
        <option value="3 roky">3 roky</option>
        <option value="4 roky">4 roky</option>
        <option value="5 let">5 let</option>
        <option value="5+ let">5+ let</option>
        <option value="10 let">10 let</option>
        <option value="10+ let">10+ let</option>
        <option value="20 let">20 let</option>
        <option value="20+ let">20+ let</option>
       </select>

      </div>
    </form>
   <div class="box-vertical border-trans">

    <?php if(isset($_SESSION['user_id'])):?>
     <?php if($_SESSION['usertype'] == "Zaměstnanec"):?>
     <div class="bg-color-orange box-rounded" style="min-height: 40px;">
     <a href="../Psani nabidky/psat_nabidky_zamestnancu.php" class="text-color-white bg-color-orange box-horizontal border-trans" style="height: 100%;"><p class="vertical-center oswald-Cfont">Napsat Nabidku</p></a>
     </div>
     <?php endif;?>
    <?php else:?>
     <div class="bg-color-orange box-rounded" style="min-height: 40px;"> 
     <a href="../Sign Up (Uzivatel)/signup_user.php" class="text-color-white bg-color-orange box-horizontal border-trans" style="height: 100%;"><p class="vertical-center oswald-Cfont">Chci napsat nabídku práce</p></a> 
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
    <h2 class="oswald-Cfont weight-small"><?php echo htmlspecialchars($row['Jmeno']) . " " . htmlspecialchars($row['Prijmeni'])?></h2>
    </a>
    
  <div class="collapsible-container collapsible-button box-vertical border-trans">

    <?php if(!empty($row['Obor']) || !empty($row['Druh_Prace']) || !empty($row['Vzdelani']) || !empty($row['Zkusenost']) || !empty($row['TAG_Mesto'])):?>
    <div class="box-horizontal border-trans" style="gap: 5px 5px; padding-left: 0;">

     <?php if(!empty($row['Obor'])):?>
      <h3 class="box-horizontal bg-color-grayer box-rounded oswald-Cfont weight-small"><?php echo $row['Obor']?></h3>  
     <?php endif;?>

     <?php if(!empty($row['Druh_Prace'])):?>
      <h3 class="box-horizontal bg-color-grayer box-rounded oswald-Cfont weight-small"><?php echo $row['Druh_Prace']?></h3>  
     <?php endif;?>

     <?php if(!empty($row['Vzdelani'])):?>
      <h3 class="box-horizontal bg-color-grayer box-rounded oswald-Cfont weight-small"><?php echo $row['Vzdelani']?></h3>  
     <?php endif;?>

     <?php if(!empty($row['Zkusenost'])):?>
      <h3 class="box-horizontal bg-color-grayer box-rounded oswald-Cfont weight-small"><?php echo $row['Zkusenost']?></h3>  
     <?php endif;?>

     <?php if(!empty($row['TAG_Mesto'])):?>
      <h3 class="box-horizontal bg-color-grayer box-rounded oswald-Cfont weight-small"><?php echo $row['TAG_Mesto']?></h3>  
     <?php endif;?>

    </div>
    <?php endif; ?>


    <h4 class="box-horizontal bg-color-grayer box-rounded oswald-Cfont weight-small"><?php echo htmlspecialchars($row['Vytvoreno'])?></h4>
    <div class="bigbox-vertical Collapsedbox-1p5 collapsible-content border-trans">
     <p class="oswald-Cfont weight-small"><?php echo nl2br(htmlspecialchars($row['Text']))?></p>
    </div>
    
    <div class="box-horizontal border-trans" style="gap: 0 5px;">

    <?php if(isset($_SESSION['user_id']) && isset($_SESSION['usertype']) && $_SESSION['usertype'] == "Firma"):?>
     <?php if($row['Ucet_ID'] != $_SESSION['user_id']):?>
      <a href="../Direct Message/direct_message.php?message_to_id=<?php echo $row['Ucet_ID'];?>" class="box-horizontal bg-color-orange text-color-white box-rounded oswald-Cfont text-pageread">Odpovědět</a>
     <?php endif;?>
    <?php elseif(isset($_SESSION['usertype']) && $_SESSION['usertype'] != "Firma"):?>
      
    <?php else:?>
     <a href="../Sign Up (Firma)/signup_firma.php" class="box-horizontal bg-color-orange text-color-white box-rounded oswald-Cfont text-pageread">Odpovědět</a>
    <?php endif;?>

    <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $row['Ucet_ID']):?>
      <a href="edit_zamestnanec.php?id=<?php echo $row['ID'];?>" class="box-horizontal bg-color-orange box-rounded text-color-white oswald-Cfont text-pageread">Editovat</a>
    <?php endif;?>
      

    <?php if(isset($_SESSION['user_id']) && $row['Ucet_ID'] == $_SESSION['user_id']):?>
      <form action="delete_nabidka_zam.php" method="POST">

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
    <h1>ERROR, NO DATA</h1>
  <?php endif;?>

</div>
<!--------------------------------------VYPISOVANI NABIDEK END---------------------------------------->  

  </main>




  <?php include "../footer.php"; ?>  

 </div>


    
</body>
</html>