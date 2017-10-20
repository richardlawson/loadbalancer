<?php
session_start();

$name = 'world';
if(isset($_SESSION['user_name'])){
	$name = $_SESSION['user_name'];
}

?>
<html>
<head>
	<title>Load Balancer</title>
</head>
<body>
	<p>Hello <?php echo $name ?>!</p>
	<p><a href="set-name.php">Set my name</a>
</body>
</html>