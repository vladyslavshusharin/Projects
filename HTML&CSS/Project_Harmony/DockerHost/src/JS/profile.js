function ShowHide(){
    const showBox = document.getElementById("showBox");
    const editBox = document.getElementById("editBox");
    if(showBox.classList.contains("closed")){
        showBox.classList.remove("closed");
        editBox.classList.add("closed");
    }
    else if(editBox.classList.contains("closed")){
        editBox.classList.remove("closed");
        showBox.classList.add("closed");
    }
}

function editProfile(user_id){
    console.log("EDIT SENT");
    let nickname = document.getElementById("EditNickname").value;
    if(nickname){
        fetch("index.php?controller=User&action=UpdateProfile", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'new_nickname=' + encodeURIComponent(nickname)
        }).
        then(res=>res.text()).
        then(() => {
            loadSection("index.php?controller=User&action=LoadProfile&UserID=" + user_id, null, "Content");
        });

    }
}

function SendRequestFromProfile(friend, user_id){
    console.log("REQUEST SENT?");
    let friendName = friend;
    if(friendName){
        fetch("index.php?controller=Friends&action=SendFriendReq", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'friend_username=' + encodeURIComponent(friendName)
        }).
        then(res=>res.text()).
        then(() => {
            loadSection("index.php?controller=Friends&action=FriendList", "friendlist.js", "Content");
        });

    }

}