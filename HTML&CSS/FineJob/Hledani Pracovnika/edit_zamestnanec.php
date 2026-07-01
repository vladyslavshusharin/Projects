<?php 
session_start();
require "../db_conn.php";

if(isset($_GET['id']) || isset($_SESSION['editing_nabidka_id'])){
 if(isset($_GET['id'])){$nabidka_id = $_GET['id'];}
 else{$nabidka_id = $_SESSION['editing_nabidka_id'];}
 if(isset($_GET['id'])){$_SESSION['editing_nabidka_id'] = $_GET['id'];}
 $SHOWDATA = "SELECT * FROM nabidky WHERE ID = ?";
 $RESULT = $db->query($SHOWDATA, [$nabidka_id]);
 $NABIDKA_DATA = $RESULT->fetch_assoc();
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
    <title>FineJob - Editovat nabídku (Zaměstnanec)</title>
</head>
<body>

 <div class="site">

  <?php include "../header.php"; ?>

  <main>

  <h1 class="oswald-Cfont">Editovat nabídku práce</h1>

  <form action="edit_zamestnanec_handle.php" class="box-vertical" method="POST">

    
      <input type="text" id="Nadpis" name="Nadpis" class="box-horizontal Hpixelbox-4 text-pagebig
                                                          Bmargin-0p25" placeholder="Nadpis" 
       <?php if(isset($NABIDKA_DATA['Nadpis']) && !empty($NABIDKA_DATA['Nadpis'])):?>
        value="<?php echo $NABIDKA_DATA['Nadpis']?>"
       <?php endif;?>
       >

      <div class="box-horizontal Bmargin-0p25">

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

       <select id="VzdelaniTag" name="VzdelaniTag" class="box-horizontal bg-color-gray">
        <?php if(isset($NABIDKA_DATA['Vzdelani']) && !empty($NABIDKA_DATA['Vzdelani'])):?>
        <option value="<?php echo $NABIDKA_DATA['Vzdelani']?>"><?php echo $NABIDKA_DATA['Vzdelani']?></option>
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

       <select id="ZkusenostTag" name="ZkusenostTag" class="box-horizontal bg-color-gray">
        <?php if(isset($NABIDKA_DATA['Zkusenost']) && !empty($NABIDKA_DATA['Zkusenost'])):?>
        <option value="<?php echo $NABIDKA_DATA['Zkusenost']?>"><?php echo $NABIDKA_DATA['Zkusenost']?></option>
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
      <?php if(isset($_SESSION['error_message'])){
        echo '<p style="color: red;">' . $_SESSION['error_message'] . '</p>';
        unset($_SESSION['error_message']);}
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