<?php
     function connect(string $path, string $user, string $pass) {
        $db = new PDO($path,$user, $pass);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $db; 
    }   

    function showtable(string $path, string $user, string $password, $tablename) {
        echo "<h3>Content of ElevatorNetwork table</h3>";
        $db = connect($path, $user, $password); 
        $query = "SELECT * FROM $tablename GROUP BY nodeID ORDER BY nodeID";  // Note: Risk of SQL injection
        $rows = $db->query($query); 
        echo "DATE|TIME|NODEID|STATUS|CURRENTFLOOR|REQUESTED FLOOR|OTHERINFO <br>";
        foreach ($rows as $row) {
            echo $row['date'] . " | " . $row['time'] . " | " . $row['nodeID'] . " | " . $row['status'] . " | " 
                 . $row['currentFloor'] . " | " . $row['requestedFloor'] . " | " . $row['otherInfo'] . "<br>";
        }
    }

    function read_currentFloor(string $path, string $user, string $password, $tablename) {
        $db = connect($path, $user, $password); 
        $query = "SELECT * FROM $tablename WHERE nodeID = 1";  // Note: Risk of SQL injection
        $rows = $db->query($query); 
        foreach ($rows as $row) {
            $presentFloor = $row['currentFloor'] ;
        }
        return $presentFloor;
    }

    // Update
    function update_currentFloor(string $path, string $user, string $password, string $tablename, int $new_currentFloor ) : void {
        $db = connect($path, $user, $password);
        $query = 'UPDATE ' . $tablename . ' SET currentFloor = :curFloor  WHERE nodeID = 1' ;    // Note: Risks of SQL injection
        $statement = $db->prepare($query);
        $statement->bindValue('curFloor', $new_currentFloor);
        $statement->execute();                      // Execute prepared statement
}
    // if(isset($_SESSION['username'])) {
        // Initialize variables
        $host = '127.0.0.1'; 
        $database = 'elevator'; 
        $tablename = 'elevatorNetwork'; 
        $path = 'mysql:host=' . $host . ';dbname=' . $database; 
        $user = 'ese';  // Could be a variable from $_SESSION['username'] if the database has been set up with permissions for another user
        $password = 'ese';
        // $node_ID = 1;


        // Connect to database and make changes
        $db = connect($path, $user, $password);
        
        showtable($path, $user, $password, $tablename);


        // get the q parameter from URL
        // $q = $_REQUEST["q"];        // In this case $q == "" empty string

        $currfloor = strval(rand(1,20));   // This is what gets sent back to the 'q=' AJAX request
        $currfloor = read_currentFloor($path, $user, $password, $tablename);

        // string sent to function that handles the 'onreadystatechange' event
        echo "Current Floor: " . json_encode($currfloor);
    // while(1) {
    //     if ($currfloor == 1) {
    //         echo "Current Floor: " . json_encode($currfloor);
    //         $newfloor = 2;
    //         update_currentFloor($path, $user, $password, $tablename, $newfloor );
    //         sleep(5);
            
    //     }
    //     else if ($currfloor == 2) {
    //         echo "Current Floor: " . json_encode($currfloor);
    //         $newfloor = 3;
    //         update_currentFloor($path, $user, $password, $tablename, $newfloor );
    //         sleep(5);
    //     }
    //     else if ($currfloor == 3) {
    //         echo "Current Floor: " . json_encode($currfloor);
    //         $newfloor = 1;
    //         update_currentFloor($path, $user, $password, $tablename, $newfloor );
    //         sleep(5);
    //     }
    // }

?>

<!DOCTYPE html>
<html>
<head> 
</head>

<body>
  <p> Current floor number - updates every 5 seconds or after pressing button </p>
  <form action="">
    <button id="myButton">Get current floor now!</button>  
  </form>
  <!-- <p> Current Floor: <span id='floor'></span> </p> -->

  <!-- Add JavaScript before closing body tag -->
  <script src='../JS/getFloor.js'></script>
  <!-- Initialize a global variable for the floor number-->
  <script type='text/javascript'>var floor;</script>
</body>
</html>