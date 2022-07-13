<?php

function connect(string $path, string $user, string $pass) {
    $db = new PDO($path,$user, $pass);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $db; 
}



function showtable(string $path, string $user, string $pass, $tablename) {
    echo "<h3>AuthorizedUsers Table</h3>";
    $db = connect($path, $user, $pass); 
    $query = "SELECT * FROM $tablename GROUP BY id ORDER BY id";  // Note: Risk of SQL injection
    $rows = $db->query($query); 
    echo "id|username|password|admin<br>";
    foreach ($rows as $row) {
        echo $row['id'] . " | " . $row['username'] . " | " . $row['password'] . " | " . $row['admin'] . "<br>";
    }
}
echo "Connected";
session_start(); 
if(isset($_SESSION['username'])) {

    // Initialize variables
    $host = '127.0.0.1'; 
    $database = 'authorizedUsers'; 
    $tablename = 'authorizedUsers'; 
    $path = 'mysql:host=' . $host . ';dbname=' . $database; 
    $user = 'ese';  // Could be a variable from $_SESSION['username'] if the database has been set up with permissions for another user
    $pass = 'ese';

    // Connect to database and make changes
    $db = connect($path, $user, $pass);



    if(isset($_POST['id'])) { $id = $_POST['id']; }
    if(isset($_POST['username'])) { $username = $_POST['username']; }
    if(isset($_POST['password'])) { $password = $_POST['password']; }
    if(isset($_POST['admin'])) { $admin = $_POST['admin']; }

    if(isset($_POST['insert'])) {
        insert($path, $user, $pass, $username, $password, $admin);
    }
    else if(isset($_POST['update'])) {
        update($path, $user, $pass, $tablename, $id, $admin);
    }
    else if(isset($_POST['delete'])) {
        delete($path, $user, $pass, $tablename, $id);
    }

    // Display content of database
    showtable($path, $user, $pass, $tablename);

    echo "<p>Click <a href='logout.php'>here</a> to log out</p>";

}

// Create
function insert($path, $user, $pass, $username, $password, $admin) {
    $db = connect($path, $user, $pass);
    $query = 'INSERT INTO authorizedUsers(username, password, admin) VALUES
    (:username, :password, :admin)';
    $params = [
        'username' => $username,
        'password' => $password,
        'admin' => $admin
    ];
    $statement = $db->prepare($query);
    $result = $statement->execute($params); 
}


// Update
function update(string $path, string $user, string $pass, string $tablename, $id, $admin) : void {
    $db = connect($path, $user, $pass);
    $query = 'UPDATE ' . $tablename . ' SET admin = :admin WHERE id = :id' ;    // Note: Risks of SQL injection
    $statement = $db->prepare($query); 
    $statement->bindValue('admin', $admin);
    $statement->bindValue('id', $id); 
    $statement->execute();                      // Execute prepared statement
}

// Delete
function delete(string $path, string $user, string $pass, string $tablename, $id) : void {
    $db = connect($path, $user, $pass);
    $query = 'DELETE FROM ' . $tablename . ' WHERE id = :id' ;    // Note: Risks of SQL injection
    $statement = $db->prepare($query); 
    $statement->bindValue('id', $id); 
    $statement->execute();                      // Execute prepared statement
}

?>

<html>
    <body>
        <h2>Form used to update/delete/add data to database</h2>
        <form action="admin.php" method="post">
            id: <input type='text' name='id' /><br/>
            username: <input type='text' name='username' /><br/>
            password: <input type='text' name='password' /><br/>
            admin: <input type='text' name='admin' /><br/>
            <input type="submit" value="INSERT" name="insert"/>
            <input type="submit" value="DELETE" name="delete"/>
            <input type="submit" value="UPDATE" name="update"/>
        </form>
    </body>
</html>