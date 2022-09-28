let ref = database.ref("score")
ref.on("value", gotData, errData)

function gotData(data)
{
    let scorelistings = selectAll(".scorelisting");
    for (let i = 0; i < scorelistings.length; i++) {
        scorelistings[i].remove()
        
    }

    console.log(data.val());
    let scores = data.val()
    let keys = Object.keys(scores)
    // console.log(keys);

    for (let i = 0; i < keys.length; i++) {
        const k = keys[i];
        let initials = scores[k].initials;
        let score = score[k].score;

        let li = createElement("li", initials + " : " + score);
        li.class("scorelisting");
        li.parent("scorelist")
    }
    
    
}
function errData(err)
{
    console.log("error!");
    console.log(err);
    

    
}