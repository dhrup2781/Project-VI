<?php
    $username = $_POST['username'];
    $password = $_POST['password'];

    $db = new PDO('mysql:host=127.0.0.1; dbname=authorizedUsers', 'ese', 'ese');
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $query = "INSERT INTO authorizedUsers (username,password) VALUES ('$username','$password')";

    $result = $db->exec($query);
    if ($result) {
        echo "Signup successful, click <a href='../HTML/login.html'>here</a> to log in.";
        echo "<br/>";
    } else {
    // $error = $db->errorInfo()[2];
    // var_dump($error);
    echo"Username already exist <br/> Please go <a href ='../HTML/request_access.html'>back</a> and try again";
    }
?>