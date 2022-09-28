class Paddle {
    constructor(game) {
        this.width = 150
        this.height = 20
        this.position = {
            x: game.gamewidth / 2 - this.width / 2,
            y: game.gameheight - this.height - 10
        }
        this.maxSpeed = 3
        this.gamewidth =game.gamewidth
        this.speed = 0
    }

    draw(ctx) {
        ctx.fillStyle = '#0ff'

        ctx.fillRect(this.position.x, this.position.y, this.width, this.height);

    }

    update(deltaTime) {
        // if (!deltaTime) return;
        // this.position.x += 5 / deltaTime
        this.position.x += this.speed
        if (this.position.x < 0) this.position.x = 0
        if (this.position.x + this.width > this.gamewidth) this.position.x = this.gamewidth - this.width
    }

    moveleft() {
        this.speed = -this.maxSpeed
    }
    moveright() {
        this.speed = this.maxSpeed
    }
    stop() {
        this.speed = 0
    }

}
module.exports = Paddle;