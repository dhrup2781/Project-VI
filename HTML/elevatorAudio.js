function playMusicDO(){
    var music = new Audio('../audio/dooropen.mp3');
    music.play();
    music.currentTime=0;
    }

    setTimeout( function playMusicDC(){
    var music = new Audio('../audio/doorclose.mp3');
    music.play()
    music.currentTime=0;
    }, 5000);

function playMusic3(){
    var music = new Audio('../audio/floor3.mp3');
    music.play();
    music.currentTime=0;
    }

function playMusic2(){
    setTimeout(function(){
    var music = new Audio('../audio/floor2.mp3');
    music.play();
    music.currentTime=0;
    }, 5000);
    }

function playMusic1(){
    var music = new Audio('../audio/floor1.mp3');
    music.play();
    music.currentTime=0;
    }