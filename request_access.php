<?php 
$submitted = !empty($_POST); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requrest_access</title>
</head>
<body>
    <p>Form submited? <?php echo (int) $submitted; ?></p>
    <p>Here is ur info summary</p>
    <ul>
        <li>First name: <?php echo $_POST['firstname'] ?></li>
        <li>Last name: <?php echo $_POST['lastname'] ?></li>
        <li>Email: <?php echo $_POST['email'] ?></li>
        <li>Birthdate: <?php echo $_POST['birthday'] ?></li>
        <li>Website: <?php echo $_POST['url'] ?></li>
        <li>Faculty or student: <?php echo $_POST['fac_or_student'] ?></li>
        <li>Contribution: <?php echo $_POST['involvement[]'] ?></li>
        <li>Do u drive: <?php echo $_POST['driver'] ?></li>
        <li>Other details: <?php echo $_POST['details'] ?></li>
    </ul>
</body>
</html>