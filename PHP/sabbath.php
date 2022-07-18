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

        header("Refresh:10");
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
        
        showtable($path, $user, $password, $tablename);


        // get the q parameter from URL
       // $q = $_REQUEST["q"];        // In this case $q == "" empty string

        // $currfloor = strval(rand(1,20));   // This is what gets sent back to the 'q=' AJAX request
        $currfloor = read_currentFloor($path, $user, $password, $tablename);
        // $currfloor = strval($currfloorRead);
        // $currfloor = 1;
        if(isset($_POST['sabbath'])) {
            // string sent to function that handles the 'onreadystatechange' event
            // echo "Current Floor: " . json_encode($currfloor);
            // while(1) {
            if ($currfloor == 1) {
                // echo "Current Floor: " . json_encode($currfloor);
                $newfloor = 2;
                update_currentFloor($path, $user, $password, $tablename, $newfloor );
                // sleep(9);
                
            }
            else if ($currfloor == 2) {
                // echo "Current Floor: " . json_encode($currfloor);
                $newfloor = 3;
                update_currentFloor($path, $user, $password, $tablename, $newfloor );
                // sleep(9);
            }
            else if ($currfloor == 3) {
                // echo "Current Floor: " . json_encode($currfloor);
                $newfloor = 1;
                update_currentFloor($path, $user, $password, $tablename, $newfloor );
                // sleep(9);
            }
        }

?>

<html lang="en">
	<head> 	
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>sabbath mode</title>
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
							<li><a href="sabbath.html">Sabbath mode</a></li> 
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
			<form action="sabbath.php" method="post">
				<div id="heading">
					<h1>Sabbath Mode</h1><br/><br/>
				</div>
				<div id="elevatorButtons">
					<div id="extraButtons">
						<button type="submit" class="btn btn-secondary btn-lg" name="sabbath">SABBATH</button><br/><br/> 
					</div>
					<div id="stopButton">
						<button type="submit" class="btn btn-danger s btn-lg" name="stop">STOP</button><br/><br/><br/>
					</div>
					<div>
						<p>Click <a href='../PHP/logout.php'>here</a> to log out</p>
					</div>
				</div>
			</form>
		</div>
        <br/>
        <br/>
		<footer>
			<p>Copyright &copy Dhrup Patel; Alex Wu; Mike Wu</p>
		</footer>
    </body>
</html>    