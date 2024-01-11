begin = false;
score = 0;
px = py = 10;
gs = tc = 20;
ax = ay = 15;
b = [];
b[0] = { x: 15, y: 15 }
xv = yv = 0;
trail = [];
tail = 5;
life = 5;
var last_score = 0;
/*function addScore(score) {
    $.ajax({
        url: "AJAX.php?fnc=add",
        async: false,
        type: "POST",
        data: 'LOGIN=' + score.name + "&SCORE=" + score.score
    }).done(function (d) {
        console.log(d);
    }).error(function (x, t, a) {
        console.log(x, t, a);
    });
}*/
function drawGameOver() {
    ctx.font = "16px Arial";
    ctx.fillStyle = "#0095DD";
    ctx.fillText("Vous avez perdu");
}
function DrawScore() {
    ctx.font = "16px Arial";
    ctx.fillStyle = "#0095DD";
    ctx.fillText("Score : " + score, 8, 20);
}
/*function input_name() {

    name = document.getElementById("name").value;
    if (name != "") {
        document.getElementById("name").value = "";
        addScore({ name: name, score: $("#getScore").html() });
        g_o_div.style["display"] = "none";
        getHighScores()
    }
}*/
function getMove() {

    var x = y = 0;
    switch (ma) {
        case 0:
            x = -1;
            y = 0;
            break;
        case 1:
            x = 0;
            y = -1;
            break;
        case 2:
            x = 1;
            y = 0;
            break;
        case 3:
            x = 0;
            y = 1;
    }
    return { "x": x, "y": y }
}
function game() {
    if (life > 0) {

        px += xv;
        py += yv;

        if (px < 0) {
            px = tc - 1;
        }
        if (px > tc - 1) {
            px = 0;
        }
        if (py < 0) {
            py = tc - 1;
        }
        if (py > tc - 1) {
            py = 0;
        }
        if (ax < 0) {
            ax = tc - 1;
        }
        if (ax > tc - 1) {
            ax = 0
        }
        if (ay < 0) {
            ay = tc - 1;
        }
        if (ay > tc - 1) {
            ay = 0
        }
        if (score < 15)
            ctx.fillStyle = "grey";
        else
            ctx.fillStyle = "#333";
        ctx.fillRect(0, 0, canv.width, canv.height);
        DrawScore();
        if (score < 15)
            ctx.fillStyle = "#3AD85E";
        else {
            ctx.fillStyle = "#2A583B";
        }
        for (var i = 0; i < trail.length; i++) {
            ctx.fillRect(trail[i].x * gs, trail[i].y * gs, gs - 2, gs - 2);

            if (trail[i].x == px && trail[i].y == py) {
                if (begin) {
                    var l = $("<tr/>");
                    $("#getScore").html(score);
                    $("#scores").append(l.append($("<td/>", { html: score })));
                    alert("Perdu");
                    if (score >= last_score)
                        g_o_div.style["display"] = "block";
                    life--;
                    document.querySelector("#life").innerHTML = life;

                    score = 0;
                    tail = 5;
                    $("#score").html(score);

                    begin = false;

                }


            }
        }
        trail.push({ x: px, y: py });
        if (score >= 20) {
            if (px == bx && py == by) {
                var l = $("<tr/>");
             //   $("#scores").append(l.append($("<td/>", { html: score })));
                alert("Perdu");
                life--;

         //       document.querySelector("#life").innerHTML = life;

                score = 0;
                tail = 5;
            }
        }
        while (trail.length > tail) {
            trail.shift();
        }

        if (ax == px && ay == py) {
            tail++;
            ax = Math.floor(Math.random() * tc);
            ay = Math.floor(Math.random() * tc);

            score++;
            if (score >= 20) {
                bx = Math.floor(Math.random() * tc);
                by = Math.floor(Math.random() * tc);
            }
            play_sound("button.wav");
        }
        if (score < 15)
            ctx.fillStyle = "blue";
        else
            ctx.fillStyle = "yellow";

        ctx.fillRect(ax * gs, ay * gs, gs - 2, gs - 2);
        if (score >= 20) {
            ctx.fillStyle = "red";
            ctx.fillRect(bx * gs, by * gs, gs - 2, gs - 2);
        }
    } else {

        ctx.fillStyle = "#333";
        ctx.fillRect(Math.floor((canv.width / 3) - 5), Math.floor((canv.height / 2) - 20), 150, 20);
        ctx.font = "20px Arial";
        ctx.fillStyle = "#DD0095";
        ctx.fillText("Vous avez perdu", Math.floor((canv.width / 3)), Math.floor((canv.height / 2)));
        clearInterval(interval);
        stop_musique();

    }
}
function keyPush(evt) {
    begin = true;
    if (!playS) {
        playS = true;
        play_musique();
    }
    switch (evt.keyCode) {
        case 27:
            {
                var aud = document.getElementById('BGM');
                aud.addEventListener("ended", function () {
                    this.currentTime = 0;
                    this.pause();
                });
                $("#BGM").play();
                score = 0;
                $("#score").html(score);
                tail = 5;
                break;
            }
        case 37:
            xv = -1;
            yv = 0;
            break;
        case 38:
            xv = 0;
            yv = -1;
            break;
        case 39:
            xv = 1;
            yv = 0;
            break;
        case 40:
            xv = 0;
            yv = 1;
            break;
    }
}