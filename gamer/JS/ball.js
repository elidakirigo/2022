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

        if (this.position.x + this.size > this.gamewidth || this.position.x < 0)
            this.speed.x = -this.speed.x;
        if (this.position.y + this.size > this.gameheight || this.position.y < 0)
            this.speed.y = -this.speed.y;

        let bottomOfBall = this.position.y + this.size;

        let topOfPaddle = this.game.paddle.position.y;

        let leftSideOfPaddle = this.game.paddle.position.x;

        let RightSideOfPaddle = this.game.paddle.position.x + this.game.paddle.width;

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