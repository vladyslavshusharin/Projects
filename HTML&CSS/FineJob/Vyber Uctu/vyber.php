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
    <title>FineJob - Výběr</title>
</head>
<body>
    
</body>


<div class="site">

<?php include "../header.php"; ?>    

      <main>
       
      <div class="box-horizontal Hpixelbox-6 Tmargin-1p5 Bmargin-1 border-trans horizontal-center">
       <div class="bigbox-vertical col-5 border-trans">
       <a href="../Sign Up (Uzivatel)/signup_user.php" class="box-horizontal bg-color-orange text-color-black box-rounded Hpixelbox-3 Vpixelbox-1"><h1 class="full-center oswald-Cfont weight-medium">Jsem Zaměstnanec</h1></a>
       <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, et.</p>
       </div>
       <div class="bigbox-vertical col-5 border-trans">
       <a href="../Sign Up (Firma)/signup_firma.php" class="box-horizontal bg-color-orange text-color-black box-rounded Hpixelbox-3 Vpixelbox-1"><h1 class="full-center oswald-Cfont weight-medium">Jsem Firma</h1></a>
       <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni, sit.</p>
       </div>
      

      </div>




      </main>


<?php include "../footer.php"; ?>  

 



</div>


</html>