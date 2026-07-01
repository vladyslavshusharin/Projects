
<div>
<h2 class="bg-color-Lblack text-color-yellow box-horizontal box-rounded Bmargin-0p1 oswald-font Lmargin-0p1">QUICK INVITE</h2>  
<div class="box-horizontal bg-color-yellow box-rounded Lmargin-0p1"> 
<input class="bg-color-Lblack text-color-grayer box-horizontal box-rounded" type="text" id="friendInput" placeholder="Username to request">
<button class="bg-color-Lblack text-color-yellow box-horizontal Rpadding-0p1 Lpadding-0p1 Lmargin-0p1 box-rounded oswald-font" onclick="SendRequest(null)">Send</button>
</div> 
</div>
<?php if(isset($_SESSION['errorMsg'])):?>
    <h2 class="oswald-font" style="color: red"><?php echo $_SESSION['errorMsg']?></h2>
    <?php unset($_SESSION['errorMsg']);?>
<?php endif;?>    

<div class="bigbox-horizontal null-padding border-trans">

<ul class="col-3">
<h2 class="bg-color-Lblack text-color-yellow box-horizontal box-rounded oswald-font">FRIENDS HERE</h2>
<?php if($friends->num_rows > 0):?>
    <?php while($friend = $friends->fetch_assoc()):?>
        <li class="bigbox-horizontal bg-color-Lblack box-rounded Tmargin-0p1">
            <button class="bg-color-Lblack border-trans" onclick="LoadProfile(<?php echo $friend['ID']?>)"><h3 class="text-color-grayer box-horizontal box-rounded oswald-font"><?php echo $friend['Nickname']?></h3></button>
            <div class="box-horizontal null-padding stick-to-right border-trans">
            <button class="bg-color-yellow text-color-Lblack Lpadding-0p1 Rpadding-0p1 Rmargin-0p1 box-rounded oswald-font" onclick="CreateConvo(<?php echo $friend['ID']?>)">Chat</button>
            <button class="bg-color-yellow text-color-Lblack Lpadding-0p1 Rpadding-0p1 box-rounded oswald-font" onclick="RemoveFriend(<?php echo $friend['ID']?>)">Remove</button>
            </div>
        </li>
    <?php endwhile;?>    
<?php endif;?>    

</ul>


<ul class="col-4">
<h2 class="bg-color-Lblack text-color-yellow box-horizontal box-rounded oswald-font">INCOMING REQUESTS HERE</h2>
<?php if($incoming->num_rows > 0):?>
    <?php while($income = $incoming->fetch_assoc()):?>
        <li class="bigbox-horizontal bg-color-Lblack box-rounded Tmargin-0p1">
            <h3 class="text-color-grayer box-horizontal box-rounded oswald-font"><?php echo $income['Nickname'] . "(" . $income['Username'] . ")"?></h3>
            <div class="box-horizontal null-padding stick-to-right border-trans">
            <button class="bg-color-yellow text-color-Lblack Lpadding-0p1 Rpadding-0p1 Rmargin-0p1 box-rounded oswald-font" onclick="RemoveFriend(<?php echo $income['ID']?>)">Decline</button>
            <button class="bg-color-yellow text-color-Lblack Lpadding-0p1 Rpadding-0p1 box-rounded oswald-font" onclick="AddFriend(<?php echo $income['ID']?>)">Accept</button>
            </div>  
        </li>
    <?php endwhile;?>    
<?php endif;?>

</ul>


<ul class="col-3">
<h2 class="bg-color-Lblack text-color-yellow box-horizontal box-rounded oswald-font">PENDING FRIENDS</h2>
<?php if($pending->num_rows > 0):?>
    <?php while($pend = $pending->fetch_assoc()):?>
        <li class="bigbox-horizontal bg-color-Lblack box-rounded Tmargin-0p1">
            <h3 class="text-color-grayer box-horizontal box-rounded oswald-font"><?php echo $pend['Nickname'] . "(" . $pend['Username'] . ")"?></h3>
            <button class="bg-color-yellow text-color-Lblack Lpadding-0p1 Rpadding-0p1 stick-to-right box-rounded oswald-font" onclick="RemoveFriend(<?php echo $pend['ID']?>)">Cancel</button>
        </li>
    <?php endwhile;?>    
<?php endif;?> 

</ul>
</div>