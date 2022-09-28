var Game = require("./game");

let ctx = document.getElementById("gameScreen").getContext("2d");

const GAME_WIDTH = 900;
const GAME_HEIGHT = 600;

let lastTime = 0;

let game = new Game(GAME_WIDTH, GAME_HEIGHT);

game.start();

function gameloop(timestamp) {
    let deltaTime = timestamp - lastTime;

    lastTime = timestamp;

    ctx.clearRect(0, 0, GAME_WIDTH, GAME_HEIGHT);
    game.update(deltaTime);
    game.draw(ctx);
    requestAnimationFrame(gameloop);
}
requestAnimationFrame(gameloop);

// while(true){
//     paddle.draw(ctx)
// }