<?php 
session_start();
require "../db_conn.php";

if($_SESSION['user_id']){

$userid = $_SESSION['user_id'];
$showdata = "SELECT * FROM ucet WHERE ID = ?"; //Příkaz pro vybírání dat z databáze podle ID uživatele

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

      <form action="user_edit_handle.php" class="box-vertical" method="POST" enctype="multipart/form-data">
      
      <img src="<?php echo $_SESSION['pfp'];?>" alt="Profile Picture here" style="max-width: 150px; height: auto;">
      <label for="photo">Nová Profilová fotka</label>
      <input class="box-horizontal" type="file" name="photo" id="photo" accept="image/*">

      <label for="dokument">Uploadnout PDF dokument</label>
      <input class="box-horizontal" type="file" name="dokument" accept="application/pdf">

      <label for="fname">Jméno</label>
      <input class="box-horizontal" type="text" id="fname" name="fname" value="<?php echo $PROFILDATA['Jmeno']?>">

      <label for="lname">Příjmení</label>
      <input class="box-horizontal" type="text" id="lname" name="lname" value="<?php echo $PROFILDATA['Prijmeni']?>">

      <label for="mail">E-mail</label>
      <input class="box-horizontal" type="email" id="mail" name="mail" value="<?php echo $PROFILDATA['E-mail']?>">

      <label for="dateofb">Datum narození</label>
      <input class="box-horizontal" type="date" id="dateofb" name="dateofb" value="<?php echo $PROFILDATA['Datum']?>">
      
      <?php 
        if(isset($_SESSION['error_message'])){
         echo '<p style="color: red;" class="oswald-Cfont" id="error_message">'. $_SESSION["error_message"] . '</p>';
         unset($_SESSION["error_message"]);
        }
        if(isset( $_SESSION['image_error'])){
         echo '<p style="color: red;" class="oswald-Cfont" id="error_message">'. $_SESSION["image_error"] . '</p>';
         unset($_SESSION["image_error"]);
        }
        if(isset( $_SESSION['doc_error'])){
         echo '<p style="color: red;" class="oswald-Cfont" id="error_message">'. $_SESSION["doc_error"] . '</p>';
         unset($_SESSION["doc_error"]);
        }
        ?>

      <label for="popis">Popis</label>
      <textarea class="box-horizontal Hpixelbox-7 Vpixelbox-5" id="popis" name="popis"><?php echo $PROFILDATA['Popis']?></textarea>


      <button class="box-horizontal Hpixelbox-1p5 bg-color-orange text-color-white text-full-center openpopup"  type="button">Uložit</button>
      <div class="popup" id="popup">

       <div class="box-vertical full-center bg-color-gray">

        <label for="pass">Heslo</label>
        <input class="box-horizontal" type="password" id="pass" name="pass">
        <input class="box-horizontal Hpixelbox-1p5 bg-color-orange text-color-white text-full-center" type="submit" value="Uložit">
        <button class="box-horizontal Hpixelbox-1p5 bg-color-orange text-color-white text-full-center closepopup"  type="button">Zavřít</button>

       </div>
       
      </div>
      

      </form>  

    
      <?php endif;?>  

      

      </main>


<?php include "../footer.php"; ?>  

 



</div>





</body>
</html>