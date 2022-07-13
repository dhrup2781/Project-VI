<?php

    function connect(string $path, string $user, string $pass) {
        $db = new PDO($path,$user, $pass);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $db; 
    }



    function showtable(string $path, string $user, string $pass, $tablename) {
        echo "<h3>Elevator Queue</h3>";
        $db = connect($path, $user, $pass); 
        $query = "SELECT * FROM $tablename";  // Note: Risk of SQL injection
        $rows = $db->query($query); 
        echo "id|newFloor<br>";
        foreach ($rows as $row) {
            echo $row['id'] . " | " . $row['newFloor'] . "<br>";
        }
    }    
    
    function show_network_table(string $path, string $user, string $pass, $tablename) {
        echo "<h3>Elevator Queue</h3>";
        $db = connect($path, $user, $pass); 
        $query = "SELECT * FROM $tablename";  // Note: Risk of SQL injection
        $rows = $db->query($query); 
        echo "id|status|currentFloor|RequestedFloor<br>";
        foreach ($rows as $row) {
            echo $row['nodeID'] . " | " . $row['status'] ." | " . $row['currentFloor'] ." | " . $row['requestedFloor'] . "<br>";
        }
    }

    function get_table_data(string $path, string $user, string $pass, $tablename) {
        $db = connect($path, $user, $pass); 
        $query = "SELECT * FROM $tablename";  // Note: Risk of SQL injection
        $rows = $db->query($query); 
        return $rows;
    }

    function remove_elevatorQueue_by_id(string $path, string $user, string $pass, $id) {
        $db = connect($path, $user, $pass); 
        $query = "DELETE FROM elevatorQueue WHERE id = $id";
        $db->query($query); 
        
    }
    function update_elevatorNetwork(string $path, string $user, string $pass, $elevatorDirection, $currentFloor, $requestedFloor){
        $db = connect($path, $user, $pass); 
        $query = "UPDATE elevatorNetwork SET status=$elevatorDirection, currentFloor=$currentFloor, requestedFloor=$requestedFloor";
        $db->query($query); 
    }


    // Create
    function insert($path, $user, $pass, $newFloor) {
    $db = connect($path, $user, $pass);
    $query = 'INSERT INTO elevatorQueue(newFloor) VALUES
        (:newFloor)';
    $params = [
    'newFloor' => $newFloor,
    ];
    $statement = $db->prepare($query);
    $result = $statement->execute($params); 
    }
    
    //session_start(); 

    //if(isset($_SESSION['username'])) {

        // Initialize variables
        $host = '127.0.0.1'; 
        $database = 'elevator'; 
        $tablename = 'elevatorQueue'; 
        $path = 'mysql:host=' . $host . ';dbname=' . $database; 
        $user = 'ese';  // Could be a variable from $_SESSION['username'] if the database has been set up with permissions for another user
        $pass = 'ese';

        $db = connect($path, $user, $pass);
    
        echo "Connected";
    
        if(isset($_POST['three'])) {
            echo "Floor 3 is pressed";
            insert($path, $user, $pass, "3");
        }
        else if(isset($_POST['two'])) {
            insert($path, $user, $pass, "2");
        }
        else if(isset($_POST['one'])) {
            insert($path, $user, $pass, "1");
        }

        $elevatorQueue = get_table_data($path, $user, $pass, 'elevatorQueue');
        $elevatorNetwork = get_table_data($path, $user, $pass, 'elevatorNetwork');
        
        foreach ($elevatorNetwork as $network){
            $elevatorDirection = $network['status'];
            $currentFloor = $network['currentFloor'];
            $requestedFloor = $network['requestedFloor'];
            break;    
        }
        
        $currentFloor = $requestedFloor;
        
        $requestedQueuedFloors = array();
        foreach ($elevatorQueue as $queueItem) {
            array_push($requestedQueuedFloors,$queueItem['newFloor']);
        }

        if($elevatorDirection==1){ # going up (next best floor number greater than current floor)
            $nextFloors = array_filter(
                $requestedQueuedFloors,
                function ($value) use($currentFloor) {
                    return ($value > $currentFloor);
                }
            );
            sort($nextFloors);
            if(count($nextFloors) > 0) {
                $requestedFloor = $nextFloors[0]; 
            }else{
                $elevatorDirection=0;
                $nextFloors = array_filter(
                    $requestedQueuedFloors,
                    function ($value) use($currentFloor) {
                        return ($value < $currentFloor);
                    }
                );
                rsort($nextFloors);
                if(count($nextFloors) > 0) {
                    $requestedFloor = $nextFloors[0];
                } 
            }

        }else{ # going down
            $nextFloors = array_filter(
                $requestedQueuedFloors,
                function ($value) use($currentFloor) {
                    return ($value < $currentFloor);
                }
            );
            rsort($nextFloors);
            if(count($nextFloors) > 0) {
                $requestedFloor = $nextFloors[0];
            } else {
                $elevatorDirection=1;
                $nextFloors = array_filter(
                    $requestedQueuedFloors,
                    function ($value) use($currentFloor) {
                        return ($value > $currentFloor);
                    }
                );
                sort($nextFloors);
                if(count($nextFloors) > 0) {
                    $requestedFloor = $nextFloors[0]; 
                }
            }
        }

        
        update_elevatorNetwork($path, $user, $pass, $elevatorDirection, $currentFloor, $requestedFloor);

        // Connect to database and make changes

    
       // if(isset($_POST['id'])) { $id = $_POST['id']; }
       // if(isset($_POST['newFloor'])) { $newFloor = $_POST['newFloor']; }
       $elevatorQueue = get_table_data($path, $user, $pass, 'elevatorQueue');

       foreach ( $elevatorQueue as $queueItem) {
        if($queueItem['newFloor']==$requestedFloor) {
            echo 'deleting';
            remove_elevatorQueue_by_id($path, $user, $pass, $queueItem['id']);
            break;
        }
       }
       
       

       foreach ($rows as $row) {
        echo $row['id'] . " | " . $row['newFloor'] . "<br>";
        }


        // Display content of database
        showtable($path, $user, $pass, $tablename);
        show_network_table($path, $user, $pass, 'elevatorNetwork');
    
    //}



?>