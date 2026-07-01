
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheet.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="../main.css">
    <title>Harmony</title>
</head>
<body class="full-height bg-color-black border-trans">
    
<main>

 <div class="bigbox-horizontal null-padding align-center border-trans bg-color-Lblack Bmargin-0p1">
    <button onclick="stopMessages()" class="Lpadding-0p1 box-horizontal box-rounded Rpadding-0p1 Rmargin-0p25 icon-btn text-full-center" type="button" id="dashboard">
        <img src="HarmonyLogoClear.png" height="35px">
        <img class="Lmargin-0p1" src="HarmonyText.png" height="20px">
    </button>
    <button onclick="stopMessages()" class="Lpadding-0p1 box-horizontal box-rounded Rpadding-0p1 Rmargin-0p25 bg-color-yellow text-color-Lblack oswald-font text-pageread" type="button" id="friends">Friends</button>
    <button onclick="stopMessages()" class="Lpadding-0p1 box-horizontal box-rounded Rpadding-0p1 Rmargin-0p25 bg-color-yellow text-color-Lblack oswald-font text-pageread" type="button" id="conversations">Conversations</button>
    <div class="box-horizontal null-padding stick-to-right text-full-center border-trans">
     <button class="Lpadding-0p1 box-rounded Rpadding-0p1 bg-color-yellow text-color-Lblack box-horizontal Rmargin-0p25 oswald-font" type="button" id="logoutbutt">Logout</button>
     <button class="btn btn-warning fw-bold px-4 py-2 rounded-3 shadow-sm align-items-center justify-content-center" onclick="stopMessages()" type="button" id="profile">
     <span class="text-color-black"><?php echo $_SESSION['nickname']?></span>
     </button>
    </div>
 </div>

 <div>


    <div id="Content" class="">
        <?php require "View/dashboard.php"; ?>
    </div>

    <div id="AdditionalContent">
        
    </div>



 </div>

</main>


</body>


<script>

let dashboardBT = document.getElementById("dashboard");
let friendsBT = document.getElementById("friends");
let conversationsBT = document.getElementById("conversations");
let searchBT = document.getElementById("search");
let profileBT = document.getElementById("profile");
let logBT = document.getElementById("logoutbutt");

var messagesReload = null;

function loadSection(neededURL, neededJS, elementID){
    console.log("Reloaded");

    fetch(neededURL)
    .then(res => res.text())
    .then(html =>{
        if(elementID != null){
        document.getElementById(elementID).innerHTML = html;
        }

        if(neededJS != null){
        const newscript = document.createElement('script');
        newscript.src = "JS/" + neededJS;
        document.body.appendChild(newscript);
        }
    });
}

function stopMessages(){
    if(messagesReload !== null){
        clearTimeout(messagesReload);
        messagesReload = null;
    }
}

conversationsBT.addEventListener('click', () => {
    stopMessages();
    loadSection("index.php?controller=Conversation&action=LoadConvos", "convolist.js", "Content");
    document.getElementById("AdditionalContent").innerHTML = "";
    document.getElementById("Content").classList.remove("Scroll-box-6");
});
friendsBT.addEventListener('click', () => {
    stopMessages();
    loadSection("index.php?controller=Friends&action=FriendList", "friendlist.js", "Content");
    document.getElementById("AdditionalContent").innerHTML = "";
    document.getElementById("Content").classList.remove("Scroll-box-6");
});
profileBT.addEventListener('click', () => {
    stopMessages();
    const user_id = <?php echo json_encode($_SESSION['user_id']); ?>;
    loadSection("index.php?controller=User&action=LoadProfile&UserID=" + user_id, "profile.js?v=" + Date.now(), "Content");
    document.getElementById("AdditionalContent").innerHTML = "";
    document.getElementById("Content").classList.remove("Scroll-box-6");
});
dashboardBT.addEventListener('click', () => {
    stopMessages();
    loadSection("index.php?controller=User&action=LoadDashboard", null, "Content");
    document.getElementById("AdditionalContent").innerHTML = "";
    document.getElementById("Content").classList.remove("Scroll-box-6");
});
logBT.addEventListener('click', () => {
    console.log("halo");
    window.location.href = "index.php?controller=User&action=Logout";
});


</script>


<script src="JS/convolist.js"></script>
<script src="JS/friendlist.js"></script>

</html>