function ScoreWindow(gameName,_score) {
    var _overlay = document.createElement("div");
    _overlay.classList.add("_overlay");
    var _content = document.createElement("div");
    _content.classList.add("content");
    //Titre
    var h2 = document.createElement("h2");
    h2.innerHTML = "Vous avez gagné au jeu : " + gameName+"<br>Votre score est :<b>"+_score+"</b>";
    _content.appendChild(h2);
    //Contenu avec Input et label
    var row = document.createElement("div");
    row.innerHTML = "<label>Votre Nom : </label>"+
    "<input name='playerName' maxlength='15' type='text' id='name'>";
    _content.appendChild(row);
    //Bouton de validation
    var btn = document.createElement("button");
    btn.innerHTML = "Valider";
    btn.onclick = function () {
        var el=document.querySelector("[name=playerName]");
        var _name=el.value;
        addScore(gameName,_name,_score);
        document.location.reload();
    }
    _content.appendChild(btn);
    _overlay.appendChild(_content);
    document.body.prepend(_overlay);
}
function addScore(game,_name,_score){
    let xhr=new XMLHttpRequest();
    xhr.onreadystatechange = () => {
        // In local files, status is 0 upon success in Mozilla Firefox
        if (xhr.readyState === XMLHttpRequest.DONE) {
          const status = xhr.status;
          if (status === 0 || (status >= 200 && status < 400)) {
            // The request has been completed successfully
            console.log(xhr.responseText);
          } else {
            // Oh no! There has been an error with the request!
          }
        }
      };
    xhr.open("POST","ajax.php?action=addScore&game="+game);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("name="+_name+"&score="+_score);
    
}
function getScore(game, container,callback) {
    fetch("ajax.php?action=getHScore&game=" + game).then((response) => response.text())
        .then((text) => {
            var a = (JSON.parse(text));
            a.forEach((element, index) => {
                var { name, score } = element;
                var row = document.createElement("tr");
                row.innerHTML = "<td>" + (index + 1) + "</td><td>" + name + "</td><td>" + score + "</td>";
                container.appendChild(row);
            });
            if (a.length < 10) {
                for (i = a.length; i < 10; i++) {
                    var row = document.createElement("tr");
                    row.innerHTML = "<td>" + (i + 1) + "</td><td></td><td></td>";
                    container.appendChild(row);
                }
            }
            if(callback!=undefined){
                callback(a);
            }
        });
       
}
function shuffle(array) {
    let currentIndex = array.length,
        randomIndex;

    // While there remain elements to shuffle.
    while (currentIndex != 0) {

        // Pick a remaining element.
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex--;

        // And swap it with the current element.
        [array[currentIndex], array[randomIndex]] = [
            array[randomIndex], array[currentIndex]
        ];
    }

    return array;
}