<?php 
session_start();
$_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];
require "../db_conn.php";

if($_SESSION['user_id']){

$userid = $_SESSION['user_id']; 
$SQL = "SELECT
         CASE
         WHEN zpravy.Posilac_ID = ?  
         THEN zpravy.Prijimac_ID
         ELSE zpravy.Posilac_ID
         END AS Druha_Osoba_ID,
         ucet.*
        FROM zpravy 
        JOIN ucet on ucet.ID = (
         CASE
         WHEN zpravy.Posilac_ID = ?
         THEN zpravy.Prijimac_ID
         ELSE zpravy.Posilac_ID
         END
        )
        WHERE zpravy.Posilac_ID = ? OR zpravy.Prijimac_ID = ?
        GROUP BY Druha_Osoba_ID"; 

//SQL příkaz pro identifikaci každe jiné osoby ze zpráv mezi jinou osobou a uživatelem (navíc identifikace jiné osoby v ucet) a vypisování všech daných osob
//Daný příkaz využívá CASE, kde selectuje osobu, která není daný uživatel

$other_users = $db->query($SQL, [$userid, $userid, $userid, $userid]); //uložení jiných osob do proměnné



if($_SERVER['REQUEST_METHOD'] == "GET" || isset($_SESSION['current_recipient'])){

if(isset($_GET['message_to_id']) || isset($_SESSION['new_recipient'])){ //Vytvoření nového chatu s novým userem, mezi kterým ještě nejsou zprávy
  if(isset($_GET['message_to_id'])){$NEW_ID = $_GET['message_to_id'];} 
  else{$NEW_ID = $_SESSION['new_recipient'];}
  $CHECK_NEW = "SELECT * FROM zpravy WHERE (Prijimac_ID = ? OR Posilac_ID = ?) AND (Prijimac_ID = ? OR Posilac_ID = ?)"; //Ověření jestli nejsou zprávy mezi danou osobou
  $CHECK_RESULT = $db->query($CHECK_NEW, [$NEW_ID, $NEW_ID, $userid, $userid]); 
  if($CHECK_RESULT->num_rows == 0){ //Pokud ne, vemou se data nové osoby pro odesílání zprávy nový osobě
    $GET_NEW_RECIPIENT = "SELECT * FROM ucet WHERE ID = ? AND Typ != ?";
    try {
      $NEW_RECIPIENT_RESULT = $db->query($GET_NEW_RECIPIENT, [$NEW_ID, $_SESSION['usertype']]); //Neformátovaný data pro formulář formuláře potom v HTML
      $NEW_RECIPIENT_DATA = $db->query($GET_NEW_RECIPIENT, [$NEW_ID, $_SESSION['usertype']]); 
      $NEW_DATA_RESULT = $NEW_RECIPIENT_DATA->fetch_assoc(); //Data pro zachycení jména atd. nové osoby
      if(!$NEW_RECIPIENT_RESULT){
        throw new Exception("Nepodařilo se navázat kontakt");
      }else{
        if(isset($_GET['message_to_id'])){$_SESSION['new_recipient'] = $_GET['message_to_id'];
                                          $_SESSION['current_recipient'] = $_SESSION['new_recipient'];
                                          if($NEW_DATA_RESULT['Typ'] == "Zaměstnanec"){
                                            $_SESSION['recipient_name'] = $NEW_DATA_RESULT['Jmeno'] . " " . $NEW_DATA_RESULT['Prijmeni'];
                                          }
                                          if($NEW_DATA_RESULT['Typ'] == "Firma"){
                                            $_SESSION['recipient_name'] = $NEW_DATA_RESULT['Nazev'];
                                          }
                                          
                                          }
        if(isset($_GET['message_to_id'])){unset($_GET['message_to_id']);} //unset message_to_id pro zprávu nové osobě, aby se tato podmínka neopakovala, když už to není nová osoba
        
      }
    }
    catch(Exception $e){$_SESSION['error_kontakt'] = $e->getMessage();}
  }else{
    $_SESSION['current_recipient'] = $NEW_ID; //Pokud už existuje kontant s touto osobou tak je current recipient
    unset($_GET['message_to_id']);
    if(isset($_SESSION['new_recipient'])){
      unset($_SESSION['new_recipient']); //Už není potřeba new_recipient, jelikož osoba není nová
    }
  }
  
}

if(isset($_GET['other_user_id']) || isset($_SESSION['current_recipient'])){ //Vypisování zpráv mezi druhou osobou a uživatelem
  if(isset($_GET['other_user_id']) && is_numeric($_GET['other_user_id'])){ //Pokud jsme vybrali osobu z listu kontaktů
    if(isset($_GET['other_user_id'])){
    $_SESSION['current_recipient'] = $_GET['other_user_id'];
    }
    $OTHER_USER_ID = $_GET['other_user_id'];
    $SHOWMESSAGES = "SELECT zpravy.*, ucet.Typ, ucet.Jmeno, ucet.Prijmeni, ucet.Nazev FROM zpravy
                     JOIN ucet ON zpravy.Posilac_ID = ucet.ID 
                     WHERE (zpravy.Posilac_ID = ? OR zpravy.Prijimac_ID = ?) AND (zpravy.Posilac_ID = ? OR zpravy.Prijimac_ID = ?)";
    $result_messages = $db->query($SHOWMESSAGES, [$userid, $userid, $OTHER_USER_ID, $OTHER_USER_ID]);
    $SHOWDATA = "SELECT * FROM ucet WHERE ID = ?";
    $RECIPIENT_RESULT = $db->query($SHOWDATA, [$OTHER_USER_ID]);
    $RECIPIENT_DATA = $RECIPIENT_RESULT->fetch_assoc(); //Data pro zachycení jména osoby, s kterou teď mluvíme
    if($RECIPIENT_DATA['Typ'] == "Zaměstnanec"){
     $_SESSION['recipient_name'] = $RECIPIENT_DATA['Jmeno'] . " " . $RECIPIENT_DATA['Prijmeni'];
    }
    if($RECIPIENT_DATA['Typ'] == "Firma"){
     $_SESSION['recipient_name'] = $RECIPIENT_DATA['Nazev'];
    }
  }
  else if(isset($_SESSION['current_recipient']) && is_numeric($_SESSION['current_recipient'])){ //Pokud s danou osobou teď mluvíme
    $OTHER_USER_ID = $_SESSION['current_recipient'];
    $SHOWMESSAGES = "SELECT zpravy.*, ucet.Typ, ucet.Jmeno, ucet.Prijmeni, ucet.Nazev FROM zpravy
                     JOIN ucet ON zpravy.Posilac_ID = ucet.ID 
                     WHERE (zpravy.Posilac_ID = ? OR zpravy.Prijimac_ID = ?) AND (zpravy.Posilac_ID = ? OR zpravy.Prijimac_ID = ?)";
    $result_messages = $db->query($SHOWMESSAGES, [$userid, $userid, $OTHER_USER_ID, $OTHER_USER_ID]);
    $SHOWDATA = "SELECT * FROM ucet WHERE ID = ?";
    $RECIPIENT_RESULT = $db->query($SHOWDATA, [$OTHER_USER_ID]);
    $RECIPIENT_DATA = $RECIPIENT_RESULT->fetch_assoc(); //Data nevyužita
    if($RECIPIENT_DATA['Typ'] == "Zaměstnanec"){
     $_SESSION['recipient_name'] = $RECIPIENT_DATA['Jmeno'] . " " . $RECIPIENT_DATA['Prijmeni'];
    }
    if($RECIPIENT_DATA['Typ'] == "Firma"){
     $_SESSION['recipient_name'] = $RECIPIENT_DATA['Nazev'];
    }
  }
}

}

if($_SERVER['REQUEST_METHOD'] == "POST"){ //Posílání zprávy

$MESSAGE = trim($_POST['zprava_text']);

if(!empty($MESSAGE)){
  $SEND_MESSAGE = "INSERT INTO zpravy (Zprava, Cas, Prijimac_ID, Posilac_ID) VALUES (?, CURRENT_TIMESTAMP, ?, ?)";
  try{
  $MESSAGE_SENT = $db->query($SEND_MESSAGE, [$MESSAGE, $_SESSION['current_recipient'], $userid]);
  if(!$MESSAGE_SENT){
    throw new Exception("Nepodařilo se odeslat zprávu");
  }
  else{
    if(isset($_SESSION['new_recipient'])){
      unset($_SESSION['new_recipient']);
        }
      }

  }catch(Exception $e){$_SESSION['error_message_send'] = $e->getMessage();}
}

header("Location: " . $_SERVER['PHP_SELF']); //Refresh page pro zobrazení poslané zprávy
exit();

}

}
else{
    header("Location: ../Main Page/mainpage.php"); //Pokud nejsme přihlášeni, vypadnout
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
    <title>FineJob - Direct Message</title>
</head>
<body>
    
<div class="site">

<?php include "../header.php"; ?>   

 <main>

  <div class="bigbox-horizontal Rpadding-0p25 Lpadding-0p25 border-trans">

    <div class="Scroll-box-6 col-3" style="flex-direction: column; justify-content: flex-start">
        
     <?php if($other_users->num_rows > 0):?>
      <?php while($row = $other_users->fetch_assoc()):?>
        
       <form method="GET">

         <input type="hidden" id="other_user_id" name="other_user_id" value="<?php echo $row['Druha_Osoba_ID']?>">

         <button type="submit" class="bigbox-horizontal bg-color-orange box-rounded <?php if($_SESSION['current_recipient'] == $row['Druha_Osoba_ID']){echo "text-color-white";}else{echo "text-color-black";}?> text-full-center Bmargin-0p1">

           <?php if($row['Typ'] == "Zaměstnanec"):?>
             <h3><?php echo htmlspecialchars($row['Jmeno']) . " " . htmlspecialchars($row['Prijmeni'])?></h3>
           <?php elseif($row['Typ'] == "Firma"):?>
             <h3><?php echo htmlspecialchars($row['Nazev'])?></h3>
           <?php endif;?>
         </button>

       </form>
     

      <?php endwhile;?>
     <?php endif;?>

     <?php if(isset($NEW_RECIPIENT_RESULT) && $NEW_RECIPIENT_RESULT->num_rows === 1):?>
      <?php while($row = $NEW_RECIPIENT_RESULT->fetch_assoc()):?>

       <form method="GET">

         <input type="hidden" id="other_user_id" name="other_user_id" value="<?php echo $row['ID']?>">

         <button type="submit" class="bigbox-horizontal bg-color-orange box-rounded <?php if($_SESSION['current_recipient'] == $row['ID']){echo "text-color-white";}else{echo "text-color-black";}?> text-full-center Bmargin-0p1">
           <?php if($row['Typ'] == "Zaměstnanec"):?>
             <h3><?php echo htmlspecialchars($row['Jmeno']) . " " . htmlspecialchars($row['Prijmeni'])?></h3>
           <?php elseif($row['Typ'] == "Firma"):?>
             <h3><?php echo htmlspecialchars($row['Nazev'])?></h3>
           <?php endif;?>
         </button>

       </form>
     

      <?php endwhile;?>
     <?php endif;?>

    
     
    </div>

    <div class="box-vertical col-7 box-rounded border-gray">
    
    <div class="bigbox-horizontal border-trans">
    <?php if(isset($_SESSION['recipient_name'])):?>
    <h3 class="horizontal-center box-horizontal box-rounded bg-color-orange Apadding-0p1"><?php if(isset($_SESSION['recipient_name'])){echo $_SESSION['recipient_name'];}?></h3>
    <?php endif;?> 
    </div> 

    <div class="Scroll-box-6">
    
    <div class="bigbox-horizontal stick-to-bottom box-rounded">

    <?php if(isset($result_messages) && $result_messages->num_rows > 0):?>
     <?php while($message_row = $result_messages->fetch_assoc()):?>

      <?php if($message_row['Posilac_ID'] == $_SESSION['user_id']):?>

       <?php if($message_row['Typ'] == "Zaměstnanec"):?>
        <div class="bigbox-vertical border-trans">
         <h4 class="stick-to-right border-trans"><?php echo htmlspecialchars($message_row['Jmeno']) . " " . htmlspecialchars($message_row['Prijmeni'])?></h4>
         <div class="stick-to-right box-rounded bg-color-gray Apadding-0p1">
          <p class="stick-to-left text-color-black"><?php echo htmlspecialchars($message_row['Zprava'])?></p>
         </div>
        </div>
       <?php endif;?>
       <?php if($message_row['Typ'] == "Firma"):?>
        <div class="bigbox-vertical border-trans">
         <h4 class="stick-to-right border-trans"><?php echo htmlspecialchars($message_row['Nazev'])?></h4>
         <div class="stick-to-right box-rounded bg-color-gray Apadding-0p1">
          <p class="stick-to-left text-color-black"><?php echo htmlspecialchars($message_row['Zprava'])?></p>
         </div>
        </div>
       <?php endif;?>

      <?php endif;?>

      <?php if($message_row['Posilac_ID'] != $_SESSION['user_id']):?>

       <?php if($message_row['Typ'] == "Zaměstnanec"):?>
        <div class="bigbox-vertical border-trans">
         <h4 class="stick-to-left border-trans"><?php echo htmlspecialchars($message_row['Jmeno']) . " " . htmlspecialchars($message_row['Prijmeni'])?></h4>
         <div class="stick-to-left box-rounded bg-color-gray Apadding-0p1">
          <p class="stick-to-left text-color-black"><?php echo htmlspecialchars($message_row['Zprava'])?></p>
         </div>
        </div>
       <?php endif;?>
       <?php if($message_row['Typ'] == "Firma"):?>
        <div class="bigbox-vertical border-trans">
         <h4 class="stick-to-left border-trans"><?php echo htmlspecialchars($message_row['Nazev'])?></h4>
         <div class="stick-to-left box-rounded bg-color-gray Apadding-0p1">
          <p class="stick-to-left text-color-black"><?php echo htmlspecialchars($message_row['Zprava'])?></p>
         </div>
        </div>
       <?php endif;?>

      <?php endif;?>
      

     <?php endwhile;?>
    <?php endif;?>

    <?php if(isset($_SESSION['error_message_send'])){
      echo '<p style="color: red;" class="oswald-Cfont" id="error_message">'. $_SESSION["error_message_send"] . '</p>';
      unset($_SESSION["error_message_send"]);
    }?>


    <form action="direct_message.php" class="bigbox-horizontal border-trans" method="POST">
      <textarea class="bigbox-horizontal box-rounded border-gray" id="zprava_text" name="zprava_text"><?php if(isset($_SESSION['new_recipient'])){echo "Dobrý den, mám zájem";}?></textarea>
      <input type="submit" value="Odeslat" class="box-horizontal Hpixelbox-2 text-pageread bg-color-orange text-color-black stick-to-right box-rounded Tmargin-0p1 oswald-Cfont weight-small">
    </form>

    
    </div>
    
    </div>

  </div>  

  </div>




 </main>






<?php include "../footer.php"; ?>  




</div>


</body>
</html>