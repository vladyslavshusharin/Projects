
<div class="Bpadding-0p25 box-horizontal stick-to-right null-padding box-rounded">

    <textarea class="box-rounded bg-color-Lblack text-color-white Vpixelheight-0p5" wrap="hard" cols="75" placeholder="Message here" id="messageInput"></textarea>
    <button class="bg-color-yellow box-rounded border-trans oswald-font Lpadding-0p1 Rpadding-0p1 Vpixelbox-0p5 text-full-center" onclick="SendMessage(<?php echo $_SESSION['user_id']?>, <?php echo $CONVO_ID?>, <?php echo $OTHER_USER?>)"><p>Send</p></button>
</div>