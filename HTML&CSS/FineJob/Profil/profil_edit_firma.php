<?php 
session_start();
require "../db_conn.php";

if($_SESSION['user_id']){

$userid = $_SESSION['user_id'];
$showdata = "SELECT * FROM ucet WHERE ID = ?";  //Příkaz pro vybírání dat z databáze podle ID uživatele

$result = $db->query($showdata,[$userid]);
$PROFILDATA = $result->fetch_assoc(); //Ukládání dat do proměnné pro zpracování v HTML
}
else{
  header("Location: ../Main Page/mainpage.php"); //Redirect, pokud uživatel nemá učet
  exit();
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
    
      <?php if(isset($_SESSION['user_id'])):?>

      <form action="firma_edit_handle.php" class="box-vertical" method="POST" enctype="multipart/form-data">

      <img src="<?php echo $_SESSION['pfp'];?>" alt="Profile Picture here" style="max-width: 150px; height: auto;">
      <label for="photo_firma">Nová Profilová fotka</label>
      <input class="box-horizontal" type="file" name="photo_firma" id="photo_firma" accept="image/*">

      <label for="compname">Název firmy</label>
      <input class="box-horizontal" type="text" id="compname" name="compname" value="<?php echo $PROFILDATA['Nazev']?>">

      <label for="mail">E-mail</label>
      <input class="box-horizontal" type="email" id="mail" name="mail" value="<?php echo $PROFILDATA['E-mail']?>">

      <label for="dateofc">Datum stvoření</label>
      <input class="box-horizontal" type="date" id="dateofc" name="dateofc" value="<?php echo $PROFILDATA['Datum']?>">

      <label for="odkaz">Odkaz</label>
      <input class="box-horizontal" type="text" id="odkaz" name="odkaz" value="<?php echo $PROFILDATA['Odkaz']?>">

      <label for="city">Město</label>
      <select id="city" name="city">
        <option value="<?php echo $PROFILDATA['Mesto']?>"><?php echo $PROFILDATA['Mesto']?></option>
        <option value="Praha">Praha</option>
        <option value="Zlín">Zlín</option>
        <option value="Brno">Brno</option>
        <option value="Opava">Opava</option>
        <option value="Karlovy Vary">Karlovy Vary</option>
      </select>

     <label for="psc">PSČ</label>
     <input type="text" id="psc" name="psc" value="<?php echo $PROFILDATA['PSC']?>">

     <label for="strt">Ulice</label>
     <input type="text" id="strt" name="strt" value="<?php echo $PROFILDATA['Ulice']?>">
      
      <?php 
        if(isset($_SESSION['error_message'])){
        echo '<p style="color: red;" class="oswald-Cfont" id="error_message">'. $_SESSION["error_message"] . '</p>';
        unset($_SESSION["error_message"]);
        }
        if(isset($_SESSION['image_error'])){
        echo '<p style="color: red;" class="oswald-Cfont" id="error_message">'. $_SESSION["image_error"] . '</p>';
        unset($_SESSION["image_error"]);
        }
      ?>

      <label for="popis">Popis</label>
      <textarea class="box-horizontal Hpixelbox-7 Vpixelbox-5" id="popis" name="popis"><?php echo $PROFILDATA['Popis']?></textarea>

      <button class="box-horizontal Hpixelbox-1p5 bg-color-orange text-color-white text-full-center openpopup" type="button">Uložit</button>

      <div class="popup" id="popup">

       <div class="box-vertical full-center bg-color-gray">

        <label for="pass">Heslo</label>
        <input class="box-horizontal" type="password" id="pass" name="pass">
        <input class="box-horizontal Hpixelbox-1p5 bg-color-orange text-color-white text-full-center" type="submit" value="Uložit">
        <button class="box-horizontal Hpixelbox-1p5 bg-color-orange text-color-white text-full-center closepopup" type="button">Zavřít</button>

       </div>
       
      </div>
      

      </form>  

    
      <?php endif;?>  

      

      </main>


<?php include "../footer.php"; ?>  

 



</div>





</body>
</html>