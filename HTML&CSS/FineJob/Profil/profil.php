<?php 
session_start();
$_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];
require "../db_conn.php";

if($_SESSION['user_id']){

$userid = $_SESSION['user_id'];
$showdata = "SELECT * FROM ucet WHERE ucet.ID = ?";

$result = $db->query($showdata,[$userid]);
$PROFILDATA = $result->fetch_assoc();

$shownabidky = "SELECT * FROM nabidky WHERE Ucet_ID = ?";
$result_nabidky = $db->query($shownabidky,[$userid]);

$showhodnoceni = "SELECT * FROM hodnoceni WHERE Ucet_ID = ?";
$result_hodnoceni = $db->query($showhodnoceni,[$userid]);
}

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
    <title>FineJob - Profil</title>
</head>
<body>
    

<div class="site">

<?php include "../header.php"; ?>    

      <main>
<!----------------------------------ZAMĚSTNANEC--------------------------------------------------->       
      <?php if(isset($_SESSION['user_id'])): ?>
        <?php if($_SESSION['usertype'] == "Zaměstnanec"):?>
         <div class="bigbox-horizontal border-trans">
          <div class="box-horizontal border-trans">  
          <img class="img-base box-rounded" src="<?php echo $_SESSION['pfp'];?>" alt="Profile Picture here" style="width: 150px; height: 150px;">
          <div class="box-vertical border-trans">
           <h1 class="box-horizontal bg-color-gray oswald-Cfont box-rounded stick-to-bottom"><?php echo htmlspecialchars($_SESSION['name']) . " " . htmlspecialchars($_SESSION['surname']);?></h1>
          </div>
          </div>
          <div class="box-vertical border-trans">
           <div class="stick-to-bottom">
           <h3 class="box-horizontal border-trans oswald-Cfont weight-small">E-mail: <?php echo $_SESSION['usermail'];?></h3>
           <h3 class="box-horizontal border-trans oswald-Cfont weight-small">Datum narození: <?php echo $_SESSION['dateofb'];?></h3>
           </div>
          </div>

        <div class="box-vertical border-trans" style="gap: 5px; justify-content: end">
          <div>
           <a href="profil_edit_user.php"class="box-horizontal bg-color-orange text-color-white box-rounded oswald-Cfont text-pageread">Editovat profil</a>  
          </div>

          <form action="../deleteprofile.php" method="POST">
            <button class="box-horizontal Hpixelbox-1p5 bg-color-orange text-color-white text-full-center box-rounded oswald-Cfont text-pageread" id="openpopup" type="button">Odstranit profil</button>
            <div class="popup" id="popup">
              <div class="box-vertical full-center bg-color-gray">

                <h4 class="text-color-black">Chcete doopravdy odstranit profil?</h4>
                <label for="pass">Heslo</label>
                <input class="box-horizontal" type="password" id="pass" name="pass">
                <?php if(isset($_SESSION['delete_message'])){echo '<p style="color: red;" class="oswald-Cfont" id="error_message">'. $_SESSION["delete_message"] . '</p>';}?>
                <input class="box-horizontal Hpixelbox-1p5 bg-color-orange text-color-white text-full-center" type="submit" value="Ano">
                <button class="box-horizontal Hpixelbox-1p5 bg-color-orange text-color-white text-full-center" id="closepopup" type="button">Ne</button>

              </div>
            </div>
          </form>
          <div>
            <a href="../Direct Message/direct_message.php" class="box-horizontal bg-color-orange text-color-white box-rounded oswald-Cfont text-pageread">Zprávy</a>
          </div>
        </div>

         </div> 
         <div class="box-vertical Hpixelbox-7p5 border-trans">
          <h2 class="oswald-Cfont horizontal-center">Popis</h2>
          <p class="textbox oswald-Cfont weight-small"><?php echo nl2br(htmlspecialchars($PROFILDATA['Popis']))?></p>
         </div>

         <?php if(!empty($PROFILDATA['Soubor_Dokument'])):?>
         <div class="box-vertical Hpixelbox-8 Tmargin-1 Bmargin-1 border-trans">
          <h2 class="oswald-Cfont horizontal-center">Dokument</h2>
          <iframe src="<?php echo $PROFILDATA['Soubor_Dokument']?>#zoom=90" frameborder="0" height="1000px" max-width="800px"style="border: none;">
           This browser does not support PDFs. Please download the PDF to view it:
           <a href="<?php echo $PROFILDATA['Soubor_Dokument']?>" download>Download</a>
          </iframe>
          <a class="bg-color-orange no-text-decor Hpixelbox-1 box-rounded horizontal-center" href="<?php echo $PROFILDATA['Soubor_Dokument'];?>" download><h4 class="oswald-Cfont text-color-white horizontal-center">Stáhnout</h4></a>
         </div> 
         <?php endif;?>

<div class="bigbox-horizontal border-trans">
<!-----------------------------NABIDKY ZAMESTNANEC------------------------------------->
 <div class="box-vertical col-5 border-trans">
<h1 class="horizontal-center Bmargin-0p5 oswald-Cfont">Nabídky práce</h1>
<?php if($result_nabidky->num_rows > 0):?>
  <?php while($row = $result_nabidky->fetch_assoc()):?>

 <div class="bigbox-vertical Bmargin-0p25 bg-color-gray box-rounded">
    <h1 class="oswald-Cfont"><?php echo htmlspecialchars($row['Nadpis'])?></h1>
    <img class="box-rounded" src="<?php echo htmlspecialchars($PROFILDATA['Profilovy_Obraz'])?>" alt="PFP" style="width: 35px; height: 35px;">
    <h2 class="oswald-Cfont weight-small"><?php echo htmlspecialchars($PROFILDATA['Jmeno']) . " " . htmlspecialchars($PROFILDATA['Prijmeni'])?></h2>
    
    
  <div class="collapsible-container collapsible-button box-vertical border-trans">

    <?php if(!empty($row['Obor']) || !empty($row['Druh_Prace']) || !empty($row['Vzdelani']) || !empty($row['Zkusenost']) || !empty($row['TAG_Mesto'])):?>
    <div class="box-horizontal border-trans" style="gap: 5px; padding-left: 0;">

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
    <div class="box-vertical Hpixelbox-10 Collapsedbox-1p5 collapsible-content border-trans Bmargin-0p1 Tmargin-0p1">
     <p class="oswald-Cfont weight-small"><?php echo htmlspecialchars($row['Text'])?></p>
    </div>

    <div class="box-horizontal border-trans null-padding" style="gap: 0 5px;">

    <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $row['Ucet_ID']):?>
      <a href="../Hledani Pracovnika/edit_zamestnanec.php?id=<?php echo $row['ID'];?>" class="box-horizontal bg-color-orange box-rounded text-color-white oswald-Cfont text-pageread">Editovat</a>
    <?php endif;?>

    <?php if($row['Ucet_ID'] == $_SESSION['user_id']):?>
      <form action="../Hledani Pracovnika/delete_nabidka_zam.php" method="POST">

        <input type="hidden" name="nabidka_ID" value="<?php echo $row['ID']?>">
        <button class="box-horizontal bg-color-orange text-color-white text-full-center openpopup box-rounded text-color-white oswald-Cfont text-pageread" type="button">Odstranit</button>
       <div class="popup">
        <div class="box-vertical full-center bg-color-gray">

        <label for="pass">Heslo</label>
        <input class="box-horizontal" type="password" id="pass" name="pass">
        <input class="box-horizontal Hpixelbox-1p5 bg-color-orange text-color-white text-full-center" type="submit" value="Potvrdit">
        <button class="box-horizontal Hpixelbox-1p5 bg-color-orange text-color-white text-full-center closepopup" type="button">Zavřít</button>

        </div>
       </div>

      </form>
    <?php endif; ?>

    </div>
    

  </div>
  </div>

   <?php endwhile;?>
   <?php else: ?>
    <h1>NO NABIDKY</h1>
  <?php endif;?>

 </div>
<!-----------------------------NABIDKY ZAMESTNANEC END-------------------------------------> 

<!-----------------------------HODNOCENI ZAMESTNANEC------------------------------------->
 <div class="box-vertical col-5 border-trans">
 <h1 class="horizontal-center Bmargin-0p5 oswald-Cfont">Hodnocení firem</h1>

 <?php if($result_hodnoceni->num_rows > 0):?>
   <?php while($row = $result_hodnoceni->fetch_assoc()):?>

   <div class="bigbox-vertical Bmargin-0p25 box-rounded bg-color-gray">
    <h1 class="oswald-Cfont"><?php echo htmlspecialchars($row['Nadpis'])?></h1>
    <?php if($row['Anonym'] == 1):?>
     <img class="box-rounded" src="../ProfilePics/Anonym.jpg" alt="PFP" style="max-width: 35px; max-height: 35px;">  
     <h2 class="oswald-Cfont weight-small"><?php echo htmlspecialchars("Anonym")?></h2>
    <?php else:?>
     <img class="box-rounded" src="<?php echo htmlspecialchars($PROFILDATA['Profilovy_Obraz'])?>" alt="PFP" style="width: 35px; height: 35px;">
     <h2 class="oswald-Cfont weight-small"><?php echo htmlspecialchars($PROFILDATA['Jmeno']) . " " . htmlspecialchars($PROFILDATA['Prijmeni'])?></h2>
    <?php endif;?>
     
  <div class="collapsible-container collapsible-button box-vertical border-trans">

    <div class="box-horizontal bg-color-grayer box-rounded Bmargin-0p1">
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

    <div class="box-vertical Hpixelbox-10 Collapsedbox-1p5 collapsible-content border-trans Bmargin-0p1 Tmargin-0p1">
     <p class="oswald-Cfont weight-small"><?php echo htmlspecialchars($row['Text'])?></p>
    </div>
    

  </div>
    <?php if($row['Ucet_ID'] == $_SESSION['user_id']):?>
      <form action="../Hodnoceni Firem/delete_hodnoceni_firmy.php" method="POST">

        <input type="hidden" name="hodnoceni_ID" value="<?php echo $row['ID']?>">
        <button class="box-horizontal bg-color-orange text-color-white text-full-center openpopup box-rounded text-color-white oswald-Cfont text-pageread" type="button">Odstranit</button>
       <div class="popup">
        <div class="box-vertical full-center bg-color-gray">

        <label for="pass">Heslo</label>
        <input class="box-horizontal" type="password" id="pass" name="pass">
        <input class="box-horizontal Hpixelbox-1p5 bg-color-orange text-color-white text-full-center" type="submit" value="Potvrdit">
        <button class="box-horizontal Hpixelbox-1p5 bg-color-orange text-color-white text-full-center closepopup" type="button">Zavřít</button>

        </div>
       </div>

      </form>
    <?php endif; ?>
   </div>



   <?php endwhile;?>
   <?php else: ?>
    <h1>ERROR, NO DATA</h1>
  <?php endif;?>


 </div>
<!-----------------------------HODNOCENI ZAMESTNANEC END------------------------------------->
</div>

<!----------------------------------ZAMĚSTNANEC END--------------------------------------------------->       


<!----------------------------------FIRMA--------------------------------------------------->        
        <?php elseif($_SESSION['usertype'] == "Firma"):?>
      <div class="bigbox-horizontal border-trans">
          <div class="box-horizontal border-trans">  
          <img class="img-base box-rounded" src="<?php echo $_SESSION['pfp'];?>" alt="Profile Picture here" style="width: 150px; height: 150px;">
          <div class="box-vertical border-trans">
           <h1 class="bg-color-gray Lpadding-0p1 Rpadding-0p1 Bpadding-0p1 Tpadding-0p1 box-rounded stick-to-bottom oswald-Cfont"><?php echo $_SESSION['name'];?></h1>
          </div>
          </div>
          <div class="box-vertical border-trans">
           <div class="stick-to-bottom">
           <h3 class="box-horizontal border-trans oswald-Cfont weight-small">E-mail: <?php echo $_SESSION['usermail'];?></h3>
           <h3 class="box-horizontal border-trans oswald-Cfont weight-small">Datum stvoření: <?php echo $_SESSION['dateofc'];?></h3>
           <h3 class="box-horizontal border-trans oswald-Cfont weight-small">Odkaz: <a class="oswald-Cfont weight-small" href="<?php echo "https://www.". $PROFILDATA['Odkaz'];?>" target="_blank" rel="noopener noreferrer"><?php echo $PROFILDATA['Odkaz'];?></a></h3>
           <h3 class="box-horizontal border-trans oswald-Cfont weight-small"><?php echo $_SESSION['compcity'] . ", " . $_SESSION['citypsc'] . ", " . $_SESSION['street'];?></h3>
           </div>
          </div>

        <div class="box-vertical border-trans" style="gap: 5px; justify-content: end;">
          <div>
           <a href="profil_edit_firma.php" class="box-horizontal bg-color-orange text-color-white box-rounded oswald-Cfont text-pageread">Editovat profil</a>  
          </div>

          <form action="../deleteprofile.php" method="POST">
            <button class="box-horizontal Hpixelbox-1p5 bg-color-orange text-color-white text-full-center box-rounded oswald-Cfont text-pageread" id="openpopup" type="button">Odstranit profil</button>
            <div class="popup" id="popup">
              <div class="box-vertical full-center bg-color-gray">

                <h4 class="text-color-black">Chcete doopravdy odstranit profil?</h4>
                <label for="pass">Heslo</label>
                <input class="box-horizontal" type="password" id="pass" name="pass">
                <?php if(isset($_SESSION['delete_message'])){echo '<p style="color: red;" class="oswald-Cfont" id="error_message">'. $_SESSION["delete_message"] . '</p>';}
                         unset($_SESSION['delete_message']);?>
                <input class="box-horizontal Hpixelbox-1p5 bg-color-orange text-color-white text-full-center" type="submit" value="Ano">
                <button class="box-horizontal Hpixelbox-1p5 bg-color-orange text-color-white text-full-center" id="closepopup" type="button">Ne</button>

              </div>
            </div>
          </form>
          <div>
            <a href="../Direct Message/direct_message.php" class="box-horizontal bg-color-orange text-color-white box-rounded oswald-Cfont text-pageread">Zprávy</a>
          </div>
        </div>

      </div> 
         <div class="box-vertical Hpixelbox-7p5 border-trans">
          <h2 class="horizontal-center oswald-Cfont">Popis</h2>
          <p class="oswald-Cfont weight-small"><?php echo nl2br(htmlspecialchars($PROFILDATA['Popis']))?></p>
         </div>
         
<div class="bigbox-horizontal Tmargin-1 border-trans">
<!------------------------------NABIDKY FIRMA------------------------------------->
<div class="box-vertical col-5 border-trans">
<h1 class="horizontal-center oswald-Cfont">Nabídky práce</h1>
<?php if($result_nabidky->num_rows > 0):?>
   <?php while($row = $result_nabidky->fetch_assoc()):?>

  <div class="bigbox-vertical Tmargin-0p5 Bmargin-0p25 box-rounded bg-color-gray">
   <h1 class="oswald-Cfont"><?php echo htmlspecialchars($row['Nadpis'])?></h1>
   <img class="box-rounded" src="<?php echo htmlspecialchars($PROFILDATA['Profilovy_Obraz'])?>" alt="PFP" style="width: 35px; height: 35px;">
   <h2 class="oswald-Cfont weight-small"><?php echo htmlspecialchars($PROFILDATA['Nazev'])?></h2>

   
  <div class="collapsible-container collapsible-button box-vertical border-trans">
   
   <?php if(!empty($row['Obor']) || !empty($row['Druh_Prace']) || !empty($row['Plat']) || !empty($row['TAG_Mesto']) || !empty($row['TAG_Ulice'])):?>

   <div class="box-horizontal border-trans" style="gap: 0px 5px; padding-left: 0">
    <?php if(!empty($row['Obor'])):?>
     <h3 class="box-horizontal bg-color-grayer box-rounded oswald-Cfont weight-small"><?php echo htmlspecialchars($row['Obor'])?></h3>
    <?php endif;?>
    <?php if(!empty($row['Druh_Prace'])):?>
    <h3 class="box-horizontal bg-color-grayer box-rounded oswald-Cfont weight-small"><?php echo htmlspecialchars($row['Druh_Prace'])?></h3>
    <?php endif;?>
    <?php if(!empty($row['Plat'])):?>
    <h3 class="box-horizontal bg-color-grayer box-rounded oswald-Cfont weight-small"><?php echo htmlspecialchars($row['Plat']) . " Kč"?></h3>
    <?php endif;?>
    <?php if(!empty($row['TAG_Mesto'])):?>
    <h3 class="box-horizontal bg-color-grayer box-rounded oswald-Cfont weight-small"><?php echo htmlspecialchars($row['TAG_Mesto'])?></h3>
    <?php endif;?>
    <?php if(!empty($row['TAG_Ulice'])):?>
    <h3 class="box-horizontal bg-color-grayer box-rounded oswald-Cfont weight-small"><?php echo htmlspecialchars($row['TAG_Ulice'])?></h3>
    <?php endif;?>
   </div>

   <?php endif;?>


    <h4 class="box-horizontal box-rounded bg-color-grayer oswald-Cfont weight-small"><?php echo htmlspecialchars($row['Vytvoreno'])?></h4>
    <div class="box-vertical Hpixelbox-10 Collapsedbox-1p5 collapsible-content border-trans Tmargin-0p1 Bmargin-0p1">
     <p class="oswald-Cfont weight-small"><?php echo htmlspecialchars($row['Text'])?></p>
    </div>
    
    <div class="box-horizontal border-trans" style="gap: 0 5px;">

    <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $row['Ucet_ID']):?>
      <a href="../Hledani Prace/edit_nabidka_prace.php?id=<?php echo $row['ID'];?>" class="box-horizontal bg-color-orange box-rounded text-color-white oswald-Cfont text-pageread">Editovat</a>
    <?php endif;?>
    
    <?php if($row['Ucet_ID'] == $_SESSION['user_id']):?>
      <form action="../Hledani Prace/delete_nabidka_prace.php" method="POST">

        <input type="hidden" name="nabidka_ID" value="<?php echo $row['ID']?>">
        <button class="box-horizontal bg-color-orange text-color-white text-full-center openpopup box-rounded oswald-Cfont text-pageread" type="button">Odstranit</button>
       <div class="popup">
        <div class="box-vertical full-center bg-color-gray">

        <label for="pass">Heslo</label>
        <input class="box-horizontal" type="password" id="pass" name="pass">
        <input class="box-horizontal Hpixelbox-1p5 bg-color-orange text-color-white text-full-center" type="submit" value="Potvrdit">
        <button class="box-horizontal Hpixelbox-1p5 bg-color-orange text-color-white text-full-center closepopup" type="button">Zavřít</button>

        </div>
       </div>

      </form>
    <?php endif; ?>

    </div>

    
  </div>
 </div>

   <?php endwhile;?>
   <?php else: ?>
    <h1>NO RESULTS</h1>
  <?php endif;?>


</div>
<!------------------------------NABIDKY FIRMA END----------------------------->

<!------------------------------HODNOCENI FIRMA----------------------------->
<div class="box-vertical col-5 border-trans">
<h1 class="horizontal-center oswald-Cfont">Hodnocení prácovníku</h1>
<?php if($result_hodnoceni->num_rows > 0):?>
   <?php while($row = $result_hodnoceni->fetch_assoc()):?>

   <div class="bigbox-vertical Tmargin-0p5 Bmargin-0p25 box-rounded bg-color-gray">
    <h1 class="oswald-Cfont"><?php echo htmlspecialchars($row['Nadpis'])?></h1>
    <img class="box-rounded" src="<?php echo htmlspecialchars($PROFILDATA['Profilovy_Obraz'])?>" alt="PFP" style="width: 35px; height: 35px;">
    <h2 class="oswald-Cfont weight-small"><?php echo htmlspecialchars($PROFILDATA['Nazev'])?></h2>
  <div class="collapsible-container collapsible-button box-vertical border-trans">

    <div class="box-horizontal box-rounded bg-color-grayer Bmargin-0p1">
     <?php if(!empty($row['Hodnoceni'])):?>
      <h3 class="box-horizontal border-trans oswald-Cfont weight-small"><?php echo $row['Hodnoceni']?></h3>  
     <?php endif;?>
    </div>

    <?php if(!empty($row['Obor']) || !empty($row['Druh_Prace']) || !empty($row['TAG_Mesto'])):?>
    <div class="box-horizontal border-trans" style="gap: 0px 5px; padding-left: 0">

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
    
    <h4 class="box-horizontal box-rounded bg-color-grayer oswald-Cfont weight-small"><?php echo htmlspecialchars($row['Vytvoreno'])?></h4>
    
    <div class="box-vertical Hpixelbox-10 Collapsedbox-1p5 collapsible-content border-trans Tmargin-0p1 Bmargin-0p1">
     <p class="oswald-Cfont weight-small"><?php echo htmlspecialchars($row['Text'])?></p>
    </div>
    
  </div> 

    <?php if($row['Ucet_ID'] == $_SESSION['user_id']):?>
      <form action="../Hodnoceni Pracovnika/delete_hodnoceni_zam.php" method="POST">

        <input type="hidden" name="hodnoceni_ID" value="<?php echo $row['ID']?>">
        <button class="box-horizontal bg-color-orange text-color-white text-full-center openpopup box-rounded oswald-Cfont text-pageread" type="button">Odstranit</button>
       <div class="popup">
        <div class="box-vertical full-center bg-color-gray">

        <label for="pass">Heslo</label>
        <input class="box-horizontal" type="password" id="pass" name="pass">
        <input class="box-horizontal Hpixelbox-1p5 bg-color-orange text-color-white text-full-center" type="submit" value="Potvrdit">
        <button class="box-horizontal Hpixelbox-1p5 bg-color-orange text-color-white text-full-center closepopup" type="button">Zavřít</button>

        </div>
       </div>

      </form>
    <?php endif; ?>

 </div>



   <?php endwhile;?>
   <?php else: ?>
    <h1>NO RESULTS</h1>
  <?php endif;?>


</div>
<!------------------------------HODNOCENI FIRMA END----------------------------->

</div>
<!-------------------------------------FIRMA END--------------------------------------------------->    
        <?php else: ?>
      
         <h1>PROFIL NENAJDEN</h1>

        <?php endif; ?>

        



      <?php else:?>
      
      <?php header("Location: ../Main Page/mainpage.php");?>

      <?php endif; ?>


      </main>


<?php include "../footer.php"; ?>  

 



</div>





</body>
</html>