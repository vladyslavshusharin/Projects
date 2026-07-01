//Some functions for styling etc.

//COLLAPSIBLE


  //Zvětšení/zmenšení kontentu uvnitř klikatelného pole (parent kontejneru)
document.addEventListener("click", (event) => { //Přidávání naslouchače pro kliknutí a definování funkce s event parametrem
    if(event.target.classList.contains("collapsible-button")){ //Kontrola daného elementu při kliknutí jestli obsahuje class "collapsible button" 
     const button = event.target; //Ukládání daného kliknutého elementu jako proměnnou 
     const content = button.querySelector(".collapsible-content"); //Ukládání kontentu (u kterého měníme velikost) do proměnné, který je descendant daného button elementu a obsahuje class collapsible-content
     content.classList.toggle("open"); //Změna classy pro daný kontent, v tomto případě zvětšení/zmenšení kontentu

    }
});

  //Zvětšení/zmenšení kontentu při kliknutí na daný kontent
document.addEventListener("click", (event) => { //Přidávání naslouchače pro kliknutí a definování funkce
    const collapsible = event.target.closest(".collapsible-content"); //Ukládání zvětšujícího/zmenšujícího se kontentu pokud samotný kontent obsahuje daný selector nebo někdo z jeho ancestrů
    if(collapsible){ //Pokud closest vrátí najdený element (tím pádem collapsible je true), vykoná se změna classy a kontent se zvětší/změnší
        collapsible.classList.toggle("open");
    }
});

//COLLAPSIBLE END

//POPUP

document.addEventListener("click", (event) => { //Zase přidáme naslouchače na kliknutí a event parametr
    if(event.target.classList.contains("openpopup")){ //Pokud daný element obsahuje classu openpopup
        const openbutt = event.target; //Ukládání daného elementu do proměnné
        const openpopup = openbutt.nextElementSibling; //Následující element po kliknutém elementu do proměnné
        if(openpopup.classList.contains("popup")){openpopup.classList.add("open");} else{console.log("No popup found next to this button");} //Pokud obsahuje daný sibling class popup, přidáme open
    }
});

document.addEventListener("click", (event) => { //Zase přidáme naslouchače na kliknutí a event parametr
    if(event.target.classList.contains("closepopup")){ //Pokud daný element obsahuje classu closepopup
       const closebutt = event.target; //Ukládání daného elementu do proměnné
       const closepopup = closebutt.closest(".popup"); //Element nejbližší (Samotný element nebo ancestor), který obsahuje class popup
       if(closepopup){closepopup.classList.remove("open");} //Pokud closest vrátí najdený element tak odebere z daného elementu
    }
});


//POPUP END





