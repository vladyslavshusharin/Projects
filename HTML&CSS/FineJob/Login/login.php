<?php session_start(); ?>

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
    <title>FineJob - Přihlásit</title>
</head>
<body>
    

<div class="site">

<?php include "../header.php"; ?>    

      <main>
         <form class="box-vertical Hpixelbox-4p5 Tmargin-1p5 Bmargin-1p5 horizontal-center box-rounded bg-color-gray" action="login_handle.php" method="post">
            <div class="row-2">
                <h1 class="oswald-Cfont">Přihlásit</h2>
            </div>
            <div class="bigbox-vertical row-6 border-trans">
                <label for="usermail" id="usermailtext" class="oswald-Cfont text-pagebig">E-mail:</label>
                <input type="email" id="usermail" name="usermail" class="row-2">
                <label for="pass" id="passtext" class="oswald-Cfont text-pagebig Tmargin-0p25">Password:</label>
                <input type="password" id="pass" name="pass" class="row-2">
            </div>    
            <div class="bigbox-vertical row-2 border-trans">
                <?php
                if(isset($_SESSION["login_error"])){
                    echo '<p style="color: red;" class="oswald-Cfont" id="error-login">'. $_SESSION["login_error"] . '</p><br>';
                    unset($_SESSION["login_error"]);
                }
                ?>
                <a href="_blank" id="address-login"><p class="oswald-Cfont">Forgot password?</p></a>
                <input type="submit" id="button-login" style="cursor: pointer"class="oswald-Cfont bigbox-horizontal box-rounded bg-color-orange text-color-white text-pageread" value="Přihlásit">
            </div>
        
         </form>
         
      </main>
    
<?php include "../footer.php"; ?>  

</div>

 

   






    
</body>
</html>