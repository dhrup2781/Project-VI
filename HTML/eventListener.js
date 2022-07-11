// var elPassword = document.getElementById('pass');
// var err = document.getElementById('err');

// function checkPasswd() {
//     if(elPassword.value.length < 3) {
//         err.innerHTML = "<p>Error: Your password must be longer than 3 characters</p>";
//     } else {
//         err.innerHTML = ''; // clear error message
//     }
// }

// elPassword.addEventListener('blur', checkPasswd, false);

var elPassword = document.getElementById('pass');
var elUsername = document.getElementById('user');
var err = document.getElementById('err');
var err2 = document.getElementById('err2');

function checkPasswd() {
    if((elPassword.value.length <= 6) || (elUsername.value.length <= 6)) {
        err.innerHTML = "<p>Error: Your username and password must be at least 7 characters</p>";

        $('#subbtn').prop('disabled', true);
    } 
    else {
        err.innerHTML = ''; // clear error message

        $('#subbtn').prop('disabled', false);

    }

    // else if (elPassword.search(/[A-Z]/) < 0 && elPassword.search(/[0-9]/) < 0) {
    //     err.innerHTML = "<p>Error: Your password must contain at least one uppercase letter and one number</p>";
    // } 
    if (elPassword.value.search(/[A-Z]/) < 0 || elPassword.value.search(/[0-9]/) < 0  ) {
        err2.innerHTML = "<p>Error: Your password must contain at least one uppercase letter and one number</p>";

        $('#subbtn').prop('disabled', true);
    }    
    else {
        err2.innerHTML = '';
        $('#subbtn').prop('disabled', false);
    }
}

elPassword.addEventListener('blur', checkPasswd, false);