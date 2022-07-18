
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>      			
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>   	
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.0/Chart.min.js"></script>
  <title>Floor Chart</title>
</head>
<body>

<?php 
    function connect(string $path, string $user, string $pass) {
        $db = new PDO($path,$user, $pass);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $db; 
    }

    function showtable(string $path, string $user, string $pass, $tablename) {
        $db = connect($path, $user, $pass); 
        $query = "SELECT * FROM $tablename";  // Note: Risk of SQL injection
        $rows = $db->query($query); 
        echo "id|newFloor<br>";
        foreach ($rows as $row) {
            echo $row['id'] . " | " . $row['newFloor'] . "<br>";
        }
    }

    function show_network_table(string $path, string $user, string $pass, $tablename) {
        $db = connect($path, $user, $pass); 
        $query = "SELECT * FROM $tablename";  // Note: Risk of SQL injection
        $rows = $db->query($query); 
        echo "id|status|currentFloor|RequestedFloor<br>";
        foreach ($rows as $row) {
            echo $row['nodeID'] . " | " . $row['status'] ." | " . $row['currentFloor'] ." | " . $row['requestedFloor'] . "<br>";
        }
    }

	function show_currentFloor(string $path, string $user, string $pass, $tablename) {
        $db = connect($path, $user, $pass); 
        $query = "SELECT * FROM $tablename";  // Note: Risk of SQL injection
        $rows = $db->query($query); 
        echo "Current floor: ";
        foreach ($rows as $row) {
            echo $row['currentFloor'] . "<br>";
        }
    }

    function update_elevatorNetwork(int $new_floor) {
		$db1 = new PDO('mysql:host=127.0.0.1;dbname=elevator','ese','ese');
		$query = 'UPDATE elevatorNetwork 
				SET currentFloor = :floor
				WHERE nodeID = 1';
		$statement = $db1->prepare($query);
		$statement->bindvalue('floor', $new_floor);
		$statement->execute();

    }

	function show_c1(string $path, string $user, string $pass, $tablename) {
        $db = connect($path, $user, $pass); 
        $query = "SELECT * FROM $tablename";  // Note: Risk of SQL injection
        $rows = $db->query($query); 
        foreach ($rows as $row) {
            $counter = $row['C1'];
        }
		return $counter;
    }
	function show_c2(string $path, string $user, string $pass, $tablename) {
        $db = connect($path, $user, $pass); 
        $query = "SELECT * FROM $tablename";  // Note: Risk of SQL injection
        $rows = $db->query($query); 
        foreach ($rows as $row) {
            $counter = $row['C2'];
        }
		return $counter;
    }
	function show_c3(string $path, string $user, string $pass, $tablename) {
        $db = connect($path, $user, $pass); 
        $query = "SELECT * FROM $tablename";  // Note: Risk of SQL injection
        $rows = $db->query($query); 
        foreach ($rows as $row) {
            $counter = $row['C3'];
        }
		return $counter;
    }

	function update_counter1(int $c1) {
		$db1 = new PDO('mysql:host=127.0.0.1;dbname=elevator','ese','ese');
		$query = 'UPDATE elevatorNetwork 
				SET C1 = :counter1
				WHERE nodeID = 1';
		$statement = $db1->prepare($query);
		$statement->bindvalue('counter1', $c1);
		$statement->execute();
	}

	function update_counter2(int $c2) {
		$db1 = new PDO('mysql:host=127.0.0.1;dbname=elevator','ese','ese');
		$query = 'UPDATE elevatorNetwork 
				SET C2 = :counter2
				WHERE nodeID = 1';
		$statement = $db1->prepare($query);
		$statement->bindvalue('counter2', $c2);
		$statement->execute();
	}

	function update_counter3(int $c3) {
		$db1 = new PDO('mysql:host=127.0.0.1;dbname=elevator','ese','ese');
		$query = 'UPDATE elevatorNetwork 
				SET C3 = :counter3
				WHERE nodeID = 1';
		$statement = $db1->prepare($query);
		$statement->bindvalue('counter3', $c3);
		$statement->execute();
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
        $counter1 = show_c1($path,  $user,  $pass, "elevatorNetwork");
        $counter2 = show_c2($path,  $user,  $pass, "elevatorNetwork");
        $counter3 = show_c3($path,  $user,  $pass, "elevatorNetwork");

        echo $counter1 . "<br>";
        echo $counter2 . "<br>";
        echo $counter3 . "<br>";


?>


<div style="width: 500px">
  <canvas id="myChart"></canvas>
</div>
 
<script>
const ctx = document.getElementById('myChart').getContext('2d');
const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Floor 1', 'Floor 2', 'Floor 3'],
        datasets: [{
            label: 'Floor Request Count',
            data: [<?php echo json_encode($counter1)?>, <?php echo json_encode($counter2)?>, <?php echo json_encode($counter3)?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

</body>
</html>