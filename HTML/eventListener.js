var elPassword = document.getElementById('pass');
var err = document.getElementById('err');

function checkPasswd() {
    if(elPassword.value.length < 6) {
        err.innerHTML = "<p>Error: Your password must be longer than 6 characters</p>";
    } else {
        err.innerHTML = ''; // clear error message
    }
}

elPassword.addEventListener('blur', checkPasswd, false);