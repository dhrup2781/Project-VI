// var delay = 5000;

// setTimeout(function playMusicDO(){
//     var music = new Audio('../audio/dooropen.mp3');
//     music.play();
//     music.currentTime=0;
//     },delay);

// setTimeout(function playMusicDC(){
//     var music = new Audio('../audio/doorclose.mp3');
//     music.play()
//     music.currentTime=0;
//     }, delay);

function playdo() {
    var music3 = new Audio('../audio/dooropen.mp3');
    music3.play();
    music3.currentTime=0;
}

const myTimeoutdo = setTimeout(playdo, 5000)
document.getElementsByName("openDoor").onclick = function playdo(){
    clearTimeout(myTimeoutdo);
}




function playm3() {
    var music3 = new Audio('../audio/floor3.mp3');
    music3.play();
    music3.currentTime=0;
}

const myTimeout3 = setTimeout(playm3, 5000)
document.getElementsByName("three").onclick = function playMusic3(){
    clearTimeout(myTimeout3);
}

function playm2() {
    var music2 = new Audio('../audio/floor2.mp3');
    music2.play();
    music2.currentTime=0;
}

const myTimeout2 = setTimeout(playm2, 5000)
document.getElementsByName("two").onclick = function playMusic2(){
    clearTimeout(myTimeout2);
}

function playm1() {
    var music1 = new Audio('../audio/floor1.mp3');
    music1.play();
    music1.currentTime=0;
}

const myTimeout1 = setTimeout(playm1, 5000)
document.getElementsByName("one").onclick = function playMusic1(){
    clearTimeout(myTimeout1);
}
// setTimeout(function playMusic2(){
//     var music = new Audio('../audio/floor2.mp3');
//     music.play();
//     music.currentTime=0;
//     },delay);

// setTimeout(function playMusic1(){
//     var music = new Audio('../audio/floor1.mp3');
//     music.play();
//     music.currentTime=0;
//     },delay);