<?php

    function connect(string $path, string $user, string $pass) {
        $db = new PDO($path,$user, $pass);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $db; 
    }



    function showtable(string $path, string $user, string $pass, $queue_tablename) {
        echo "<h3>Elevator Queue</h3>";
        $db = connect($path, $user, $pass); 
        $query = "SELECT * FROM $queue_tablename";  // Note: Risk of SQL injection
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

    function get_table_data(string $path, string $user, string $pass, $tablename) {
        $db = connect($path, $user, $pass); 
        $query = "SELECT * FROM $tablename";  // Note: Risk of SQL injection
        $rows = $db->query($query); 
        return $rows;
    }

    function remove_elevatorQueue_by_id(string $path, string $user, string $pass, $id) {
        $db = connect($path, $user, $pass); 
        $query = "DELETE FROM elevatorQueue WHERE id = $id";
        $db->query($query); 
        
    }
    function update_elevatorNetwork(string $path, string $user, string $pass, $elevatorDirection, $currentFloor, $requestedFloor){
        $db = connect($path, $user, $pass); 
        $query = "UPDATE elevatorNetwork SET status=$elevatorDirection, currentFloor=$currentFloor, requestedFloor=$requestedFloor";
        $db->query($query); 
    }


    // Create
    function insert($path, $user, $pass, $newFloor) {
    $db = connect($path, $user, $pass);
    $query = 'INSERT INTO elevatorQueue(newFloor) VALUES
        (:newFloor)';
    $params = [
    'newFloor' => $newFloor,
    ];
    $statement = $db->prepare($query);
    $result = $statement->execute($params); 
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
        $tablename = 'elevatorNetwork'; 
        $queue_tablename = 'elevatorQueue'; 
        $path = 'mysql:host=' . $host . ';dbname=' . $database; 
        $user = 'ese';  // Could be a variable from $_SESSION['username'] if the database has been set up with permissions for another user
        $pass = 'ese';

        $db = connect($path, $user, $pass);
    
        //echo "Connected";
    
        if(isset($_POST['three'])) {
            // echo '<audio src="../audio/doorclose.mp3" id="audio_close"></audio>
			// <script type="text/javascript">
			// 	document.getElementById("audio_close").play();
			// </script>';
            echo "Floor 3 is pressed";
            insert($path, $user, $pass, "3");
            $counter = read_c3($path, $user, $pass, "elevatorNetwork") + 1;
			update_counter3($counter);

            



            // echo '<audio src="../audio/floor3.mp3" id="my_audio"></audio>
			//  <script type="text/javascript">
			//    setTimeout(function(){
			// 	 document.getElementById("my_audio").play();
			//    }, 8000)
            //    </script>';
            //    echo '<audio src="../audio/dooropen.mp3" id="audio_open"></audio>
            //    <script type="text/javascript">
            //      setTimeout(function(){
            //        document.getElementById("audio_open").play();
            //      }, 9000)
            //    </script>';
        }
        else if(isset($_POST['two'])) {
            // echo '<audio src="../audio/doorclose.mp3" id="audio_close"></audio>
			// <script type="text/javascript">
			// 	document.getElementById("audio_close").play();
			// </script>';
            echo "Floor 2 is pressed";
            insert($path, $user, $pass, "2");
            $counter = read_c2($path, $user, $pass, "elevatorNetwork") + 1;
			update_counter2($counter);
            // echo '<audio src="../audio/floor2.mp3" id="my_audio"></audio>
            // <script type="text/javascript">
            //   setTimeout(function(){
            //     document.getElementById("my_audio").play();
            //   }, 8000)
            // </script>';
            // echo '<audio src="../audio/dooropen.mp3" id="audio_open"></audio>
            // <script type="text/javascript">
            //   setTimeout(function(){
            //     document.getElementById("audio_open").play();
            //   }, 9000)
            // </script>';
        }
        else if(isset($_POST['one'])) {
            // echo '<audio src="../audio/doorclose.mp3" id="audio_close"></audio>
			// <script type="text/javascript">
			// 	document.getElementById("audio_close").play();
			// </script>';
            echo "Floor 1 is pressed";
            insert($path, $user, $pass, "1");
            $counter = read_c1($path, $user, $pass, "elevatorNetwork") + 1;
			update_counter1($counter);

            
			//  echo '<audio src="../audio/floor1.mp3" id="my_audio"></audio>
			//  <script type="text/javascript">
			//    setTimeout(function(){
			// 	 document.getElementById("my_audio").play();
			//    }, 8000)
			//  </script>';
			//  echo '<audio src="../audio/dooropen.mp3" id="audio_open"></audio>
			//  <script type="text/javascript">
			//    setTimeout(function(){
			// 	 document.getElementById("audio_open").play();
			//    }, 9000)
			//  </script>';
        }
        else if(isset($_POST['stop'])) {
            echo "Stop is pressed";
            insert($path, $user, $pass, "0");
        }



        $elevatorNetwork = get_table_data($path, $user, $pass, $tablename);
        
        foreach ($elevatorNetwork as $network){
            $currentFloor = $network['currentFloor'];
            break;    
        }

        // if ($currentFloor == 1) {
        //     echo '<audio src="../audio/floor1.mp3" id="my_audio"></audio>
		// 	 <script type="text/javascript">
		// 	   setTimeout(function(){
		// 		 document.getElementById("my_audio").play();
		// 	   }, 8000)
		// 	 </script>';
		// 	 echo '<audio src="../audio/dooropen.mp3" id="audio_open"></audio>
		// 	 <script type="text/javascript">
		// 	   setTimeout(function(){
		// 		 document.getElementById("audio_open").play();
		// 	   }, 9000)
		// 	 </script>';
        // }
        // else if ($currentFloor == 2) {
        //     echo '<audio src="../audio/floor2.mp3" id="my_audio"></audio>
		// 	 <script type="text/javascript">
		// 	   setTimeout(function(){
		// 		 document.getElementById("my_audio").play();
		// 	   }, 8000)
		// 	 </script>';
		// 	 echo '<audio src="../audio/dooropen.mp3" id="audio_open"></audio>
		// 	 <script type="text/javascript">
		// 	   setTimeout(function(){
		// 		 document.getElementById("audio_open").play();
		// 	   }, 9000)
		// 	 </script>';
        // } else if ($currentFloor == 3) {
        //     echo '<audio src="../audio/floor3.mp3" id="my_audio"></audio>
        //         <script type="text/javascript">
        //         setTimeout(function(){
        //             document.getElementById("my_audio").play();
        //         }, 8000)
        //         </script>';
        //         echo '<audio src="../audio/dooropen.mp3" id="audio_open"></audio>
        //         <script type="text/javascript">
        //         setTimeout(function(){
        //             document.getElementById("audio_open").play();
        //         }, 9000)
        //         </script>';
    
        // }


    //     $elevatorQueue = get_table_data($path, $user, $pass, $queue_tablename);
    //     $elevatorNetwork = get_table_data($path, $user, $pass, $tablename);
        
    //     foreach ($elevatorNetwork as $network){
    //         $elevatorDirection = $network['status'];
    //         $currentFloor = $network['currentFloor'];
    //         $requestedFloor = $network['requestedFloor'];
    //         break;    
    //     }
        
    //     if ($currentFloor == $requestedFloor){
    //         // store in ele queue
    //         $requestedQueuedFloors = array();
    //         foreach ($elevatorQueue as $queueItem) {
    //             array_push($requestedQueuedFloors,$queueItem['newFloor']);
    //         }
    
    //         if($elevatorDirection==1){ # going up (next best floor number greater than current floor)
    //             $nextFloors = array_filter(
    //                 $requestedQueuedFloors,
    //                 function ($value) use($currentFloor) {
    //                     return ($value > $currentFloor);
    //                 }
    //             );
    //             sort($nextFloors);
    //             if(count($nextFloors) > 0) {
    //                 $requestedFloor = $nextFloors[0]; 
    //             }else{
    //                 $elevatorDirection=0;
    //                 $nextFloors = array_filter(
    //                     $requestedQueuedFloors,
    //                     function ($value) use($currentFloor) {
    //                         return ($value < $currentFloor);
    //                     }
    //                 );
    //                 rsort($nextFloors);
    //                 if(count($nextFloors) > 0) {
    //                     $requestedFloor = $nextFloors[0];
    //                 } 
    //             }
    
    //         }else{ # going down
    //             $nextFloors = array_filter(
    //                 $requestedQueuedFloors,
    //                 function ($value) use($currentFloor) {
    //                     return ($value < $currentFloor);
    //                 }
    //             );
    //             rsort($nextFloors);
    //             if(count($nextFloors) > 0) {
    //                 $requestedFloor = $nextFloors[0];
    //             } else {
    //                 $elevatorDirection=1;
    //                 $nextFloors = array_filter(
    //                     $requestedQueuedFloors,
    //                     function ($value) use($currentFloor) {
    //                         return ($value > $currentFloor);
    //                     }
    //                 );
    //                 sort($nextFloors);
    //                 if(count($nextFloors) > 0) {
    //                     $requestedFloor = $nextFloors[0]; 
    //                 }
    //             }
    //         }

    //         update_elevatorNetwork($path, $user, $pass, $elevatorDirection, $currentFloor, $requestedFloor);

    //         $elevatorQueue = get_table_data($path, $user, $pass, $queue_tablename);

    //         foreach ( $elevatorQueue as $queueItem) {
    //          if($queueItem['newFloor']==$requestedFloor) {
    //              echo 'deleting';
    //              remove_elevatorQueue_by_id($path, $user, $pass, $queueItem['id']);
    //              break;
    //          }
    //         }
    //     }
        
       

    //     // Connect to database and make changes

    
    //    // if(isset($_POST['id'])) { $id = $_POST['id']; }
    //    // if(isset($_POST['newFloor'])) { $newFloor = $_POST['newFloor']; }

       
       

    // //    foreach ($rows as $row) {
    // //     echo $row['id'] . " | " . $row['newFloor'] . "<br>";
    // //     }


    //     // Display content of database
    //     showtable($path, $user, $pass, $tablename);
    //     show_network_table($path, $user, $pass, $tablename);
    
    // //}



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
			<form  action="elevatorControl1.php" method="POST">
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
						<button type="button" class="btn btn-danger s btn-lg" id= "stop" name="stop">STOP</button><br/><br/><br/>
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