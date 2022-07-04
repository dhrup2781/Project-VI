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
    $authenticated = FALSE;

    // $db = new PDO('mysql:host=127.0.0.1; dbname=authorizedUsers', 'alex', 'password123');
    $db = new PDO('mysql:host=127.0.0.1; dbname=authorizedUsers', 'ese', 'ese');
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Authenticate against the db

    $query = "SELECT * FROM authorizedUsers WHERE username = '$username'";
    $rows = $db->query($query);
    foreach ($rows as $row) {
        echo $row['username'];
        if($username === $row['username'] && $password === $row['password']) {
            $authenticated = TRUE;
        } else {
            echo "wrong password";
        }
    }

    if ($authenticated) {
        $_SESSION['username'] = $username;
        echo "<p>Congratulations, you are now logged into the site.</p>";
        echo "<p>Please click <a href=\"member.php\">here</a> to be taken to our members only page</p>";
    }
    // else {
    //     echo "<p>Please enter a username and password</p>";
    // }
?>
