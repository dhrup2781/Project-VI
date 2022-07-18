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

	function update_counter1(int $c1) {
		$db1 = new PDO('mysql:host=127.0.0.1;dbname=elevator','ese','ese');
		$query = 'UPDATE elevatorNetwork 
				SET C1 = :counter
				WHERE nodeID = 1';
		$statement = $db1->prepare($query);
		$statement->bindvalue('counter', $c1);
		$statement->execute();

	}

	function update_counter2(int $c2) {
		$db1 = new PDO('mysql:host=127.0.0.1;dbname=elevator','ese','ese');
		$query = 'UPDATE elevatorNetwork 
				SET C2 = :counter
				WHERE nodeID = 1';
		$statement = $db1->prepare($query);
		$statement->bindvalue('counter', $c2);
		$statement->execute();

	}
	function update_counter3(int $c3) {
		$db1 = new PDO('mysql:host=127.0.0.1;dbname=elevator','ese','ese');
		$query = 'UPDATE elevatorNetwork 
				SET C3 = :counter
				WHERE nodeID = 1';
		$statement = $db1->prepare($query);
		$statement->bindvalue('counter', $c3);
		$statement->execute();

	}

	function read_c1(string $path, string $user, string $pass, $tablename) {
        $db = connect($path, $user, $pass); 
        $query = "SELECT * FROM $tablename";  // Note: Risk of SQL injection
        $rows = $db->query($query); 
        foreach ($rows as $row) {
            $counter = $row['C1'];
        }
		return ($counter);
    }
	function read_c2(string $path, string $user, string $pass, $tablename) {
        $db = connect($path, $user, $pass); 
        $query = "SELECT * FROM $tablename";  // Note: Risk of SQL injection
        $rows = $db->query($query); 
        foreach ($rows as $row) {
            $counter = $row['C2'];
        }
		return ($counter);
    }
	function read_c3(string $path, string $user, string $pass, $tablename) {
        $db = connect($path, $user, $pass); 
        $query = "SELECT * FROM $tablename";  // Note: Risk of SQL injection
        $rows = $db->query($query); 
        foreach ($rows as $row) {
            $counter = $row['C3'];
        }
		return ($counter);
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
    
        //echo "Connected";
    
        if(isset($_POST['three'])) {
			echo '<audio src="../audio/doorclose.mp3" id="audio_close"></audio>
			<script type="text/javascript">
				document.getElementById("audio_close").play();
			</script>';
            update_elevatorNetwork(3);
			$counter = read_c3($path, $user, $pass, "elevatorNetwork") + 1;
			update_counter3($counter);
			echo '<audio src="../audio/floor3.mp3" id="my_audio"></audio>
			 <script type="text/javascript">
			   setTimeout(function(){
				 document.getElementById("my_audio").play();
			   }, 8000)
			 </script>';
			 echo '<audio src="../audio/dooropen.mp3" id="audio_open"></audio>
			 <script type="text/javascript">
			   setTimeout(function(){
				 document.getElementById("audio_open").play();
			   }, 9000)
			 </script>';
        }
        else if(isset($_POST['two'])) {
			echo '<audio src="../audio/doorclose.mp3" id="audio_close"></audio>
			<script type="text/javascript">
				document.getElementById("audio_close").play();
			</script>';
            update_elevatorNetwork(2);
			$counter = read_c2($path, $user, $pass, "elevatorNetwork") + 1;
			update_counter2($counter);
			 echo '<audio src="../audio/floor2.mp3" id="my_audio"></audio>
			 <script type="text/javascript">
			   setTimeout(function(){
				 document.getElementById("my_audio").play();
			   }, 8000)
			 </script>';
			 echo '<audio src="../audio/dooropen.mp3" id="audio_open"></audio>
			 <script type="text/javascript">
			   setTimeout(function(){
				 document.getElementById("audio_open").play();
			   }, 9000)
			 </script>';
		}
        else if(isset($_POST['one'])) {    
			echo '<audio src="../audio/doorclose.mp3" id="audio_close"></audio>
			<script type="text/javascript">
				document.getElementById("audio_close").play();
			</script>';     
            update_elevatorNetwork(1);
			$counter = read_c1($path, $user, $pass, "elevatorNetwork") + 1;
			update_counter1($counter);
			 echo '<audio src="../audio/floor1.mp3" id="my_audio"></audio>
			 <script type="text/javascript">
			   setTimeout(function(){
				 document.getElementById("my_audio").play();
			   }, 8000)
			 </script>';
			 echo '<audio src="../audio/dooropen.mp3" id="audio_open"></audio>
			 <script type="text/javascript">
			   setTimeout(function(){
				 document.getElementById("audio_open").play();
			   }, 9000)
			 </script>';
        }

		show_currentFloor( $path,  $user,  $pass, "elevatorNetwork");

       // show_network_table( $path,  $user,  $pass, "elevatorNetwork");
?>

<html lang="en">
	<head> 	
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Project VI</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />  
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>      			
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>   			
		<link rel="stylesheet" type="text/css" href="../CSS/elevatorControl.css" /> 		
	</head>
    <body>
        <style>
            body {
                background-image: url(../images/background.png);
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: cover;
            }
        </style>
        <br/>
		<br/>
		<br/>
		<div id="page_wrap">
			<form  action="elevatorControl.php" method="POST">
				<div id="heading">
					<h1>Elevator Console</h1><br/><br/>
				</div>
				<div id="elevatorButtons">
					<div id="floorButtons">
						<br/><button type="submit" class="btn btn-primary btn-lg" name="three" onclick="playMusic3()">3</button><br/><br/>
						<button type="submit" class="btn btn-primary btn-lg"  name="two" onclick="playMusic2()">2</button><br/><br/>
						<button type="submit" class="btn btn-primary btn-lg"  name="one" onclick="playMusic1()">1</button><br/><br/>
					</div>
					<div id="doorButtons">
						<button type="button" class="btn btn-secondary btn-lg" id="opendoor" name="openDoor" onclick="playMusicDO()">OPEN DOOR</button>
						<button type="button" class="btn btn-secondary btn-lg" id="closedoor" name="closeDoor" onclick="playMusicDC()">CLOSE DOOR</button><br/><br/>
						<!-- <audio id="audio" src="../audio/doorclose.mp3"></audio> -->
					</div>
					<div id="extraButtons">
						<button type="button" class="btn btn-secondary btn-lg" id="help">Help</button>
						<button type="button" class="btn btn-secondary btn-lg" id="emergency">Emergency</button><br/><br/> 
					</div>
					<div id="stopButton">
						<button type="button" class="btn btn-danger s btn-lg" id="stop">STOP</button><br/><br/><br/>
					</div>
					<div>
						<p>Click <a href='../PHP/logout.php'>here</a> to log out</p>
					</div>
				</div>
			</form>
		</div>
        <br/>
        <br/>
		<script src="../HTML/elevatorAudio.js"></script>
		<footer>
			<p>Copyright &copy Dhrup Patel; Alex Wu; Mike Wu</p>
		</footer>
    </body>
</html>    