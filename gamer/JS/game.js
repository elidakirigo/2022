//this module is used to refactor code(not having repeatitive code)
var Paddle = require("./paddle");
var InputHandler = require("./input");
var Ball = require("./ball");
var Brick = require("./brick");

class Game {
  constructor(gamewidth, gameheight) {
    this.gamewidth = gamewidth;
    this.gameheight = gameheight;
  }
  start() {
    this.paddle = new Paddle(this);

    this.ball = new Ball(this);

    // this.Brick = new Brick(this, {x:12,y:34})
    let bricks = [];
    for (let index = 0; index < 10; index++) {
      bricks.push(new Brick(this,{
        x: index * 52,
        y: 24
      }))

    }

    new InputHandler(this.paddle);

    this.gameObjects = [this.ball, this.paddle, ...bricks];
  }

  update(deltaTime) {
    // this.paddle.update(deltaTime);/
    this.gameObjects.forEach((object) => object.update(deltaTime));
    // this.ball.update(deltaTime);
  }
  draw(ctx) {
    // this.paddle.draw(ctx);
    this.gameObjects.forEach((object) => object.draw(ctx));


    // this.ball.draw(ctx);
  }
}

module.exports = Game;