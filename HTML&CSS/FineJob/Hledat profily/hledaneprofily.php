<?php 
session_start();
$_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];
require "../db_conn.php";

$showdata ="SELECT ID, Typ, Jmeno, Prijmeni, Nazev, Popis, Profilovy_Obraz FROM ucet"; //Základní SQL příkaz

if(isset($_GET['searchtext'])){
  $SEARCHTEXT = $_GET['searchtext']; //Text ze search baru
}
if(isset($_GET['acctype'])){
  $ACCTYPE = $_GET['acctype']; //Výběr typu účtu
}




if(!empty($SEARCHTEXT)){
$search_comp1 = "%" . trim($SEARCHTEXT) . "%"; //Celý text
$search_comp2 = "%" . str_replace(" ", "", $SEARCHTEXT) . "%"; //Text bez vnitřních mezer

$search_exp = explode(" ",$SEARCHTEXT); //Rozdělený text podle mezer (array)
 if(count($search_exp) > 1){ //Pokud je více než jeden kus textů
 $search1 = "%" . trim($search_exp[0]) . "%"; //text 1
 $search2 = "%" . trim($search_exp[1]) . "%"; //text 2
 }else{
  $search1 = "%" . trim($SEARCHTEXT) . "%"; //Stejný text
  $search2 = "%" . trim($SEARCHTEXT) . "%"; //Stejný text
 }

 $showdata = "SELECT ID, Typ, Jmeno, Prijmeni, Nazev, Popis, Profilovy_Obraz FROM ucet WHERE ((Jmeno LIKE ? OR Prijmeni LIKE ?) OR (Nazev LIKE ? OR Nazev LIKE ?))"; //Nový příkaz podle textů
 
 if(!empty($ACCTYPE) && $ACCTYPE == "Zaměstnanec"){ //Přidávání podmínky typu účtu do příkazu
  $showdata = $showdata . " AND Typ = 'Zaměstnanec'";
 }
 if(!empty($ACCTYPE) && $ACCTYPE == "Firma"){
  $showdata = $showdata . " AND Typ = 'Firma'";
 }

 $result = $db->query($showdata, [$search1, $search2, $search_comp1, $search_comp2]); //Výsledná data podle hledaného textu
 

}
else if(!empty($ACCTYPE) && $ACCTYPE == "Zaměstnanec"){ //Pokud není text v search baru
  $showdata = "SELECT ID, Typ, Jmeno, Prijmeni, Nazev, Popis, Profilovy_Obraz FROM ucet WHERE Typ ='Zaměstnanec'";
  $result = $db->query($showdata); //Výsledná data bez textu
}
else if(!empty($ACCTYPE) && $ACCTYPE == "Firma"){
  $showdata = "SELECT ID, Typ, Jmeno, Prijmeni, Nazev, Popis, Profilovy_Obraz FROM ucet WHERE Typ ='Firma'";
  $result = $db->query($showdata);
}
else{

$showdata = "SELECT ID, Typ, Jmeno, Prijmeni, Nazev, Popis, Profilovy_Obraz FROM ucet ORDER BY Datum ASC";
$result = $db->query($showdata); //Data bez specifikovaného typu účtu a textu

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
    <title>FineJob - Hledat Profily</title>
</head>
<body>

 <div class="site">

  <?php include "../header.php"; ?>    

  <main>
  <div class="box-horizontal Hpixelbox-5 Vpixelbox-1 bg-color-orange box-rounded horizontal-center">
    <h1 class="oswald-Cfont text-color-black full-center">Hledat profily</h1>
  </div>
<!-------------------------------------SEARCH FORM--------------------------------------->
  <form class="bigbox-vertical Vpixelbox-2 border-trans" method="GET">
    <div class="box-vertical Hpixelbox-7 horizontal-center Tpadding-0p1 Bpadding-0p1 box-rounded bg-color-orange">
     <div class="box-horizontal Hpixelbox-6p5 horizontal-center Bmargin-0p25 border-trans">
      <input type="text" id="searchtext" name="searchtext" class="box-horizontal col-8 bg-color-gray box-rounded-left border-grayer" placeholder="Hledat...">
      <input class="box-horizontal bg-color-gray col-2 box-rounded-right border-grayer" type="submit" value="Hledat">
     </div>
     <select id="acctype" name="acctype" class="box-horizontal bg-color-gray horizontal-center box-rounded border-grayer">
      <?php if($_GET['acctype'] != ""):?>
        <option value="<?php echo $_GET['acctype']?>"><?php echo $_GET['acctype']?></option>
        <option value="">Typ účtu</option>
       <?php else:?>
        <option value="">Typ účtu</option>
       <?php endif;?>
        <option value="Zaměstnanec">Zaměstnanec</option>
        <option value="Firma">Firma</option>
     </select>
    </div>
     
     
  </form>

<!-------------------------------------SEARCH FORM END--------------------------------------->

<!-------------------------------------VYPISOVANI PROFILU--------------------------------------->

<div class="bigbox-vertical Rpadding-0p1 Lpadding-0p1 border-trans" style="gap: 25px;">

  <?php if($result->num_rows > 0):?>
    <?php while($row = $result->fetch_assoc()):?>
      <?php if($row['Typ'] == "Zaměstnanec"):?>  

      <a href="../Profil/profil_selected.php?id=<?php echo $row['ID'];?>" class="bigbox-horizontal Vpixelbox-1 text-color-black box-rounded bg-color-orange">
         <div class="Hpixelbox-1">
            <img class="img-base box-rounded"src="<?php echo htmlspecialchars($row['Profilovy_Obraz'])?>" alt="PFP" style="width: 100px; height: 100px;">
         </div>
         <div class="bigbox-vertical col-8 border-trans" style="gap: 10px">
          <div class="box-horizontal null-padding border-trans">
            <h3 class="oswald-Cfont bg-color-gray box-rounded border-grayer Apadding-0p1" ><?php echo htmlspecialchars($row['Jmeno']) . " " . htmlspecialchars($row['Prijmeni'])?></h3>
          </div>
          <div class="bigbox-horizontal bg-color-gray box-rounded border-grayer Apadding-0p1"> 
            <p class="oswald-Cfont weight-small Collapsedbox-1 text-break"><?php echo nl2br(htmlspecialchars($row['Popis']))?></p>
          </div>
         </div>
      </a>

      <?php endif;?>

      <?php if($row['Typ'] == "Firma"):?>  
        <a href="../Profil/profil_selected.php?id=<?php echo $row['ID'];?>" class="bigbox-horizontal Vpixelbox-1 text-color-black box-rounded bg-color-orange">
         <div class="Hpixelbox-1">
            <img class="img-base box-rounded"src="<?php echo htmlspecialchars($row['Profilovy_Obraz'])?>" alt="PFP" style="width: 100px; height: 100px;">
         </div>
         <div class="box-vertical col-8 border-trans" style="gap: 10px">
          <div class="box-horizontal null-padding border-trans">
            <h3 class="oswald-Cfont bg-color-gray box-rounded border-grayer Apadding-0p1"><?php echo htmlspecialchars($row['Nazev']) ?></h3>
          </div>
          <div class="bigbox-horizontal bg-color-gray box-rounded border-grayer Apadding-0p1">
            <p class="oswald-Cfont weight-small Collapsedbox-1 text-break "><?php echo nl2br(htmlspecialchars($row['Popis']))?></p>
          </div>
         </div>
        </a>

      <?php endif;?>
    <?php endwhile;?>
  <?php endif;?>

</div>
<!-------------------------------------VYPISOVANI PROFILU END--------------------------------------->  

  </main>




  <?php include "../footer.php"; ?>  

 </div>


    
</body>
</html>