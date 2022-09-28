(function () {
  function r(e, n, t) {
    function o(i, f) {
      if (!n[i]) {
        if (!e[i]) {
          var c = "function" == typeof require && require;
          if (!f && c) return c(i, !0);
          if (u) return u(i, !0);
          var a = new Error("Cannot find module '" + i + "'");
          throw ((a.code = "MODULE_NOT_FOUND"), a);
        }
        var p = (n[i] = {
          exports: {},
        });
        e[i][0].call(
          p.exports,
          function (r) {
            var n = e[i][1][r];
            return o(n || r);
          },
          p,
          p.exports,
          r,
          e,
          n,
          t
        );
      }
      return n[i].exports;
    }
    for (
      var u = "function" == typeof require && require, i = 0;
      i < t.length;
      i++
    )
      o(t[i]);
    return o;
  }
  return r;
})()(
  {
    1: [
      function (require, module, exports) {
        class Ball {
          constructor(game) {
            this.image = document.getElementById("img_ball");
            this.position = {
              x: 10,
              y: 10,
            };
            this.speed = {
              x: 2,
              y: 2,
            };
            this.size = 16;
            this.gamewidth = game.gamewidth;
            this.gameheight = game.gameheight;
            this.game = game;
          }
          draw(ctx) {
            ctx.drawImage(
              this.image,
              this.position.x,
              this.position.y,
              this.size,
              this.size
            );
          }
          update(deltaTime) {
            this.position.x += this.speed.x;
            this.position.y += this.speed.y;

            if (
              this.position.x + this.size > this.gamewidth ||
              this.position.x < 0
            )
              this.speed.x = -this.speed.x;
            if (
              this.position.y + this.size > this.gameheight ||
              this.position.y < 0
            )
              this.speed.y = -this.speed.y;

            let bottomOfBall = this.position.y + this.size;

            let topOfPaddle = this.game.paddle.position.y;

            let leftSideOfPaddle = this.game.paddle.position.x;

            let RightSideOfPaddle =
              this.game.paddle.position.x + this.game.paddle.width;

            if (
              bottomOfBall >= topOfPaddle &&
              this.position.x >= leftSideOfPaddle &&
              this.position.x + this.size <= RightSideOfPaddle
            ) {
              this.speed.y = -this.speed.y;

              this.position.y = this.game.paddle.position.y - this.size;
            }
          }
        }

        module.exports = Ball;
      },
      {},
    ],
    2: [
      function (require, module, exports) {
        class Brick {
          constructor(game, position) {
            this.image = document.getElementById("img_brick");
            this.position = position;
            this.speed = {
              x: 2,
              y: 2,
            };
            this.width = 52;
            this.height = 16;
            this.game = game;
            console.log(position);
          }

          update() {}
          draw(ctx) {
            ctx.drawImage(
              this.image,
              this.position.x,
              this.position.y,
              this.width,
              this.height
            );
          }
        }

        module.exports = Brick;
      },
      {},
    ],
    3: [
      function (require, module, exports) {
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
              bricks.push(
                new Brick(this, {
                  x: index * 52,
                  y: 24,
                })
              );
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
      },
      {
        "./ball": 1,
        "./brick": 2,
        "./input": 4,
        "./paddle": 6,
      },
    ],
    4: [
      function (require, module, exports) {
        class InputHandler {
          constructor(paddle) {
            document.addEventListener("keydown", (event) => {
              switch (event.keyCode) {
                case 37:
                  // alert("move left")
                  paddle.moveleft();

                  break;

                case 39:
                  // alert("move right")
                  paddle.moveright();

                  break;

                case 27:
                  game.togglepause();

                  break;

                case 32:
                  game.start();

                  break;
                default:
                  break;
              }
            });
            document.addEventListener("keyup", (event) => {
              // alert(event.keyCode);
              switch (event.keyCode) {
                case 37:
                  // alert("move left")
                  if (paddle.speed < 0) paddle.stop();
                  break;
                case 39:
                  // alert("move right")
                  if (paddle.speed > 0) paddle.stop();
                  break;

                default:
                  break;
              }
            });
          }
        }

        module.exports = InputHandler;
      },
      {},
    ],
    5: [
      function (require, module, exports) {
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
      },
      {
        "./game": 3,
      },
    ],
    6: [
      function (require, module, exports) {
        class Paddle {
          constructor(game) {
            this.width = 150;
            this.height = 20;
            this.position = {
              x: game.gamewidth / 2 - this.width / 2,
              y: game.gameheight - this.height - 10,
            };
            this.maxSpeed = 3;
            this.gamewidth = game.gamewidth;
            this.speed = 0;
          }

          draw(ctx) {
            ctx.fillStyle = "#0ff";

            ctx.fillRect(
              this.position.x,
              this.position.y,
              this.width,
              this.height
            );
          }

          update(deltaTime) {
            // if (!deltaTime) return;
            // this.position.x += 5 / deltaTime
            this.position.x += this.speed;
            if (this.position.x < 0) this.position.x = 0;
            if (this.position.x + this.width > this.gamewidth)
              this.position.x = this.gamewidth - this.width;
          }

          moveleft() {
            this.speed = -this.maxSpeed;
          }
          moveright() {
            this.speed = this.maxSpeed;
          }
          stop() {
            this.speed = 0;
          }
        }
        module.exports = Paddle;
      },
      {},
    ],
  },
  {},
  [5]
);
