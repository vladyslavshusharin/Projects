<?php 
session_start();
if(isset($_SESSION['user_id'])){
    header("Location: ../Main Page/mainpage.php");
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
    <title>FineJob - Registrace zaměstnance</title>
</head>
<body>
    
<div class="site">

<?php include "../header.php"; ?>   

 <main>

   <div class="Hpixelbox-4 Vpixelbox-1 bg-color-orange box-rounded Lmargin-0p5 Bmargin-0p5">
    <h1 class="oswald-Cfont full-center text-color-black">Registrace zaměstnance</h1>
   </div>

     <form action="signup_user_handle.php" method="post" class="box-vertical Hpixelbox-4 bg-color-gray box-rounded Apadding-0p25 Lmargin-0p5">

     <label for="fname" class="oswald-Cfont text-pagebig text-color-black">Jméno</label><br>
     <input type="text" id="fname" name="fname" class="row-2"><br>

     <label for="lname" class="oswald-Cfont text-pagebig text-color-black">Příjmení</label><br>
     <input type="text" id="lname" name="lname" class="row-2"><br>

     <label for="mail" class="oswald-Cfont text-pagebig text-color-black">E-mail</label><br>
     <input type="email" id="mail" name="mail" class="row-2"><br>

     <label for="pass" class="oswald-Cfont text-pagebig text-color-black">Heslo</label><br>
     <input type="password" id="pass" name="pass" class="row-2"><br>

     <label for="dateofb" class="oswald-Cfont text-pagebig text-color-black">Datum narození</label><br>
     <input type="date" id="dateofb" name="dateofb" class="row-2"><br>

    <input type="submit" id="sign_user_submit" value="Registrovat" class="Hpixelbox-2 box-rounded bg-color-orange oswald-Cfont weight-small horizontal-center Tmargin-0p25 text-pageread text-color-black">

    <?php 

    if(isset($_SESSION["usersignup_error"])){
        echo '<p style="color: red;">'. $_SESSION["usersignup_error"] . '</p>';
        unset($_SESSION["usersignup_error"]);
    }
    ?>

     </form>




 </main>






<?php include "../footer.php"; ?>  




</div>


</body>
</html>