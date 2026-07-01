<?php
session_start();
$_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];
require "../db_conn.php";

if($_SERVER['REQUEST_METHOD'] == "GET"){
$showdata_firmy = "SELECT nabidky.*, ucet.Typ
                   FROM nabidky JOIN ucet ON nabidky.Ucet_ID = ucet.ID WHERE ucet.Typ = 'Firma'";
$params_firmy = [];

$showdata_zam = "SELECT nabidky.*, ucet.Typ
                 FROM nabidky JOIN ucet ON nabidky.Ucet_ID = ucet.ID WHERE ucet.Typ = 'Zaměstnanec'";
$params_zam = [];

$allowed_obor = array("Informační Technologie", "Chemie a ekologie", "Designer", "Obchod", "Výuka a Škola", 
                      "Sociologie","Medicína","Obsluha");
$allowed_pay = array("10000 20000", "20000 30000", "30000 40000", "40000 50000", "50000 60000", "60000 70000", "70000 80000", "80000 90000","90000 100000");
$allowed_druh = array("Plný úvazek","Brigáda","Částečný úvazek", "Dočasný poměr", "Smlouva", "Praxe", 
                      "Freelance", "Home office");
$allowed_cities = array("Praha", "Zlín", "Brno", "Opava", "Karlovy Vary");
$allowed_vzdelani = array("Student", "Zaměstnanec", "Junior", "Medior", "Senior","PhD","MUDr","Ing");
$allowed_zkusenost = array("0 let","1 rok","2 roky","3 roky","4 roky","5 let","5+ let","10 let","10+ let","20 let","20+ let");




if(isset($_GET['OborTag_firmy'])){
  if(!in_array($_GET['OborTag_firmy'], $allowed_obor)){$OborTag_firmy = "";}
  else{$OborTag_firmy = $_GET['OborTag_firmy'];}
}
if(isset($_GET['DruhTag_firmy'])){
  if(!in_array($_GET['DruhTag_firmy'], $allowed_druh)){$DruhTag_firmy = "";}
  else{$DruhTag_firmy = $_GET['DruhTag_firmy'];}
}
if(isset($_GET['MestoTag_firmy'])){
  if(!in_array($_GET['MestoTag_firmy'], $allowed_cities)){$MestoTag_firmy = "";}
  else{$MestoTag_firmy = $_GET['MestoTag_firmy'];}
}
if(isset($_GET['PlatRange_firmy'])){
  if(!in_array($_GET['PlatRange_firmy'], $allowed_pay)){$PlatRange_firmy = "";}
  else{$PlatRange_firmy = $_GET['PlatRange_firmy'];
       $PlatRange_firmy = explode(" ",$PlatRange_firmy);}
}



if(isset($_GET['VzdelaniTag_zam'])){
  if(!in_array($_GET['VzdelaniTag_zam'], $allowed_vzdelani)){$VzdelaniTag_zam = "";}
  else{$VzdelaniTag_zam = $_GET['VzdelaniTag_zam'];}
}
if(isset($_GET['OborTag_zam'])){
  if(!in_array($_GET['OborTag_zam'], $allowed_obor)){$OborTag_zam = "";}
  else{$OborTag_zam = $_GET['OborTag_zam'];}
}
if(isset($_GET['DruhTag_zam'])){
  if(!in_array($_GET['DruhTag_zam'], $allowed_druh)){$DruhTag_zam = "";}
  else{$DruhTag_zam = $_GET['DruhTag_zam'];}
}
if(isset($_GET['MestoTag_zam'])){
  if(!in_array($_GET['MestoTag_zam'], $allowed_cities)){$MestoTag_zam = "";}
  else{$MestoTag_zam = $_GET['MestoTag_zam'];}
}
if(isset($_GET['ZkusenostTag_zam'])){
  if(!in_array($_GET['ZkusenostTag_zam'], $allowed_zkusenost)){$ZkusenostTag_zam = "";}
  else{$ZkusenostTag_zam = $_GET['ZkusenostTag_zam'];}
}


if(!empty($OborTag_firmy) || !empty($DruhTag_firmy) || !empty($MestoTag_firmy) || !empty($PlatRange_firmy)){

    $count_tags_firmy = 0;

   if(!empty($OborTag_firmy)){
    $showdata_firmy = $showdata_firmy . " AND nabidky.Obor = ?";
    $count_tags_firmy++;
    $params_firmy[] = $OborTag_firmy;
    }
   if(!empty($DruhTag_firmy)){
    $showdata_firmy = $showdata_firmy . " AND nabidky.Druh_Prace = ?";
    $count_tags_firmy++;
    $params_firmy[] = $DruhTag_firmy;
    }
   if(!empty($MestoTag_firmy)){
    $showdata_firmy = $showdata_firmy . " AND nabidky.TAG_Mesto = ?";
    $count_tags_firmy++;
    $params_firmy[] = $MestoTag_firmy;
    }
   if(!empty($PlatRange_firmy)){
    $showdata_firmy = $showdata_firmy . " AND Plat BETWEEN ? AND ?";
    $count_tags_firmy++;
    $params_firmy[] = $PlatRange_firmy[0];
    $params_firmy[] = $PlatRange_firmy[1];
   }

}

if(!empty($OborTag_zam) || !empty($DruhTag_zam) || !empty($VzdelaniTag_zam) || !empty($MestoTag_zam) || !empty($ZkusenostTag_zam)){
    $count_tags_zam = 0;

   if(!empty($OborTag_zam)){
    $showdata_zam = $showdata_zam . " AND nabidky.Obor = ?";
    $count_tags_zam++;
    $params_zam[] = $OborTag_zam;
    }
   if(!empty($DruhTag_zam)){
    $showdata_zam = $showdata_zam . " AND nabidky.Druh_Prace = ?";
    $count_tags_zam++;
    $params_zam[] = $DruhTag_zam;
    }
   if(!empty($MestoTag_zam)){
    $showdata_zam = $showdata_zam . " AND nabidky.TAG_Mesto = ?";
    $count_tags_zam++;
    $params_zam[] = $MestoTag_zam;
    }
   if(!empty($VzdelaniTag_zam)){
    $showdata_zam = $showdata_zam . " AND nabidky.Vzdelani = ?";
    $count_tags_zam++;
    $params_zam[] = $VzdelaniTag_zam;
    }
   if(!empty($ZkusenostTag_zam)){
    $showdata_zam = $showdata_zam . " AND nabidky.Zkusenost = ?";
    $count_tags_zam++;
    $params_zam[] = $ZkusenostTag_zam;
    }  
}

$RESULTCOUNT_Zam = 0;
$result_zam = $db->query($showdata_zam, $params_zam);
if($result_zam->num_rows > 0){
    while($row_zam = $result_zam->fetch_assoc()){
        $RESULTCOUNT_Zam++;
    }
}

$RESULTCOUNT_Firmy = 0;
$result_firmy = $db->query($showdata_firmy, $params_firmy);
if($result_firmy->num_rows > 0){
    while($row_firmy = $result_firmy->fetch_assoc()){
        $RESULTCOUNT_Firmy++;
    }
 }

}//REQUEST METHOD GET

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
    <title>FineJob - Statistiky</title>
</head>
<body>

 <div class="site">

  <?php include "../header.php"; ?>    

  <main>

 
  

  <form class="bigbox-horizontal border-trans" method="GET">
  
    <div class="box-vertical col-5 box-rounded-left bg-color-orange">
      <h2 class="oswald-Cfont text-color-black">Nabídky od firem</h2>
        <div class="box-horizontal border-trans" style="gap: 5px 5px;">
          <select id="OborTag_firmy" name="OborTag_firmy" class="box-horizontal bg-color-gray box-rounded border-grayer">
            <?php if($_GET['OborTag_firmy'] != ""):?>
              <option value="<?php echo $_GET['OborTag_firmy']?>"><?php echo $_GET['OborTag_firmy']?></option>
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

          <select id="DruhTag_firmy" name="DruhTag_firmy" class="box-horizontal bg-color-gray box-rounded border-grayer">
            <?php if($_GET['DruhTag_firmy'] != ""):?>
              <option value="<?php echo $_GET['DruhTag_firmy']?>"><?php echo $_GET['DruhTag_firmy']?></option>
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

          <select id="MestoTag_firmy" name="MestoTag_firmy" class="box-horizontal bg-color-gray box-rounded border-grayer">
            <?php if($_GET['MestoTag_firmy'] != ""):?>
              <option value="<?php echo $_GET['MestoTag_firmy']?>"><?php echo $_GET['MestoTag_firmy']?></option>
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

          <select id="PlatRange_firmy" name="PlatRange_firmy" class="box-horizontal bg-color-gray box-rounded border-grayer">
            <?php if($_GET['PlatRange_firmy'] != ""):?>
              <option value="<?php echo $_GET['PlatRange_firmy']?>"><?php echo $PlatRange_firmy[0] . "-" . $PlatRange_firmy[1] . " Kč"?></option>
              <option value="">Plat</option>
            <?php else:?>
              <option value="">Plat</option>
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
        </div>

     <input type="submit" value="Hledat" class="box-horizontal bg-color-gray Hpixelbox-2 Tmargin-0p25 box-rounded border-grayer">
  
    </div>

   
    <div class="box-vertical col-5 box-rounded-right bg-color-orange">
      <h2 class="oswald-Cfont text-color-black">Nabídky od zaměstnanců</h2>
        <div class="box-horizontal border-trans" style="gap: 5px 5px;">
          <select id="OborTag_zam" name="OborTag_zam" class="box-horizontal bg-color-gray box-rounded border-grayer">
            <?php if($_GET['OborTag_zam'] != ""):?>
              <option value="<?php echo $_GET['OborTag_zam']?>"><?php echo $_GET['OborTag_zam']?></option>
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

          <select id="DruhTag_zam" name="DruhTag_zam" class="box-horizontal bg-color-gray box-rounded border-grayer">
            <?php if($_GET['DruhTag_zam'] != ""):?>
              <option value="<?php echo $_GET['DruhTag_zam']?>"><?php echo $_GET['DruhTag_zam']?></option>
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

          <select id="MestoTag_zam" name="MestoTag_zam" class="box-horizontal bg-color-gray box-rounded border-grayer">
            <?php if($_GET['MestoTag_zam'] != ""):?>
              <option value="<?php echo $_GET['MestoTag_zam']?>"><?php echo $_GET['MestoTag_zam']?></option>
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

          <select id="ZkusenostTag_zam" name="ZkusenostTag_zam" class="box-horizontal bg-color-gray box-rounded border-grayer">
            <?php if($_GET['ZkusenostTag_zam'] != ""):?>
              <option value="<?php echo $_GET['ZkusenostTag_zam']?>"><?php echo $_GET['ZkusenostTag_zam']?></option>
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

     <input type="submit" value="Hledat" class="box-horizontal bg-color-gray Hpixelbox-2 Tmargin-0p25 box-rounded border-grayer">

    </div>

   
  </form>

  <div class="bigbox-horizontal border-trans">
    <?php if($result_firmy):?>
    <div class="box-horizontal col-5 border-trans">
      <div class="box-horizontal Hpixelbox-6 Vpixelbox-2 bg-color-gray box-rounded horizontal-center">
       <h1 class="oswald-Cfont weight-medium full-center text-color-black"><?php echo "Počet nabídek od firem: " . $RESULTCOUNT_Firmy;?></h1>
      </div>
    </div>
    <?php endif;?>


  
  

    <?php if($result_zam):?>
    <div class="box-horizontal col-5 border-trans">
      <div class="box-horizontal Hpixelbox-6 Vpixelbox-2 bg-color-gray box-rounded horizontal-center">
       <h1 class="oswald-Cfont weight-medium full-center text-color-black"><?php echo "Počet nabídek od zaměstnanců: " . $RESULTCOUNT_Zam;?></h1>
      </div>
    </div>
    <?php endif;?>
  </div>
  

  


 


  

  </main>


  <?php include "../footer.php"; ?>  


 </div>


    
</body>
</html>