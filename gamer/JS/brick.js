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

  update(){}
  draw(ctx){
    ctx.drawImage(
      this.image,
      this.position.x,
      this.position.y,
      this.width,
      this.height
  );
  } 
}

module.exports = Brick