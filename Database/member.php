<?php

    session_start();

    //members only section
    if(isset($_SESSION['username'])) {
        // User is authenticated
        echo "Welcome," .$_SESSION['username'] . "<br/>";
        echo "<h1>Members only content goes here</h1>";

        //Display the form
        require 'elevatorNetworkform.html';

        // Connect to datatbase and make changes
        $db = new PDO('mysql:host=127.0.0.1;dbname=elevator','dpatel','ese');
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        $curr_date_query = $db->query('SELECT CURRENT_DATE()');
        $current_date = $curr_date_query->fetch(PDO::FETCH_ASSOC);
        $current_time_query = $db->query('SELECT CURRENT_TIME()');
        $current_time = $current_time_query->fetch(PDO::FETCH_ASSOC);

       // $submitted = !empty($_POST);
        if(isset($_POST['insert'])) {
            echo "Submitted successfully";

            //INSERT
            $query = 'INSERT INTO elevatorNetwork(date, time, status, currentFloor, requestedFloor, otherInfo) VALUES
                        (:date, :time, :status,:currentFloor, :requestedFloor, :otherInfo)';
            $statement = $db->prepare($query);
            $status = $_POST['status'];
            $currentFloor = $_POST['currentFloor'];
            $requestedFloor = $_POST['requestedFloor'];
            $otherInfo = $_POST['otherInfo'];

            $params = [
                'date' => $current_date['CURRENT_DATE()'],
                'time' => $current_time['CURRENT_TIME()'],
                'status' => $status,
                'currentFloor' => $currentFloor,
                'requestedFloor' => $requestedFloor,
                'otherInfo' => $otherInfo
            ];

            $result = $statement->execute($params);
        } elseif(isset($_POST['update'])) {
            echo "You pressed update";

            //UPDATE
                $query = 'UPDATE  . elevatorNetwork .  SET status = :stat WHERE nodeID = :id' ;    // Note: Risks of SQL injection
                $statement = $db->prepare($query); $statement->bindValue('stat', $new_status); 
                $statement->bindValue('id', $node_ID); 
                //add other parameters to update/change
                $statement->execute();                     
        } elseif(isset($_POST['delete'])) {
            echo "You pressed delete";
        }

        //Displey contents of Database
        echo "<h3>Content of elevatorNetwork table</h3>";
        $query2 = 'SELECT * FROM elevatorNetwork GROUP BY nodeID ORDER BY nodeID';
        $rows = $db->query($query2);
        echo "DATE  |   TIME    |   nodeID  |   status  | currentFloor  |   requestedFloor  |   otherInfo   <br/>";
        foreach($rows as $row) {
            echo $row['date'] . "|" . $row['time'] . "|" . $row['nodeID'] . "|" . $row['status'] . "|" . 
                        $row["currentFloor"] . "|" . $row['requestedFloor'] . "|" . $row['otherInfo'] . "<br/>";
        }
        //sign out option
        echo "<p>Click <a href='logout.php'>here </a></p>";

    } else {
        "<p>you are not authorized</p>";
    }