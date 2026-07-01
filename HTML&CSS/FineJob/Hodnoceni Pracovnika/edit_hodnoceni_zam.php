<?php 
session_start();
require "../db_conn.php";

if(isset($_GET['id']) || isset($_SESSION['editing_hodnoceni_id'])){
 if(isset($_GET['id'])){$hodnoceni_id = $_GET['id'];}
 else{$hodnoceni_id = $_SESSION['editing_hodnoceni_id'];}
 if(isset($_GET['id'])){$_SESSION['editing_hodnoceni_id'] = $_GET['id'];}
 $SHOWDATA = "SELECT * FROM hodnoceni WHERE ID = ?";
 $RESULT = $db->query($SHOWDATA, [$hodnoceni_id]);
 $HODNOCENI_DATA = $RESULT->fetch_assoc();
  if($HODNOCENI_DATA['Ucet_ID'] != $_SESSION['user_id']){
  header("Location: ../Main Page/mainpage.php"); //Redirect pro zabezpečení
  }
}
else{header("Location: ../Main Page/mainpage.php");
    exit();}


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
    <title>FineJob - Editovat hodnocení zaměstnance</title>
</head>
<body>

 <div class="site">

  <?php include "../header.php"; ?>

  <main>

  <h1 class="oswald-Cfont">Editovat hodnoceni</h1>

  <form action="edit_hodnoceni_zam_handle.php" class="box-vertical" method="POST">

    
      <input type="text" id="Nadpis" name="Nadpis" class="box-horizontal Hpixelbox-4 text-pagebig
                                                          Bmargin-0p25" placeholder="Nadpis" 
       <?php if(isset($HODNOCENI_DATA['Nadpis']) && !empty($HODNOCENI_DATA['Nadpis'])):?>
        value="<?php echo $HODNOCENI_DATA['Nadpis']?>"
       <?php endif;?>
       >

      <div class="box-horizontal Bmargin-0p25">

       <select id="OborTag" name="OborTag" class="box-horizontal bg-color-gray">
        <?php if(isset($HODNOCENI_DATA['Obor']) && !empty($HODNOCENI_DATA['Obor'])):?>
        <option value="<?php echo $HODNOCENI_DATA['Obor']?>"><?php echo $HODNOCENI_DATA['Obor']?></option>
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

       <select id="DruhTag" name="DruhTag" class="box-horizontal bg-color-gray">
        <?php if(isset($HODNOCENI_DATA['Druh_Prace']) && !empty($HODNOCENI_DATA['Druh_Prace'])):?>
        <option value="<?php echo $HODNOCENI_DATA['Druh_Prace']?>"><?php echo $HODNOCENI_DATA['Druh_Prace']?></option>
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

       <select id="MestoTag" name="MestoTag" class="box-horizontal bg-color-gray">
        <?php if(isset($HODNOCENI_DATA['TAG_Mesto']) && !empty($HODNOCENI_DATA['TAG_Mesto'])):?>
        <option value="<?php echo $HODNOCENI_DATA['TAG_Mesto']?>"><?php echo $HODNOCENI_DATA['TAG_Mesto']?></option>
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

       <input type="text" id="PSCTag" name="PSCTag" class="box-horizontal bg-color-gray" placeholder="PSČ"
       <?php if(isset($HODNOCENI_DATA['TAG_PSC']) && !empty($HODNOCENI_DATA['TAG_PSC'])):?>
       value="<?php echo $HODNOCENI_DATA['TAG_PSC']?>"
       <?php endif;?>
       >
       <input type="text" id="UliceTag" name="UliceTag" class="box-horizontal bg-color-gray" placeholder="Ulice"
       <?php if(isset($HODNOCENI_DATA['TAG_Ulice']) && !empty($HODNOCENI_DATA['TAG_Ulice'])):?>
       value="<?php echo $HODNOCENI_DATA['TAG_Ulice']?>"
       <?php endif;?>
       >

       <select id="HodnoceniTag" name="HodnoceniTag" class="box-horizontal bg-color-gray">
        <?php if(isset($HODNOCENI_DATA['Hodnoceni']) && !empty($HODNOCENI_DATA['Hodnoceni'])):?>
        <option value="<?php echo $HODNOCENI_DATA['Hodnoceni']?>"><?php echo $HODNOCENI_DATA['Hodnoceni']?></option>
        <option value="">Hodnocení</option>
        <?php else:?>
        <option value="">Hodnocení</option>
        <?php endif;?>
        <option value="Špatné">Špatné</option>
        <option value="Průměrné">Průměrné</option>
        <option value="Výborné">Výborné</option>
       </select>

      </div>
      <?php if(isset($_SESSION['error_message'])){
        echo '<p style="color: red;">' . $_SESSION['error_message'] . '</p>';
        unset($_SESSION['error_message']);}
        ?>
      <?php if(isset($_SESSION['error_lokalita'])){
        echo '<p style="color: red;">' . $_SESSION['error_lokalita'] . '</p>';
        unset($_SESSION['error_lokalita']);}
        ?>
      <textarea class="box-horizontal Hpixelbox-8 Vpixelbox-5" id="hodnoceni_text" name="hodnoceni_text"><?php if(isset($HODNOCENI_DATA['Text']) && !empty($HODNOCENI_DATA['Text'])){echo $HODNOCENI_DATA['Text'];}?></textarea>
      
      <div class="box-horizontal Hpixelbox-3p5">
        <input class="box-horizontal Hpixelbox-1p5 bg-color-orange text-color-white text-pageread" type="submit" value="Editovat">
        <a href="<?php echo $_SESSION['previous_page'] ?>" class="box-horizontal Hpixelbox-1p5 bg-color-orange 
                                                                  text-color-white text-pageread text-full-center">Zrušit</a>
      </div>
      
    </form>




  </main>

  <?php include "../footer.php"; ?> 



 </div>
    
</body>
</html>