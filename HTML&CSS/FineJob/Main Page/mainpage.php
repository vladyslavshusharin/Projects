<?php 
session_start(); 
$_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];
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
    <title>FineJob</title>
</head>
<body>
    
</body>


<div class="site">

<?php include "../header.php"; ?>    

      <main>
       
        <div class="bigbox-horizontal border-trans">
        <img class="horizontal-center" src="../WebPics/Logo3.png" style="width: 300px; height: auto;">
        </div>
        <div class="bigbox-horizontal Tmargin-1 Bmargin-0p5 border-trans">
         <div class="box-horizontal col-4 border-trans">
         <div class="full-center">
           <h1 class="oswald-Cfont weight-medium text-color-black">Pro zaměstnance</h1>
           <p class="text-pageread oswald-Cfont weight-medium text-color-black Hpixelbox-4p5">Hledáte práci? Chcete najít nejvhodnější firmu pro vaš směr a dovednosti?
           Zde jsou pro vás nabídky prací od firem, kde můžete hledat podle různých klíčových podmínek.
           Pokud nejste si jisti jestli zaměstnávat se u vybrané firmy stojí za to, tak si můžete zkusit najít
           hodnocení o dané firmě.
           </p>
         </div>
         
         </div>
         <div class="col-6 box-vertical border-trans">
          <a class="horizontal-center text-full-center oswald-Cfont weight-medium text-pagebig Bmargin-0p25 box-rounded bg-color-orange text-color-black Hpixelbox-3 Vpixelbox-1" href="../Hledani Prace/hledat_praci.php">
            Hledat práci</a>
          <a class="horizontal-center text-full-center oswald-Cfont weight-medium text-pagebig Bmargin-0p25 box-rounded bg-color-orange text-color-black Hpixelbox-3 Vpixelbox-1" href="../Hodnoceni Firem/hodnoceni_firem.php">
            Hodnocení firem</a>   
         </div>
         
        </div>
     
        <div class="bigbox-horizontal Bmargin-0p5 border-trans" style="flex-direction: row-reverse;">
         <div class="box-horizontal col-4 border-trans">
          <div class="full-center">
           <h1 class="oswald-Cfont weight-medium text-color-black">Pro firmy</h1>
           <p class="text-pageread oswald-Cfont weight-medium text-color-black Hpixelbox-4p5">Pokud jste firma a hledáte zaměstnance pro danou pozici ve vaší firmě, na této stránce můžete lehce hledat
            zaměstnance, kteří hledají naopak vás! Zde si můžete prohlídnout co nabízí za dovednosti a pokud hledají firmu jako vaší!
            Pokud najdete nějakého vhodného zaměstnance, můžete také si prohlídnout hodnocení napsané o něm a ujistit si, že vaší firmě
            se bude doopravdy hodit!
           </p>
          </div>
         </div>
         <div class="col-6 box-vertical border-trans">
          <a class="horizontal-center text-full-center oswald-Cfont weight-medium text-pagebig Bmargin-0p25 box-rounded bg-color-orange text-color-black Hpixelbox-3 Vpixelbox-1" href="../Hledani Pracovnika/hledat_zamestnance.php">
            Hledat zaměstnance</a>
          <a class="horizontal-center text-full-center oswald-Cfont weight-medium text-pagebig Bmargin-0p25 box-rounded bg-color-orange text-color-black Hpixelbox-3 Vpixelbox-1" href="../Hodnoceni Pracovnika/hodnoceni_zamestnancu.php">
            Hodnocení zaměstnanců</a>
         </div>
        </div>
      
        <div class="bigbox-vertical Bmargin-0p25 border-trans">
         <div class="row-7 full-center">
          <h1 class="full-center text-full-center oswald-Cfont weight-medium text-color-black">Nevíte kde začít?</h1>
          <p class="text-pageread oswald-Cfont weight-medium text-color-black Hpixelbox-4">Pokud nevíte kde začít s vaší budoucností, můžete si prohlídnout statistiky. Zde lze snadno najít trendy v 
          pracovním trhu a uvědomit si, kde máte největší šanci pro úspěch!
          </p>
         </div>
         <div class="row-3">
          <a class="horizontal-center text-full-center oswald-Cfont weight-medium text-pagebig Bmargin-0p25 box-rounded bg-color-orange text-color-black Hpixelbox-3 Vpixelbox-1" href="../Statistiky/statistiky.php">Statistiky</a>
         </div>
       </div>
      
      
      </main>


<?php include "../footer.php"; ?>  

 



</div>


</html>