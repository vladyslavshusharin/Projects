<?php 
session_start();
$_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];
require "../db_conn.php";

if(isset($_SESSION['user_id']) && $_GET['id'] == $_SESSION['user_id']){
  header("Location: profil.php");
}

if($_GET['id']){

$userid = $_GET['id'];
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

<!------------------------------------ZAMESTNANEC-------------------------------------------------->  

<?php include "../header.php"; ?>    

      <main>
    
      <?php if(isset($PROFILDATA['ID'])): ?>
        <?php if($PROFILDATA['Typ'] == "Zaměstnanec"):?>
         <div class="bigbox-horizontal border-trans">
          <div class="box-horizontal border-trans">  
          <img class="img-base box-rounded" src="<?php echo $PROFILDATA['Profilovy_Obraz'];?>" alt="Profile Picture here" style="width: 150px; height: 150px;">
          <div class="box-vertical border-trans">
           <h1 class="bg-color-gray Lpadding-0p1 Rpadding-0p1 Bpadding-0p1 Tpadding-0p1 box-rounded stick-to-bottom oswald-Cfont"><?php echo $PROFILDATA['Jmeno'] . " " . $PROFILDATA['Prijmeni'];?></h1>  
          </div>
          </div>
          <div class="box-vertical border-trans">
           <div class="stick-to-bottom">
            <h3 class="box-horizontal border-trans oswald-Cfont weight-small">E-mail: <?php echo $PROFILDATA['E-mail'];?></h3>
            <h3 class="box-horizontal border-trans oswald-Cfont weight-small">Datum narození: <?php echo $PROFILDATA['Datum'];?></h3>
           </div>
          </div>
          <div class="box-vertical border-trans" style="justify-content: end;">
           <?php if(isset($_SESSION['user_id']) && $_SESSION['usertype'] != $PROFILDATA['Typ']):?>
            <a href="../Direct Message/direct_message.php?message_to_id=<?php echo $PROFILDATA['ID'];?>" class="box-horizontal bg-color-orange text-color-white box-rounded oswald-Cfont text-pageread">Napsat zprávu</a>
           <?php endif;?>
          </div>
         </div> 
         <div class="box-vertical Hpixelbox-7p5 border-trans">
          <h2 class="horizontal-center oswald-Cfont">Popis</h2>
          <p class="textbox oswald-Cfont weight-small"><?php echo htmlspecialchars($PROFILDATA['Popis'])?></p>
         </div>

         <?php if(!empty($PROFILDATA['Soubor_Dokument'])):?>
         <div class="box-horizontal Hpixelbox-8 Tmargin-1 Bmargin-1 border-trans">
          <h2 class="oswald-Cfont horizontal-center">Dokument</h2>
          <iframe src="<?php echo $PROFILDATA['Soubor_Dokument']?>#zoom=90" frameborder="0" height="1000px" width="800px"style="border: none;">
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

 <div class="bigbox-vertical Bmargin-0p25 box-rounded bg-color-gray">
    <h1 class="oswald-Cfont"><?php echo htmlspecialchars($row['Nadpis'])?></h1>
    <img class="img-base box-rounded" src="<?php echo htmlspecialchars($PROFILDATA['Profilovy_Obraz'])?>" alt="PFP" style="width: 35px; height: 35px;">
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
    <div class="box-vertical Hpixelbox-10 Collapsedbox-1p5 collapsible-content border-trans">
     <p class="oswald-Cfont weight-small"><?php echo htmlspecialchars($row['Text'])?></p>
    </div>

    <?php if(isset($_SESSION['user_id']) && $row['Ucet_ID'] != $_SESSION['user_id'] && $_SESSION['usertype'] == "Firma"):?>
    <a href="../Direct Message/direct_message.php?message_to_id=<?php echo $row['Ucet_ID'];?>" class="box-horizontal bg-color-orange text-color-white box-rounded oswald-Cfont text-pageread">Odpovědět</a>
    <?php endif;?>

  </div>
   </div>

   <?php endwhile;?>
   <?php else: ?>
    <h1>NO NABIDKY</h1>
  <?php endif;?>

 </div>
<!-----------------------------NABIDKY END-------------------------------------> 

<!-----------------------------HODNOCENI ZAMESTNANEC------------------------------------->
 <div class="box-vertical col-5 border-trans">
 <h1 class="horizontal-center Bmargin-0p5 oswald-Cfont">Hodnocení firem</h1>

 <?php if($result_hodnoceni->num_rows > 0):?>
   <?php while($row = $result_hodnoceni->fetch_assoc()):?>
    <?php if($row['Anonym'] != 1):?>

   <div class="bigbox-vertical Bmargin-0p25 box-rounded bg-color-gray">
    <h1 class="oswald-Cfont"><?php echo htmlspecialchars($row['Nadpis'])?></h1>
    <img class="img-base box-rounded"src="<?php echo htmlspecialchars($PROFILDATA['Profilovy_Obraz'])?>" alt="PFP" style="width: 35px; height: 35px;">
    <h2 class="oswald-Cfont weight-small"><?php echo htmlspecialchars($PROFILDATA['Jmeno']) . " " . htmlspecialchars($PROFILDATA['Prijmeni'])?></h2>
  <div class="collapsible-container collapsible-button box-vertical border-trans">

    <div class="box-horizontal bg-color-grayer box-rounded Bmargin-0p1">
     <?php if(!empty($row['Hodnoceni'])):?>
      <h3 class="box-horizontal border-trans oswald-Cfont weight-small"><?php echo $row['Hodnoceni']?></h3>  
     <?php endif;?>
    </div>

    <?php if(!empty($row['Obor']) || !empty($row['Druh_Prace']) || !empty($row['TAG_Mesto'])):?>
    <div class="box-horizontal border-trans" style="gap: 5px; padding-left: 0;">

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

    <div class="box-vertical Hpixelbox-10 Collapsedbox-1p5 collapsible-content border-trans">
     <p class="oswald-Cfont weight-small"><?php echo htmlspecialchars($row['Text'])?></p>
    </div>
    

  </div>
   </div>

    <?php endif;?>
   <?php endwhile;?>
  <?php else: ?>
    <h1>NO RESULTS</h1>
  <?php endif;?>

 </div>
<!-----------------------------HODNOCENI END------------------------------------->
</div>      
<!-----------------------------ZAMESTNANEC END------------------------------------->    

<!------------------------------------FIRMA------------------------------------------------>   
        <?php elseif($PROFILDATA['Typ'] == "Firma"):?>
         <div class="bigbox-horizontal border-trans">
          <div class="box-horizontal border-trans">  
          <img class="img-base box-rounded" src="<?php echo $PROFILDATA['Profilovy_Obraz'];?>" alt="Profile Picture here" style="width: 150px; height: 150px;">
          <div class="box-vertical border-trans">
           <h1 class="bg-color-gray Lpadding-0p1 Rpadding-0p1 Bpadding-0p1 Tpadding-0p1 box-rounded stick-to-bottom oswald-Cfont"><?php echo $PROFILDATA['Nazev'];?></h1>
          </div>
          </div>
          <div class="box-vertical border-trans">
           <div class="stick-to-bottom">
           <h3 class="box-horizontal border-trans oswald-Cfont weight-small">Email: <?php echo $PROFILDATA['E-mail'];?></h3>
           <h3 class="box-horizontal border-trans oswald-Cfont weight-small">Datum narození: <?php echo $PROFILDATA['Datum'];?></h3>
           <h3 class="box-horizontal border-trans oswald-Cfont weight-small">Odkaz: <a class="oswald-Cfont weight-small" href="<?php echo "https://www.". $PROFILDATA['Odkaz'];?>" target="_blank" rel="noopener noreferrer"><?php echo $PROFILDATA['Odkaz'];?></a></h3>
           <h3 class="box-horizontal border-trans oswald-Cfont weight-small"><?php echo $PROFILDATA['Mesto'] . ", " . $PROFILDATA['PSC'] . ", " . $PROFILDATA['Ulice'];?></h3>
           </div>
          </div>
          <div class="box-vertical border-trans" style="gap: 5px; justify-content: end;">
          <div>
           <?php if(isset($_SESSION['user_id']) && $_SESSION['usertype'] != $PROFILDATA['Typ']):?>
            <a href="../Direct Message/direct_message.php?message_to_id=<?php echo $PROFILDATA['ID'];?>" class="box-horizontal bg-color-orange text-color-white box-rounded oswald-Cfont text-pageread">Napsat zprávu</a>
           <?php endif;?>
          </div>
          </div>
          
         </div> 
         <div class="box-vertical Hpixelbox-7p5 border-trans">
          <h2 class="horizontal-center oswald-Cfont">Popis</h2>
          <p class="oswald-Cfont weight-small"><?php echo htmlspecialchars($PROFILDATA['Popis'])?></p>
         </div> 

<div class="bigbox-horizontal Tmargin-1 border-trans">
<!-------------------------------------NABIDKY FIRMA---------------------------------->
<div class="box-vertical col-5 border-trans">
<h1 class="horizontal-center Bmargin-0p5 oswald-Cfont">Nabídky práce</h1>
<?php if($result_nabidky->num_rows > 0):?>
   <?php while($row = $result_nabidky->fetch_assoc()):?>

  <div class="bigbox-vertical Bmargin-0p25 box-rounded bg-color-gray">
   <h1 class="oswald-Cfont"><?php echo htmlspecialchars($row['Nadpis'])?></h1>
   <img class="img-base box-rounded" src="<?php echo htmlspecialchars($PROFILDATA['Profilovy_Obraz'])?>" alt="PFP" style="width: 35px; height: 35px;">
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
    <h4 class="box-horizontal bg-color-grayer box-rounded oswald-Cfont weight-small"><?php echo htmlspecialchars($row['TAG_Mesto'])?></h4>
    <?php endif;?>
    <?php if(!empty($row['TAG_Ulice'])):?>
    <h4 class="box-horizontal bg-color-grayer box-rounded oswald-Cfont weight-small"><?php echo htmlspecialchars($row['TAG_Ulice'])?></h4>
    <?php endif;?>
   </div>

   <?php endif;?>


    <h4 class="box-horizontal box-rounded bg-color-grayer oswald-Cfont weight-small"><?php echo htmlspecialchars($row['Vytvoreno'])?></h4>
    <div class="box-vertical Hpixelbox-10 Collapsedbox-1p5 collapsible-content border-trans">
     <p class="oswald-Cfont weight-small"><?php echo htmlspecialchars($row['Text'])?></p>
    </div>

    <?php if(isset($_SESSION['user_id']) && $row['Ucet_ID'] != $_SESSION['user_id'] && $_SESSION['usertype'] == "Zaměstnanec"):?>
    <a href="../Direct Message/direct_message.php?message_to_id=<?php echo $row['Ucet_ID'];?>" class="box-horizontal bg-color-orange text-color-white box-rounded oswald-Cfont text-pageread">Odpovědět</a>
    <?php endif;?>
    
  </div>
   </div>



   <?php endwhile;?>
   <?php else: ?>
    <h1>NO RESULTS</h1>
  <?php endif;?>

</div>
<!-------------------------------------NABIDKY FIRMA END---------------------------------->

<!-------------------------------------HODNOCENI FIRMA---------------------------------->
<div class="box-vertical col-5 border-trans">
<h1 class="horizontal-center Bmargin-0p5 oswald-Cfont">Hodnocení pracovníků</h1>
<?php if($result_hodnoceni->num_rows > 0):?>
   <?php while($row = $result_hodnoceni->fetch_assoc()):?>

   <div class="bigbox-vertical Bmargin-0p25 box-rounded bg-color-gray">
    <h1 class="oswald-Cfont"><?php echo htmlspecialchars($row['Nadpis'])?></h1>
    <img class="img-base box-rounded" src="<?php echo htmlspecialchars($PROFILDATA['Profilovy_Obraz'])?>" alt="PFP" style="width: 35px; height: 35px;">
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
    
    <div class="box-vertical Hpixelbox-10 Collapsedbox-1p5 collapsible-content border-trans">
     <p class="oswald-Cfont weight-small"><?php echo htmlspecialchars($row['Text'])?></p>
    </div>
    
    
  </div> 
   </div>



   <?php endwhile;?>
   <?php else: ?>
    <h1>ERROR, NO DATA</h1>
  <?php endif;?>


</div>
<!-------------------------------------HODNOCENI FIRMA END---------------------------------->

</div>        
          


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