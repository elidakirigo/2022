//initializing firebase
var canvas;
let score;
let button;
let initialInput;
let submitButton;
let database;

var config = {};

firebase.database()

function setup()
{
    canvas = createCanvas(100, 100);
    canvas.parent("game")
    score = 0;
    createP("click the button to get points.").parent("game")
    button = createButton("click");
    button.mousePressed(increaseScore);
    button.parent("game")
    initialInput = createInput("initials")
    initialInput.parent("game")
    submitButton = createButton("submit")
    submitButton.parent("game")
    submitButton.mousePressed(submitScore)
}
console.log(firebase);

database = firebase.database()
// var ref = database.ref("score/snake")

var data = {
    name : "DTS",
    score : 43
}
ref.push(data)

function submitScore()
{
    let data = {
        initials : initialInput.value(),

        score:score
    }
    console.log(data);
    let ref = database.ref("scores")
    let result = ref.push(data);
    console.log(result.key);
    
    
}

function increaseScore()
{
    score++;
}
function draw()
{
    background(0);
    textAlign(CENTER)
    textSize(32)
    Fill(255)
    text(score , width / 2, height / 2)
}