function SendMessage(user_id, convo_id, other_user){
    const messageContent = document.getElementById("messageInput").value;
    const messageInput = document.getElementById("messageInput");
    messageInput.value = "";
    fetch("index.php?controller=Message&action=SendMessage", {
        method: 'POST',
        headers:{
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'user_ID=' + encodeURIComponent(user_id) + 
              '&convo_ID=' + encodeURIComponent(convo_id) +
              '&message_content=' + encodeURIComponent(messageContent)
    }).
    then(res=>res.text()).
    then(() => {
        
        loadSection("index.php?controller=Message&action=LoadMessages&ConvoID=" + convo_id + "&OtherUser=" + other_user, "messages.js", "MessageBox");
    });


}



