<?php 
session_start();
require "../db_conn.php";

if(isset($_GET['id']) || isset($_SESSION['editing_nabidka_id'])){ //Vybírání nabídky, podle vybrané nabídky/momentálně editované nabídky
 if(isset($_GET['id'])){$nabidka_id = $_GET['id'];} //ID pro zjištění nabídky
 else{$nabidka_id = $_SESSION['editing_nabidka_id'];}
 if(isset($_GET['id'])){$_SESSION['editing_nabidka_id'] = $_GET['id'];}
 $SHOWDATA = "SELECT * FROM nabidky WHERE ID = ?"; //SQL Příkaz pro vybraní nabídky
 $RESULT = $db->query($SHOWDATA, [$nabidka_id]);
 $NABIDKA_DATA = $RESULT->fetch_assoc(); //Formátování dat pro PHP
 if($NABIDKA_DATA['Ucet_ID'] !== $_SESSION['user_id']){
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
    <title>FineJob - Editovat nabídku (Firma)</title>
</head>
<body>

 <div class="site">

  <?php include "../header.php"; ?>

  <main>

  <h1 class="oswald-Cfont">Editovat nabídku práce</h1>

  <form action="edit_nabidka_prace_handle.php" class="box-vertical" method="POST">

    
      <input type="text" id="Nadpis" name="Nadpis" class="box-horizontal Hpixelbox-4 text-pagebig
                                                          Bmargin-0p25" placeholder="Nadpis" 
       <?php if(isset($NABIDKA_DATA['Nadpis']) && !empty($NABIDKA_DATA['Nadpis'])):?>
        value="<?php echo $NABIDKA_DATA['Nadpis']?>"
       <?php endif;?>
       >

      <div class="box-horizontal Bmargin-0p25">

       <input type="number" min="0" id="PlatTag" name="PlatTag" class="box-horizontal bg-color-gray" placeholder="Plat"
       <?php if(isset($NABIDKA_DATA['Plat']) && !empty($NABIDKA_DATA['Plat'])):?>
        value="<?php echo $NABIDKA_DATA['Plat']?>"
       <?php endif;?>
       >

       <select id="OborTag" name="OborTag" class="box-horizontal bg-color-gray">
        <?php if(isset($NABIDKA_DATA['Obor']) && !empty($NABIDKA_DATA['Obor'])):?>
        <option value="<?php echo $NABIDKA_DATA['Obor']?>"><?php echo $NABIDKA_DATA['Obor']?></option>
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
        <?php if(isset($NABIDKA_DATA['Druh_Prace']) && !empty($NABIDKA_DATA['Druh_Prace'])):?>
        <option value="<?php echo $NABIDKA_DATA['Druh_Prace']?>"><?php echo $NABIDKA_DATA['Druh_Prace']?></option>
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
        <?php if(isset($NABIDKA_DATA['TAG_Mesto']) && !empty($NABIDKA_DATA['TAG_Mesto'])):?>
        <option value="<?php echo $NABIDKA_DATA['TAG_Mesto']?>"><?php echo $NABIDKA_DATA['TAG_Mesto']?></option>
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
       <?php if(isset($NABIDKA_DATA['TAG_PSC']) && !empty($NABIDKA_DATA['TAG_PSC'])):?>
       value="<?php echo $NABIDKA_DATA['TAG_PSC']?>"
       <?php endif;?>
       >
       <input type="text" id="UliceTag" name="UliceTag" class="box-horizontal bg-color-gray" placeholder="Ulice"
       <?php if(isset($NABIDKA_DATA['TAG_Ulice']) && !empty($NABIDKA_DATA['TAG_Ulice'])):?>
       value="<?php echo $NABIDKA_DATA['TAG_Ulice']?>"
       <?php endif;?>
       >

      </div>
      <?php if(isset($_SESSION['error_message'])){
        echo '<p style="color: red;">' . $_SESSION['error_message'] . '</p>';
        unset($_SESSION['error_message']);}
        ?>
      <?php if(isset($_SESSION['error_lokalita'])){
        echo '<p style="color: red;">' . $_SESSION['error_lokalita'] . '</p>';
        unset($_SESSION['error_lokalita']);}
        ?>
      <textarea class="box-horizontal Hpixelbox-8 Vpixelbox-5" id="nabidka_text" name="nabidka_text"><?php if(isset($NABIDKA_DATA['Text']) && !empty($NABIDKA_DATA['Text'])){echo $NABIDKA_DATA['Text'];}?></textarea>
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