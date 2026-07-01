<h2 class="bg-color-Lblack text-color-yellow box-horizontal box-rounded Lmargin-0p1 Bmargin-0p1 oswald-font">CONVERSATIONS</h2> 
<div class="bigbox-horizontal border-trans">
 
<div class="Scroll-box-5p5 col-4" style="flex-direction: column; justify-content: flex-start">
<ul id="listofconvos" class="bigbox-horizontal border-trans">

<?php if($convo->num_rows > 0):?>
    <?php while($convo_row = $convo->fetch_assoc()):?>

        <li class="bigbox-horizontal bg-color-Lblack box-rounded Tmargin-0p1 border-trans">
            <button class="bg-color-Lblack border-trans" onclick="LoadProfile(<?php echo $convo_row['User_ID']?>)"><h3 class="text-color-grayer box-horizontal box-rounded oswald-font border-trans"><?php echo $convo_row['Nickname'] . "(" . $convo_row['Username'] . ")"?></h3></button>
            <button class="bg-color-yellow text-color-Lblack Lpadding-0p1 Rpadding-0p1 stick-to-right box-rounded oswald-font border-trans" onclick="stopMessages(); OpenConvo(<?php echo $convo_row['Conversation_ID']?>, <?php echo $convo_row['User_ID']?>); 
                             LoadMessageInput(<?php echo $convo_row['Conversation_ID']?>, <?php echo $convo_row['User_ID']?>);">Open</button>
        </li>
        

    <?php endwhile;?>    
<?php endif;?>    

</ul>
<?php if(isset($_SESSION['errorMsg'])):?>
    <h2 class="oswald-font" style="color: red"><?php echo $_SESSION['errorMsg']?></h2>
    <?php unset($_SESSION['errorMsg']);?>
<?php endif;?>  
</div>

<div id="MessageBox" class="col-6 Scroll-box-5p5 border-trans">

</div>

</div>

