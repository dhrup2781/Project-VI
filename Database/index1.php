<?php
    $db = new PDO(
        'mysql:host=127.0.0.1;dbname=elevator',
        'dpatel',
        'ese'
    );
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    /*
    $query = 'INSERT INTO elevatorNetwork (date,time,nodeID,status,currentFloor,requestedFloor,otherInfo) VALUES ("2022-02-14,"12:43:10",5,1,1,1,"NA")';
    $result = $db->exec($query);
    var_dump($result);
    echo "<br/><br/>"; 
    $error = $db->errorInfo()[2];
    var_dump($error);
    echo "<br/>"; 
    */

    /*
    $query = 'INSERT INTO elevatorNetork(date,time,status,currentFloor,requestedFloor,otherInfo)
            VALUES (:date,:time,:status,:currentFloor,:requestedFloor,:otherInfo)';

    $statement = $db->prepare($query);
    $params = [
        'date' => 'CURRENT_DATE()',
        'time' => 'CURRENT_TIME()',
        'status' => 1,
        'currentFloor' => 1,
        'requestedFloor' => 2,
        'otherInfo' => 'hi there you'
    ];

    $result = $statement->execute($params);
    var_dump($result);
    */

    /* query entire database
    $rows=$db->query('SELECT * FROM elevatorNetwork ORDER BY nodeID');
    foreach($rows as $row) {
        var_dump($row);
        echo "<br/><br/>";
    }
    */
    $query = 'SELECT * FROM elevatorNetwork WHERE nodeID = :nodeID_Number';
    $statement = $db->prepare($query);
    $statement->bindValue('nodeID_Number', 1);
    $statement->execute();

    $rows = $statement->fetchAll();
    foreach($rows as $row) {
        var_dump($row);
    }
?>