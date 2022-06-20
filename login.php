<?php 

// For using cookies:

// $submitted = !empty($_POST);
// if ($submitted == 1) {
//     $username = $_POST['username'];
//     $password = $_POST['password'];
//     setcookie('username', $username);
//     setcookie('password', $password);
// } 
// else {
//     $username = $_COOKIE['username'];
//     $password = $_COOKIE['password'];
// }

// echo "<p>Form submitted (1 for True): $submitted</p>";
// echo "<p>Username: $username</p>";
// echo "<p>Password: $password</p>";


// For using sessions:

    session_start();
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username && $password) {
        $_SESSION['username'] = $username;
        echo "<p>Congratulations, you are now logged into the site.</p>";
        echo "<p>Please click <a href=\"index.php\">here</a> to be taken to our members only page</p>";
    }
    else {
        echo "<p>Please enter a username and password</p>";
    }
?>
