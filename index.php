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
	<p><a href="set-name.php">Set my Name</a></p>
	<p><a href="articles.php">View articles</a></p>
	<p><a href="contact.php">Contact Us</a></p>
	<p>Server ip: <?php echo $_SERVER['SERVER_ADDR'];?></p>
</body>
</html>