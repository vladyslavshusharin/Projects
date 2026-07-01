<div class="box-vertical border-trans">


<?php if($messages->num_rows > 0):?>
    <?php while($message = $messages->fetch_assoc()):?>


            <div class="bigbox-horizontal border-trans">
                <div class="box-horizontal text-color-yellow text-full-center border-trans"><p class="oswald-font"><?php echo $message['Nickname'] . " >"?></p></div>
                <div class="box-horizontal border-trans"><p class="bg-color-Lblack box-rounded Rpadding-0p1 Bpadding-0p1 text-color-grayer border-trans oswald-font"><?php echo $message['Message_content']?></p></div>
            </div>

        
    <?php endwhile;?>    
    <input id="convo_id" type="hidden" value="<?php echo $ids['Conversation_ID']?>">
    <input id="other_user_id" type="hidden" value="<?php echo $other_user['ID']?>">

<?php endif;?>    



</div>




