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

        if(isset($_POST['sabbath'])) {
             
            while (1) {
                // Display content of database
                showtable($path, $user, $password, $tablename);
                
                $newfloor = 0;
                $elevatorD = 0; // going down
                $presentFloor = read_currentFloor($path, $user, $password, $tablename);
                echo "present floor is: ";
                echo $presentFloor;
                echo "<br>";

                // break;
                if ($presentFloor == 1) {
                    $elevatorD = 1; // going up
                    $newfloor = 2;
                    echo "present floor loop == 1";
                    echo "<br>";
                    for ($x = 0; $x < 2; $x++) {                        
                        update_currentFloor($path, $user, $password, $tablename, $newfloor );
                        echo $newfloor;
                        echo "<br>";
                    
                        // sleep(2);
                        $newfloor++;
                    }
                }
                elseif ($presentFloor == 2) {
                    $elevatorD = 1; // going up
                    $newfloor = 3; 
                    echo "present floor loop == 2";
                    echo "<br>";                     
                    update_currentFloor($path, $user, $password, $tablename, $newfloor );
                    // sleep(5);
                }
                elseif ($presentFloor == 3) {
                    $elevatorD = 0; // going down
                    $newfloor = 2;
                    echo "present floor loop == 3";
                    echo "<br>";
                    for ($x = 0; $x < 2; $x++) {                        
                        update_currentFloor($path, $user, $password, $tablename, $newfloor );
                        // sleep(5);
                        $newfloor--;
                    }
                }

                echo "END OF WHILE";
                if(isset($_POST['stop'])) {
                    break;
                }
                
             }         



        }



    // }

?>