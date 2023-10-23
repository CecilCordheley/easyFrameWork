function reset(){
    var x = document.getElementById("BGM"); 
		x.load();
   x.play();
     $("#trigger").html("Pause");
     $('#rules').css("display","none");
    end_game=false;
     clearInterval(interval);
    lives = 3;
    last_input = current_input = -1;
    inputs = [];
      hasGP = false;
    //console.dir(gameP);
      is_paused, end_game = false;
      begin = true;
    
      life_max = 3;

      g_o_div = document.getElementById("input_score");
    g_o_div.style["display"] = "none";
      interval = 0;
      canvas = document.getElementById("game");
      ctx = canvas.getContext("2d");
      ballRadius = 10;
    //to move
      grey_bloc = 0;
      x = canvas.width / 2;
      y = canvas.height - 30;
      dx = 2;
      dy = -2;
    /*Paddle*/
      paddleHeight = 10;
      paddleWidth = 75;
      paddle2X=paddleX = (canvas.width - paddleWidth) / 2;
      rightPressed = false;
      leftPressed = false;
    /*Brique*/
    block_x = (canvas.width - paddleWidth) / 2;
      brickRowCount = 3;
      brickColumnCount = 5;
      brickWidth = 75;
      brickHeight = 20;
      brickPadding = 10;
      brickOffsetTop = 30;
      brickOffsetLeft = 30;
    /*Moving Bloc*/
      obs_y = (brickColumnCount * (brickHeight + brickPadding)) + brickOffsetTop;
      obs_x = 0;
      obs_right = false;
    /*Bonus*/
      has_bonus = 0;
      index_b = -1;
      bonus_name = "";
      bonus_arr = [
        {
            name: "lifemax",
            onhit: function () {
                life_max++;
            }
        }
    ]
    document.addEventListener("keydown", keyDownHandler, false);
    document.addEventListener("keyup", keyUpHandler, false);
    document.addEventListener("mousemove", mouseMoveHandler, false);
    document.getElementById("valid_name").addEventListener("click", input_name, false);
    document.getElementById("cancel_name").addEventListener("click", cancel_name, false);
      bricks = [];
      acc = 1;
      lev = 2;

    for (c = 0; c < brickColumnCount; c++) {
        bricks[c] = [];
        for (r = 0; r < brickRowCount; r++) {
           /*  var can_bonus = Math.floor(Math.random() * 100) % 2;
            if (can_bonus == 1 && has_bonus == 0) {
                var index_b = Math.floor(Math.random() * 100) % bonus_arr.length
                 var type = bonus_arr[index_b].name;
               
                has_bonus = 1;
            } else*/
                  type = Math.floor(Math.random() * 100) % ((lev < 6) ? lev : 6);

            bricks[c][r] = {x: 0, y: 0, status: 1, type: type};
        }
    }
    /*score*/
      score = 0;
      hit = 0;
      animate_interval = 0;
      start();
}
function init(){
    lives = 3;
    last_input = current_input = -1;
    inputs = [];
      hasGP = false;
    //console.dir(gameP);
      is_paused, end_game = false;
      begin = true;
    //setHScore();
      life_max = 3;

    //  g_o_div = document.getElementById("input_score");
   // g_o_div.style["display"] = "none";
      interval = 0;
      canvas = document.getElementById("game");
      ctx = canvas.getContext("2d");
      ballRadius = 10;
    //to move
      grey_bloc = 0;
      x = canvas.width / 2;
      y = canvas.height - 30;
      dx = 2;
      dy = -2;
    /*Paddle*/
      paddleHeight = 10;
      paddleWidth = 75;
      paddle2X=paddleX = (canvas.width - paddleWidth) / 2;
      rightPressed = false;
      leftPressed = false;
    /*Brique*/
    block_x = (canvas.width - paddleWidth) / 2;
      brickRowCount = 3;
      brickColumnCount = 5;
      brickWidth = 75;
      brickHeight = 20;
      brickPadding = 10;
      brickOffsetTop = 30;
      brickOffsetLeft = 30;
    /*Moving Bloc*/
      obs_y = (brickColumnCount * (brickHeight + brickPadding)) + brickOffsetTop;
      obs_x = 0;
      obs_right = false;
    /*Bonus*/
      has_bonus = 0;
      index_b = -1;
      bonus_name = "";
      bonus_arr = [
        {
            name: "lifemax",
            onhit: function () {
                life_max++;
            }
        }
    ]
    document.addEventListener("keydown", keyDownHandler, false);
    document.addEventListener("keyup", keyUpHandler, false);
    document.addEventListener("mousemove", mouseMoveHandler, false);
   
   // document.getElementById("valid_name").addEventListener("click", input_name, false);
   // document.getElementById("cancel_name").addEventListener("click", cancel_name, false);
      bricks = [];
      acc = 1;
      lev = 2;

    for (c = 0; c < brickColumnCount; c++) {
        bricks[c] = [];
        for (r = 0; r < brickRowCount; r++) {
           /*  var can_bonus = Math.floor(Math.random() * 100) % 2;
            if (can_bonus == 1 && has_bonus == 0) {
                var index_b = Math.floor(Math.random() * 100) % bonus_arr.length
                 var type = bonus_arr[index_b].name;
               
                has_bonus = 1;
            } else*/
                  type = Math.floor(Math.random() * 100) % ((lev < 6) ? lev : 6);

            bricks[c][r] = {x: 0, y: 0, status: 1, type: type};
        }
    }
    /*score*/
      score = 0;
      hit = 0;
      animate_interval = 0;
}
    var last_input;
    var inputs = [];
    var hasGP = false;
    //console.dir(gameP);
    var is_paused, end_game;
    var begin;
   var last_score=0;
    var life_max;

    var g_o_div;
   
    var interval;
    var canvas;
    var ctx;
    var ballRadius;
    //to move
    var grey_bloc;
    var x;
    var y;
    var dx;
    var dy;
    /*Paddle*/
    var paddleHeight;
    var paddleWidth;
    var paddleX,paddle2X;
    var rightPressed;
    var leftPressed;
    /*Brique*/
   var  block_x;
    var brickRowCount;
    var brickColumnCount;
    var brickWidth;
    var brickHeight;
    var brickPadding;
    var brickOffsetTop;
    var brickOffsetLeft;
    /*Moving Bloc*/
    var obs_y;
    var obs_x;
    var obs_right;
    /*Bonus*/
    var has_bonus;
    var index_b;
    var bonus_name;
    var bonus_arr = [
        {
            name: "lifemax",
            onhit: function () {
                life_max++;
            }
        }
    ]
   /* document.addEventListener("keydown", keyDownHandler, false);
    document.addEventListener("keyup", keyUpHandler, false);
    document.addEventListener("mousemove", mouseMoveHandler, false);
    document.getElementById("valid_name").addEventListener("click", input_name, false);
    document.getElementById("cancel_name").addEventListener("click", cancel_name, false);*/
    var bricks;
    var acc;
    var lev;
    /*score*/
    var score;
    var hit;
    var animate_interval;
    var lives;
stop_musique=function(){
		var x = document.getElementById("BGM"); 
		x.pause();
	}
	play_musique=function(){
		var x = document.getElementById("BGM"); 
               
		x.play();
                
	}
	play_sound=function(file){
		var a=document.createElement('audio');
		a.src="AUDIO/"+file;
		a.volume=1
		a.play();
	}
function pause() {
    if (!end_game) {
        if (is_paused) {
            interval = setInterval(draw, 10);
            is_paused = false;
		//	play_musique();
        } else {
            clearInterval(interval);
		//	stop_musique();
            is_paused = true;
            ctx.font = "40px Arial";
            ctx.fillStyle = "#9AD87E";
            ctx.fillText("PAUSE", 120, 150);

        }
    }
}
function restore(wait) {
    clearInterval(animate_interval);
    if (wait == 0) {
        interval = setInterval(draw, 10);
		play_musique();
    } else {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        drawReady();
        wait--;
        animate_interval = setInterval(function () {
            restore(wait)
        }, 500);
    }
}

function drawScore() {
    ctx.font = "16px Arial";
    ctx.fillStyle = "#0095DD";
    ctx.fillText("Score: " + hit, 30, 20);
}
function drawBonus() {
    ctx.font = "16px Arial";
    ctx.fillStyle = "#0095DD";
    ctx.fillText(bonus_name, 220, 20);
}

function drawLev() {
    ctx.font = "16px Arial";
    ctx.fillStyle = "#0095DD";
    ctx.fillText("Lev: " + (lev - 1), 175, 20);
}
function drawReady() {
    ctx.font = "bold 25px Arial";
    ctx.fillStyle = "#63DA52";
    ctx.fillText("Niveau " + (lev - 1), 175, canvas.height / 2);
}
function drawHit() {
    ctx.font = "16px Arial";
    ctx.fillStyle = "#0095DD";
    ctx.fillText("Hit: " + hit, 95, 20);
}
/*Vie*/

function drawLives() {
    ctx.font = "16px Arial";
    ctx.fillStyle = "#0095DD";
    ctx.fillText("Lives: " + lives, canvas.width - 80, 20);
}


function mouseMoveHandler(e) {
    var relativeX = e.clientX - canvas.offsetLeft;
    if (relativeX > 0 && relativeX < canvas.width) {
        paddleX = relativeX - paddleWidth / 2;
    }
}
function keyDownHandler(e) {
   // console.log(e.keyCode);
  if (e.keyCode == 39) {
        rightPressed = true;
    }
    else if (e.keyCode == 37) {
        leftPressed = true;
    } else if (e.keyCode == 16) {
        paddleX = canvas.width - paddleWidth;
    } else if (e.keyCode == 17) {
        paddleX = 0;
    }else if(e.keyCode==32){
        pause();
    }else if(e.keyCode == 27){
      //  reset();
    }
}

function keyUpHandler(e) {
    if (e.keyCode == 39) {
        rightPressed = false;
    }
    else if (e.keyCode == 37) {
        leftPressed = false;
    }
}

function drawBall() {
    ctx.beginPath();
    ctx.arc(x, y, ballRadius, 0, 2 * Math.PI);
    ctx.fillstyle = "#0033FF";
    ctx.fillStroke = "#0033FF";
    ctx.Stroke = "10"
    ctx.fill();
    ctx.closePath();
}

function drawPaddle() {
    ctx.beginPath();
    ctx.rect(paddleX, canvas.height - paddleHeight, paddleWidth, paddleHeight);
    ctx.fillstyle = "#0095DD";
    ctx.fill();
    ctx.closePath();
}
function drawPaddle2() {
    ctx.beginPath();
    ctx.rect(paddleX2, canvas.height - paddleHeight, paddleWidth, paddleHeight);
    ctx.fillstyle = "#0095DD";
    ctx.fill();
    ctx.closePath();
}
function drawObstacle(move) {
    if(move){
    if (!obs_right) {
        if (obs_x + 2 < canvas.width - brickWidth) {
            obs_x += 2;
        } else
            obs_right = true;
    } else {
        if (obs_x - 2 > 0) {
            obs_x -= 2;
        } else
            obs_right = false;
    }
}
    ctx.beginPath();
    ctx.rect(obs_x, obs_y, brickWidth, brickHeight);
    ctx.fillstyle = "#0095DD";
    ctx.fill();
    ctx.closePath();
}
function drawBricks() {
    for (c = 0; c < brickColumnCount; c++) {
        for (r = 0; r < brickRowCount; r++) {
            last_position = {col: c, row: r};
            if (bricks[c][r].status == 1) {
                var brickX = (c * (brickWidth + brickPadding)) + brickOffsetLeft;
                var brickY = (r * (brickHeight + brickPadding)) + brickOffsetTop;

                switch (bricks[c][r].type) {
                    case "p":
                        ctx.fillStyle = "#3E3E3E";
                        break;
                    case 0:
                        ctx.fillStyle = "#0095DD";
                        break;
                    case 1:
                    {
                        ctx.fillStyle = "#9500DD";
                        break;
                    }
                    case 2:
                        ctx.fillStyle = "#95DD00";
                        break;
                    case 3:
                        ctx.fillStyle = "#3A3AD8";
                        break;
                    case 4:
                        ctx.fillStyle = "#7500ED";
                        break;
                    case 5:
                        ctx.fillStyle = "#3E75ED";
                        break;
                    case 6:
                        ctx.fillStyle = "#DED85A";
                        break;
                    case "lifemax":
                        ctx.fillStyle = "#000";
                        break;
                }

                bricks[c][r].x = brickX;
                bricks[c][r].y = brickY;

                ctx.beginPath();
                ctx.rect(brickX, brickY, brickWidth, brickHeight);
                ctx.fill();
                ctx.closePath();
            }
        }
    }
}

function collisionDetection() {
    if (lev > 3 && lev % 3 == 1) {
        if (x > obs_x && x < obs_x + brickWidth && y > obs_y && y < obs_y + brickHeight) {
            dy = -dy;
			
        }
    }
    if (lev > 2 && lev % 2 == 1) {
        if (x > obs_x && x < obs_x + brickWidth && y > obs_y && y < obs_y + brickHeight) {
            dy = -dy;
			
        }
    }
    for (c = 0; c < brickColumnCount; c++) {
        for (r = 0; r < brickRowCount; r++) {
            var b = bricks[c][r];
            if (b.status == 1) {
                if (x > b.x && x < b.x + brickWidth && y > b.y && y < b.y + brickHeight) {
                    if (b.type != "p") {
                        dy = -dy;
                       // $('.footer').html((isNaN(b.type))?"TRUE":"FALSE");
                        if (isNaN(b.type)==true) {
                            bonus_name = b.type;
                        } else
                            hit++;
                        if (hit > 0 && hit % 50==0)
                            if (lives + 1 < life_max)
                                lives++;
                        if (b.type > 0 && b.type != "p"){
                            b.type--;
							
                        }else {
                            // navigator.vibrate(200)
                            b.status = 0;
                            if(isNaN(b.type)!=true)
                                score++;
                        


                            if (score == brickRowCount * brickColumnCount - grey_bloc - has_bonus) {
                                clearInterval(interval);
                                next(((lev + 1) < 10) ? lev++ : 10);
								//stop_musique();
								//play_sound("next_lev.wave");
                                animate_interval = setInterval(function () {
                                    restore(10)
                                }, 500);
                            }
                        }
                    } else
                    {
                        dy = -dy + 0.01;
						
                    }
                }
            }
        }
    }
}
function next() {
     if (lev > 2 && lev % 2 == 1) {
         obs_x= (canvas.width/(Math.floor(Math.random() * 100) % 4)) - brickWidth
     }
    score = 0;
    acc += 0.01;
    if (lives + 1 < life_max)
        lives++;
    x = canvas.width / 2;
    y = canvas.height - 30;
    grey_bloc = 0;
    brickRowCount = (Math.floor(Math.random() * 100) % 2 == 1) ? 3 : 4;
    for (c = 0; c < brickColumnCount; c++) {
        bricks[c] = [];
        for (r = 0; r < brickRowCount; r++) {
          var is_grey_bloc=Math.floor(Math.random()*100)%2;
			if(is_grey_bloc==1 && r<brickRowCount-1 && grey_bloc<((lev<5)?lev:5)){
				grey_bloc++;
				var type="p";
				}else
                  type = Math.floor(Math.random() * 100) % ((lev < 6) ? lev : 6);

            bricks[c][r] = {x: 0, y: 0, status: 1, type: type};
        }
    }
}
function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    drawBricks();
    drawBall();
    drawPaddle();
     collisionDetection();
    
   
    drawScore();
    drawLives()
    //	drawHit();
    drawLev();
    drawBonus();
    if (lev > 3 && lev % 3 == 1) {
        drawObstacle(true);
    }
    if (lev > 2 && lev % 2 == 1) {
        drawObstacle(false);
    }
    if (x + dx > canvas.width - ballRadius || x + dx < ballRadius) {
        dx = -dx * acc;
    }
    if (y + dy < ballRadius) {
        dy = -dy * acc;
    }
    else if (y + dy > canvas.height - ballRadius) {
        if (x > paddleX && x < paddleX + paddleWidth) {
            if (y = y - paddleHeight) {
                dy = -dy * acc;
            }
        }
        else {
			play_sound("BREAKOUT/glasses.wav");
            lives--
            if (lives == 0) {
				//stop_musique();
			//	play_sound("game_over.wave");
                end_game = true;
                clearInterval(interval);
                if(hit>=last_score){
                 //    g_o_div.style["display"] = "block";
                }
                     ctx.font = "56px Arial";
                    ctx.fillStyle = "#F83E3E";
                    ctx.fillText("GAME OVER", 120, 150);
                    if(hit>last_score){
                        ScoreWindow("breakout",hit);
                    }
                 
                     
            } else {
                x = canvas.width / 2;
                y = canvas.height - 30;
                dx = 2;
                dy = -2;
                paddleX = (canvas.width - paddleWidth) / 2;
            }
        }
    }
    if (rightPressed && paddleX < canvas.width - paddleWidth) {

        paddleX += 7;
    }
    else if (leftPressed && paddleX > 0) {
        paddleX -= 7;

    }
    for (c = 0; c < brickColumnCount; c++) {

        for (r = 0; r < brickRowCount; r++) {
            if (bricks[c][r].type == 1) {
                bricks[c][r].y += 5;
            }
        }
    }
    x = x + dx;
    y = y + dy;
}
function start() {
    trigger.style.display="none";
    interval = setInterval(draw, 10);
}


