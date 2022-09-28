class InputHandler {
    constructor(paddle) {
        document.addEventListener("keydown", event => {
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
        })
        document.addEventListener("keyup", event => {
            // alert(event.keyCode);
            switch (event.keyCode) {
                case 37:
                    // alert("move left")
                    if (paddle.speed < 0)
                        paddle.stop();
                    break;
                case 39:
                    // alert("move right")
                    if (paddle.speed > 0)
                        paddle.stop();
                    break;

                default:
                    break;
            }
        });
    }
}

module.exports = InputHandler;