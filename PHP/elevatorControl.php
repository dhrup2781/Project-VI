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
?>
<?php 
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
				<div>
                    <?php 
                        if(isset($_POST['newfloor'])) {
                            $curFlr = update_elevatorNetwork(1, $_POST['newfloor']); 
                            header('Refresh:0; url=elevatorControl.php');	
                        } 
                        $curFlr = get_currentFloor();
                        echo "<h2>Current floor # $curFlr </h2>";			
                    ?>
                    <h2> 	
                        <form action="index.php" method="POST">
                            Request floor # <input type="number" style="width:50px; height:40px" name="newfloor" max=3 min=1 required />
                            <input type="submit" value="Go"/>
                        </form>
		            </h2>	
				</div>
                <div id="floorButtons">
                    <br/><button type="button" class="btn btn-primary btn-lg">3</button><br/><br/>
                    <button type="button" class="btn btn-primary btn-lg">2</button><br/><br/>
                    <button type="button" class="btn btn-primary btn-lg">1</button><br/><br/>
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