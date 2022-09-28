// sticky js ------------------
enterView({
    selector: 'section',
    enter: function enterClass(el) {
        el.classList.add('entered')
    }
})

let frameNumber = 0, // start video at frame 0
    // lower numbers = faster playback
    playBackConst = 1000,
    // get page height from video duration
    setHeight = document.getElementById('set-height'),
    // select video element
    vid = document.getElementById('v0'),
// var vid = $('#v0')[0] //jquery option

// dynamically set the page height accoding to video length
vid.addEventListener('loadedmetadata', HeightTweaks)

function HeightTweaks() {

    setHeight.style.height = Math.floor(vid.duration) * playBackConst + 'px';    console.log(setHeight.style.height);
}

function scrollPlay() {
    let frameNumber = window.pageYOffset / playBackConst;
    vid.currentTime = frameNumber;
    window.requestAnimationFrame(scrollPlay)
}

window.requestAnimationFrame(scrollPlay)

