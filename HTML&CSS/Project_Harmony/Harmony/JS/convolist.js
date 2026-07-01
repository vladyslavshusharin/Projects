
console.log("CONVOoooos LOADED");

if(document.getElementById("listofconvos")){
    console.log("CONVOS EXIST");
}

function OpenConvo(convo_id, other_user){
    loadSection("index.php?controller=Message&action=LoadMessages&ConvoID=" + convo_id + "&OtherUser=" + other_user, "messages.js", "MessageBox");
    messagesReload = setTimeout(OpenConvo, 1000, convo_id, other_user);
}



function LoadMessageInput(convo_id, other_user){
    fetch("index.php?controller=Message&action=GetMessageInput&ConvoID=" + convo_id + "&OtherUser=" + other_user)
    .then(res => res.text())
    .then(html =>{
        document.getElementById("AdditionalContent").innerHTML = html;
    });
}


