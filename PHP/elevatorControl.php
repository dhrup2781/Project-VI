<?php

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
<!DOCTYPE html>
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
            <div id="heading">
			    <h1>Elevator Console</h1><br/><br/>
            </div>
            <div id="elevatorButtons">
                <div id="floorButtons">
                    <br/><button type="button" class="btn btn-primary btn-lg" id="3" name="three">3</button><br/><br/>
                    <button type="button" class="btn btn-primary btn-lg" id="2" name="two">2</button><br/><br/>
                    <button type="button" class="btn btn-primary btn-lg" id="1" name="one">1</button><br/><br/>
                </div>
                <div id="doorButtons">
                    <button type="button" class="btn btn-secondary btn-lg" id="openDoor" onclick="playMusic()">OPEN DOOR</button>
                    <button type="button" class="btn btn-secondary btn-lg" id="closeDoor" onclick="playMusic()">CLOSE DOOR</button><br/><br/>
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

		</div>
        <br/>
        <br/>
		<script src="elevatorAudio.js"></script>
		<footer>
			<p>Copyright &copy Dhrup Patel; Alex Wu; Mike Wu</p>
		</footer>
    </body>
</html>    