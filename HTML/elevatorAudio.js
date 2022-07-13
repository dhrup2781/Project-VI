var delay = 5000;

setTimeout(function playMusicDO(){
    var music = new Audio('../audio/dooropen.mp3');
    music.play();
    music.currentTime=0;
    },delay);

setTimeout(function playMusicDC(){
    var music = new Audio('../audio/doorclose.mp3');
    music.play();
    music.currentTime=0;
    }, delay);

setTimeout(function playMusic3(){
    var music = new Audio('../audio/floor3.mp3');
    music.play();
    music.currentTime=0;
    }, delay);

setTimeout(function playMusic2(){
    var music = new Audio('../audio/floor2.mp3');
    music.play();
    music.currentTime=0;
    },delay);

setTimeout(function playMusic1(){
    var music = new Audio('../audio/floor1.mp3');
    music.play();
    music.currentTime=0;
    },delay);