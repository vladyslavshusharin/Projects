<?php 
session_start();
$_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];
require "../db_conn.php";

$showdata = "SELECT hodnoceni.*, ucet.Typ, ucet.Jmeno, ucet.Prijmeni, ucet.Profilovy_Obraz 
             FROM hodnoceni JOIN ucet ON hodnoceni.Ucet_ID = ucet.ID WHERE ucet.Typ = 'Zaměstnanec'";

$params = [];

$allowed_date = array("Vytvoreno ASC", "Vytvoreno DESC");
$allowed_obor = array("Informační Technologie", "Chemie a ekologie", "Designer", "Obchod", "Výuka a Škola", 
                      "Sociologie","Medicína","Obsluha");
$allowed_druh = array("Plný úvazek","Brigáda","Částečný úvazek", "Dočasný poměr", "Smlouva", "Praxe", 
                      "Freelance", "Home office");
$allowed_cities = array("Praha", "Zlín", "Brno", "Opava", "Karlovy Vary");
$allowed_hodnoceni = array("Špatné", "Průměrné", "Výborné");
$allowed_anonym = array("1", "0");

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
if(isset($_GET['MestoTag'])){
  if(!in_array($_GET['MestoTag'], $allowed_cities)){$MestoTag = "";}
  else{$MestoTag = $_GET['MestoTag'];}
}
if(isset($_GET['HodnoceniTag'])){
  if(!in_array($_GET['HodnoceniTag'], $allowed_hodnoceni)){$HodnoceniTag = "";}
  else{$HodnoceniTag = $_GET['HodnoceniTag'];}
}
if(isset($_GET['AnonymTag'])){
  if(!in_array($_GET['AnonymTag'], $allowed_anonym)){$AnonymTag = "";}
  else{$AnonymTag = $_GET['AnonymTag'];}
}
if(isset($_GET['searchtext'])){
  $SEARCHTEXT = $_GET['searchtext'];
}

if(!empty($OborTag) || !empty($DruhTag) || !empty($MestoTag) || !empty($HodnoceniTag) || !empty($AnonymTag)){
  if(!empty($OborTag)){
    $showdata = $showdata . " AND hodnoceni.Obor = ?";
    $params[] = $OborTag;
  }

  if(!empty($DruhTag)){
    $showdata = $showdata . " AND hodnoceni.Druh_Prace = ?";
    $params[] = $DruhTag;
  }

  if(!empty($MestoTag)){
    $showdata = $showdata . " AND hodnoceni.TAG_Mesto = ?";
    $params[] = $MestoTag;
  }
  if(!empty($HodnoceniTag)){
    $showdata = $showdata . " AND hodnoceni.Hodnoceni = ?";
    $params[] = $HodnoceniTag;
  }

  if(!empty($AnonymTag)){
    $showdata = $showdata . " AND hodnoceni.Anonym = ?";
    $params[] = $AnonymTag;
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
else{$showdata = $showdata . " ORDER BY hodnoceni.Vytvoreno ASC"; }

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
    <title>FineJob - Hodnocení Firem</title>
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
        <h1 class="oswald-Cfont full-center text-color-black">Hodnocení firem</h1>
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

       <select id="HodnoceniTag" name="HodnoceniTag" class="box-horizontal bg-color-gray box-rounded border-grayer">
      <?php if($_GET['HodnoceniTag'] != ""):?>
        <option value="<?php echo $_GET['HodnoceniTag']?>"><?php echo $_GET['HodnoceniTag']?></option>
        <option value="">Hodnocení</option>
      <?php else:?>
        <option value="">Hodnocení</option>
      <?php endif;?>
        <option value="Špatné">Špatné</option>
        <option value="Průměrné">Průměrné</option>
        <option value="Výborné">Výborné</option>
       </select>

       <select id="AnonymTag" name="AnonymTag" class="box-horizontal bg-color-gray box-rounded border-grayer">
        <option value="">Anonymita</option>
        <option value="1">Ano</option>
        <option value="0">Ne</option>
       </select>

      </div>
    </form>
   <div class="box-vertical border-trans">

    <?php if(isset($_SESSION['user_id'])):?>
     <?php if($_SESSION['usertype'] == "Zaměstnanec"):?>
     <div class="bg-color-orange box-rounded" style="min-height: 40px;">
     <a href="../Psani Hodnoceni/psat_hodnoceni_firmy.php" class="text-color-white bg-color-orange box-horizontal border-trans" style="height: 100%;"><p class="vertical-center oswald-Cfont">Napsat hodnocení</p></a>
     </div>
     <?php endif;?>
    <?php else:?>
     <div class="bg-color-orange box-rounded" style="min-height: 40px;"> 
     <a href="../Sign Up (Uzivatel)/signup_user.php" class="text-color-white bg-color-orange box-horizontal border-trans" style="height: 100%;"><p class="vertical-center oswald-Cfont">Chci napsat hodnocení</p></a> 
     </div>
     <?php endif;?>

   </div>

  </div>
<!--------------------------------------SEARCH BAR END---------------------------------------->  
  </div>
<!--------------------------------HORNI KONTENT STRANKY END-------------------------------------->

<!--------------------------------------VYPISOVANI HODNOCENI---------------------------------------->  

<div class="bigbox-vertical Rpadding-0p1 Lpadding-0p1 border-trans">

  <?php if($result->num_rows > 0):?>
   <?php while($row = $result->fetch_assoc()):?>

   <div class="bigbox-vertical Tmargin-0p5 Bmargin-0p25 box-rounded bg-color-gray">
    <h1 class="oswald-Cfont"><?php echo htmlspecialchars($row['Nadpis'])?></h1>
    
    <?php if($row['Anonym'] == 1):?>
    <img class="img-base box-rounded" src="../ProfilePics/Anonym.jpg" alt="PFP" style="width: 40px; height: 40px;">  
    <h2 class="oswald-Cfont weight-small"><?php echo htmlspecialchars("Anonym")?></h2>
    <?php else:?>
    <a href="../Profil/profil_selected.php?id=<?php echo $row['Ucet_ID'];?>" class="box-horizontal text-color-black no-text-decor border-trans null-padding">
     <img class="img-base box-rounded" src="<?php echo htmlspecialchars($row['Profilovy_Obraz'])?>" alt="PFP" style="width: 40px; height: 40px;">
    </a>
    <a href="../Profil/profil_selected.php?id=<?php echo $row['Ucet_ID'];?>" class="box-horizontal text-color-black no-text-decor border-trans null-padding">
     <h2 class="oswald-Cfont weight-small"><?php echo htmlspecialchars($row['Jmeno']) . " " . htmlspecialchars($row['Prijmeni'])?></h2>
    </a>
    
    <?php endif;?>
    
  <div class="collapsible-container collapsible-button box-vertical border-trans">

    <div class="box-horizontal box-rounded bg-color-grayer Bmargin-0p1">
     <?php if(!empty($row['Hodnoceni'])):?>
      <h3 class="box-horizontal border-trans oswald-Cfont weight-small"><?php echo $row['Hodnoceni']?></h3>  
     <?php endif;?>
    </div>

    <?php if(!empty($row['Obor']) || !empty($row['Druh_Prace']) || !empty($row['TAG_Mesto'])):?>
    <div class="box-horizontal border-trans" style="gap: 5px 5px; padding-left: 0;">

     <?php if(!empty($row['Obor'])):?>
      <h3 class="box-horizontal bg-color-grayer box-rounded oswald-Cfont weight-small"><?php echo $row['Obor']?></h3>  
     <?php endif;?>

     <?php if(!empty($row['Druh_Prace'])):?>
      <h3 class="box-horizontal bg-color-grayer box-rounded oswald-Cfont weight-small"><?php echo $row['Druh_Prace']?></h3>  
     <?php endif;?>

     <?php if(!empty($row['TAG_Mesto'])):?>
      <h3 class="box-horizontal bg-color-grayer box-rounded oswald-Cfont weight-small"><?php echo $row['TAG_Mesto']?></h3>  
     <?php endif;?>

     <?php if(!empty($row['TAG_PSC'])):?>
      <h3 class="box-horizontal bg-color-grayer box-rounded oswald-Cfont weight-small"><?php echo $row['TAG_PSC']?></h3>  
     <?php endif;?>

     <?php if(!empty($row['TAG_Ulice'])):?>
      <h3 class="box-horizontal bg-color-grayer box-rounded oswald-Cfont weight-small"><?php echo $row['TAG_Ulice']?></h3>  
     <?php endif;?>

    </div>
    <?php endif; ?>

    <h4 class="box-horizontal bg-color-grayer box-rounded oswald-Cfont weight-small"><?php echo htmlspecialchars($row['Vytvoreno'])?></h4>

    <div class="bigbox-vertical Collapsedbox-1p5 collapsible-content border-trans">
     <p class="oswald-Cfont weight-small"><?php echo nl2br(htmlspecialchars($row['Text']))?></p>
    </div>
    

  </div> <!-- collapsible container end --->

    <div class="box-horizontal border-trans" style="gap: 0 5px;">

    <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $row['Ucet_ID']):?>
     <a href="edit_hodnoceni_firem.php?id=<?php echo $row['ID'];?>" class="box-horizontal bg-color-orange box-rounded text-color-white oswald-Cfont text-pageread">Editovat</a>
    <?php endif;?>

    <?php if(isset($_SESSION['user_id']) && $row['Ucet_ID'] == $_SESSION['user_id']):?>
      <form action="delete_hodnoceni_firmy.php" method="POST">

        <input type="hidden" name="hodnoceni_ID" value="<?php echo $row['ID']?>">
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

   </div>



   <?php endwhile;?>
   <?php else: ?>
    <h1>ERROR, NO DATA</h1>
  <?php endif;?>




  </main>

</div>
<!--------------------------------------VYPISOVANI NABIDEK END---------------------------------------->  


  <?php include "../footer.php"; ?>  

 </div>


    
</body>
</html>