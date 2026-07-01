<div class="bigbox-horizontal border-trans">
    <div class="box-vertical col-3 border-trans" id="friendsList">
    <h2 class="bg-color-Lblack text-color-yellow box-horizontal box-rounded oswald-font">Friends</h2>
    <?php if($friends->num_rows > 0):?>
     <?php while($friend = $friends->fetch_assoc()):?>
        <li class="bigbox-horizontal bg-color-Lblack box-rounded Tmargin-0p1">
            <button class="bg-color-Lblack border-trans" onclick="LoadProfile(<?php echo $friend['ID']?>)"><p class="text-color-grayer box-horizontal box-rounded oswald-font"><?php echo $friend['Nickname'] . "(" . $friend['Username'] . ")"?></p></button>
            <button class="bg-color-yellow text-color-Lblack Lpadding-0p1 Rpadding-0p1 stick-to-right box-rounded oswald-font" onclick="CreateConvo(<?php echo $friend['ID']?>)">Chat</button>
        </li>
     <?php endwhile;?>    
    <?php endif;?>   

    </div>

    <div class="box-vertical col-3 border-trans" id="convoList">
    <h2 class="bg-color-Lblack text-color-yellow box-horizontal box-rounded oswald-font">Conversations</h2>
    <?php if($convos->num_rows > 0):?>
     <?php while($convo_row = $convos->fetch_assoc()):?>
        <li class="bigbox-horizontal bg-color-Lblack box-rounded Tmargin-0p1">
            <button class="bg-color-Lblack border-trans" onclick="LoadProfile(<?php echo $convo_row['User_ID']?>)"><p class="text-color-grayer box-horizontal box-rounded oswald-font"><?php echo $convo_row['Nickname'] . "(" . $convo_row['Username'] . ")"?></p></button>
            <button class="bg-color-yellow text-color-Lblack Lpadding-0p1 Rpadding-0p1 stick-to-right box-rounded oswald-font" onclick=" loadSection('index.php?controller=Conversation&action=LoadConvos', 'convolist.js', 'Content'); OpenConvo(<?php echo $convo_row['Conversation_ID']?>, <?php echo $convo_row['User_ID']?>); 
                             LoadMessageInput(<?php echo $convo_row['Conversation_ID']?>, <?php echo $convo_row['User_ID']?>);">Open</button>
        </li>
     <?php endwhile;?>    
    <?php endif;?>    

    </div>

    <div class="box-vertical col-4 border-trans">

        <h1 class="bg-color-Lblack text-color-yellow box-horizontal box-rounded oswald-font"><?php echo $user_details['Nickname']?></h1>
        <h2 class="bg-color-Lblack text-color-grayer box-horizontal box-rounded Tmargin-0p1 oswald-font"><?php echo "(" . $user_details['Username'] . ")"?></h2>
        <h2 class="bg-color-Lblack text-color-grayer box-horizontal box-rounded Tmargin-0p1 oswald-font"><?php echo $user_details['Email']?></h2>
        
    </div>

</div>