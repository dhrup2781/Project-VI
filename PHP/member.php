<?php 
    // member.php
    session_start(); 

    // members only section
    if(isset($_SESSION['username'])) {
        // User is authenticated
        // echo "<br /><br /><br />";
        // echo "Welcome, " . $_SESSION['username'] . "<br />";
        // echo "<h1>Members only content goes here </h1>";

        // Display the form
        // require '../HTML/elevatorControl.html';
        require '../PHP/elevatorControl.php';
        // require '../HTML/elevatorNetworkForm.html';

        // // Connect to database and make changes
        // $db = new PDO('mysql:host=127.0.0.1;dbname=elevator', 'alex', 'password123');
        // $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // //$submitted = !empty($_POST);
        // $curr_date_query = $db->query('SELECT CURRENT_DATE()'); 
        // $current_date = $curr_date_query->fetch(PDO::FETCH_ASSOC);
        // $current_time_query = $db->query('SELECT CURRENT_TIME()');
        // $current_time = $current_time_query->fetch(PDO::FETCH_ASSOC);

        
        // $status = $_POST['status'];
        // $currentFloor = $_POST['currentFloor'];
        // $requestedFloor = $_POST['requestedFloor'];
        // $otherInfo = $_POST['otherInfo'];

        // // Node ID 
        // $nodeID = $_POST['nodeID'];

        // if(isset($_POST['insert'])) {
        //     echo "You pressed INSERT <br>"; 

        //     // INSERT
        //     $query = 'INSERT INTO elevatorNetwork(date, time, status, currentFloor, requestedFloor, otherInfo) VALUES
        //              (:date, :time, :status, :currentFloor, :requestedFloor, :otherInfo)';

        //     $params = [
        //         'date' => $current_date['CURRENT_DATE()'],
        //         'time' => $current_time['CURRENT_TIME()'],
        //         'status' => $status, 
        //         'currentFloor' => $currentFloor,
        //         'requestedFloor' => $requestedFloor, 
        //         'otherInfo' => $otherInfo
        //     ];
        //     $statement = $db->prepare($query);
        //     $result = $statement->execute($params); 
        // } elseif(isset($_POST['update'])) {
        //     echo "You pressed UPDATE <br>";

        //     // UPDATE
        //     $query = 'UPDATE elevatorNetwork SET status = :stat WHERE nodeID = :id' ;    // Note: Risks of SQL injection
        //     $statement = $db->prepare($query); 
        //     $statement->bindValue('stat', $status); 
        //     $statement->bindValue('id', $nodeID); 
        //     // ... other parameters to change
        //     $statement->execute();                      // Execute prepared statement

        // } elseif(isset($_POST['delete'])) {
        //     echo 'You pressed DELETE <br>';

        // } 

        // // Display content of database
        // echo "<h3>Content of ElevatorNetwork table</h3>";
        // $query2 = 'SELECT * FROM elevatorNetwork GROUP BY nodeID ORDER BY nodeID';
        // $rows = $db->query($query2);
        // echo "DATE     |    TIME     |     NODEID    |     STATUS     | CURRENTFLOOR    | REQUESTED FLOOR | OTHERINFO <br>";
        // foreach ($rows as $row) {
        //     echo $row['date'] . " | " . $row['time'] . " | " . $row['nodeID'] . " | " . $row['status'] . " | " 
        //                       . $row['currentFloor'] . " | " . $row['requestedFloor'] . " | " . $row['otherInfo'] . "<br>";

        // } 

        // Sign out option
        echo "<p>Click <a href='logout.php'>here</a> to log out</p>";

    } else {
        echo "<p>You are not authorized!!! Go away!!!!! Please log in <a href='../HTML/login.html'>here</a>.</p>";
    }

?>