<?php

    function update_elevatorNetwork(int $node_ID, int $new_floor =1): int {
        $db1 = new PDO('mysql:host=127.0.0.1;dbname=elevator','ese','ese');
        $query = 'UPDATE elevatorNetwork 
                SET currentFloor = :floor
                WHERE nodeID = :id';
        $statement = $db1->prepare($query);
        $statement->bindvalue('floor', $new_floor);
        $statement->bindvalue('id', $node_ID);
        $statement->execute();	
        
        return $new_floor;
    }
    function get_currentFloor(): int {
		try { $db = new PDO('mysql:host=127.0.0.1;dbname=elevator','ese','ese');}
		catch (PDOException $e){echo $e->getMessage();}

			// Query the database to display current floor
			$rows = $db->query('SELECT currentFloor FROM elevatorNetwork');
			foreach ($rows as $row) {
				$current_floor = $row[0];
			}
			return $current_floor;
	}
    session_start(); 
    // Members only section
    if(isset($_SESSION['username'])) {
        // Include the database functions file
        require 'databaseFunctions.php';

        // Initialize variables
        $host = '127.0.0.1'; 
        $database = 'elevator'; 
        $tablename = 'elevatorNetwork'; 
        $path = 'mysql:host=' . $host . ';dbname=' . $database; 
        $user = 'ese';  // Could be a variable from $_SESSION['username'] if the database has been set up with permissions for another user
        $password = 'ese';

        // Connect to database and make changes
        $db = connect($path, $user, $password);
        
        // Get data from db and/or form       
        $curr_date_query = $db->query('SELECT CURRENT_DATE()'); 
        $current_date = $curr_date_query->fetch(PDO::FETCH_ASSOC);
        $current_time_query = $db->query('SELECT CURRENT_TIME()');
        $current_time = $current_time_query->fetch(PDO::FETCH_ASSOC);
        if(isset($_POST['nodeID'])) { $nodeID = $_POST['nodeID']; }
        if(isset($_POST['status'])) { $status = $_POST['status']; }
        if(isset($_POST['currentFloor'])) { $currentFloor = $_POST['currentFloor']; }
        if(isset($_POST['requestedFloor'])) { $requestedFloor = $_POST['requestedFloor']; }
        if(isset($_POST['otherInfo'])) { $otherInfo = $_POST['otherInfo']; }
 
		if(isset($_POST['three'])) {
			echo "You pressed UPDATE <br>";
			insert($path, $user, $password, $current_date, $current_time, $status, $currentFloor, $requestedFloor, $otherInfo);
		} elseif(isset($_POST['two'])) {
			insert($path, $user, $password, $current_date, $current_time, $status, $currentFloor, $requestedFloor, $otherInfo);
		} elseif(isset($_POST['one'])) {
			insert($path, $user, $password, $current_date, $current_time, $status, $currentFloor, $requestedFloor, $otherInfo);
		}

		// Display content of database
        showtable($path, $user, $password, $tablename);
	}	
?>

<html>
	<h1>ESE Project VI Elevator</h1> 
	
		<?php 
			if(isset($_POST['newfloor'])) {
				$curFlr = update_elevatorNetwork(1, $_POST['newfloor']); 
				header('Refresh:0; url=member.php');	
			} 
			$curFlr = get_currentFloor();
			echo "<h2>Current floor # $curFlr </h2>";			
		?>		
		
		<h2> 	
			<form action="member.php" method="POST">
				Request floor # <input type="number" style="width:50px; height:40px" name="newfloor" max=3 min=1 required />
				<input type="submit" value="Go"/>
			</form>
		</h2>
		  
		
</html>