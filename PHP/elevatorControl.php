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

    function update_elevatorNetwork(int $new_floor) {
		$db1 = new PDO('mysql:host=127.0.0.1;dbname=elevator','ese','ese');
		$query = 'UPDATE elevatorNetwork 
				SET currentFloor = :floor
				WHERE nodeID = 1';
		$statement = $db1->prepare($query);
		$statement->bindvalue('floor', $new_floor);
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
    
        echo "Connected";
    
        if(isset($_POST['three'])) {
            update_elevatorNetwork(3);
        }
        else if(isset($_POST['two'])) {
            update_elevatorNetwork(2);
        }
        else if(isset($_POST['one'])) {
            update_elevatorNetwork(1);
        }

        show_network_table( $path,  $user,  $pass, "elevatorNetwork");
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
        <div id="head_wrap">
			<header>
				<nav class="navbar navbar-inverse navbar-fixed-top top_menu" role="navigation">	
					<!-- Logo and collapsible menu --> 
					<div class="navbar-header">
						<!-- Collapsible version of navbar goes here with a target to the id below -->
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a href="index.html" class="navbar-brand">Project VI</a>
					</div>
					<!-- Side Menu - collapses to small menu on small screens -->
					<div class="collapse navbar-collapse" id="myNavbar">
						<ul class="nav navbar-nav navbar-right s_menu">
							<li><a href="../HTML/about.html">About</a></li>
							<li><a href="../HTML/project_plan.html">Plan</a></li>
							<li><a href="../HTML/logbook.html">Log Book</a></li>
							<li><a href="../HTML/login.html">Log in</a></li>
							<li><a href="../HTML/request_access.html">Signup</a></li>
							<!-- <li><a href="../HTML/index.php">Elevator Control</a></li> -->
							<li><a href="../HTML/resources.html">Resources</a></li>
						</ul>
					</div>
				</nav>	
			</header>
		</div>
        <br/>
		<br/>
		<br/>
		<div id="page_wrap">
			<form  action="elevatorControl.php" method="POST">
				<div id="heading">
					<h1>Elevator Console</h1><br/><br/>
				</div>
				<div id="elevatorButtons">
					<div>
						<h3>Current Floor:</h1>
					</div>
					<div id="floorButtons">
						<br/><button type="submit" class="btn btn-primary btn-lg" name="three" onclick="playMusic3()">3</button><br/><br/>
						<button type="submit" class="btn btn-primary btn-lg"  name="two" onclick="playMusic2()">2</button><br/><br/>
						<button type="submit" class="btn btn-primary btn-lg"  name="one" onclick="playMusic1()">1</button><br/><br/>
					</div>
					<div id="doorButtons">
						<button type="button" class="btn btn-secondary btn-lg" name="openDoor" onclick="playMusicDO()">OPEN DOOR</button>
						<button type="button" class="btn btn-secondary btn-lg" name="closeDoor" onclick="playMusicDC()">CLOSE DOOR</button><br/><br/>
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