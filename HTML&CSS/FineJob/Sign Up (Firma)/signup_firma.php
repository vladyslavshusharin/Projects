<?php 
session_start();
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
    <title>FineJob - Registrace firmy</title>
</head>
<body>
    
<div class="site">

<?php include "../header.php"; ?>   

  <main style="margin-top: auto; margin-bottom: auto;">
  
  <div class="Hpixelbox-4 Vpixelbox-1 bg-color-orange box-rounded stick-to-right Rmargin-0p5 Bmargin-0p5">
   <h1 class="oswald-Cfont full-center text-color-black">Registrace firmy</h1>
  </div>

     <form action="signup_firma_handle.php" method="post" class="box-vertical Hpixelbox-4 bg-color-gray box-rounded Apadding-0p25 stick-to-right Rmargin-0p5">

     <label for="compname" class="oswald-Cfont text-pagebig text-color-black">Název firmy</label><br>
     <input type="text" id="compname" name="compname" class="row-2"><br>

     <label for="mail" class="oswald-Cfont text-pagebig text-color-black">E-mail</label><br>
     <input type="email" id="mail" name="mail" class="row-2"><br>

     <label for="pass" class="oswald-Cfont text-pagebig text-color-black">Heslo</label><br>
     <input type="password" id="pass" name="pass" class="row-2"><br>

     <label for="dateofc" class="oswald-Cfont text-pagebig text-color-black">Datum stvoření</label><br>
     <input type="date" id="dateofc" name="dateofc" class="row-2"><br>

     <label for="city" class="oswald-Cfont text-pagebig text-color-black">Město</label><br>
     <select id="city" name="city" class="row-2">
        <option value="">Vyberte město</option>
        <option value="Praha">Praha</option>
        <option value="Zlín">Zlín</option>
        <option value="Brno">Brno</option>
        <option value="Opava">Opava</option>
        <option value="Karlovy Vary">Karlovy Vary</option>
     </select><br>

     <label for="psc" class="oswald-Cfont text-pagebig text-color-black">PSČ</label><br>
     <input type="text" id="psc" name="psc" class="row-2"><br>

     <label for="strt" class="oswald-Cfont text-pagebig text-color-black">Ulice</label><br>
     <input type="text" id="strt" name="strt" class="row-2"><br>

    <input type="submit" id="sign_firma_submit" value="Registrovat" class="Hpixelbox-2 box-rounded bg-color-orange oswald-Cfont weight-small horizontal-center Tmargin-0p25 text-pageread text-color-black">

    <?php 
    if(isset($_SESSION["firmsignup_error"])){
        echo '<p style="color: red;">'. $_SESSION["firmsignup_error"] . '</p>';
        unset($_SESSION["firmsignup_error"]);
    }
    ?>
    
     </form>




    </main>






<?php include "../footer.php"; ?>  




</div>


</body>
</html>