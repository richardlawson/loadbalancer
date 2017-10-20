<?php
session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
	$name = strip_tags($_POST['user_name']);
	$_SESSION['user_name'] = $name;
}

$name = 'friend';
if(isset($_SESSION['user_name'])){
	$name = $_SESSION['user_name'];
}

?>
<html>
<head>
	<title>Load Balancer</title>
</head>
<body>
	<p>Hello <?php echo $name ?>. You can change your username on this page</p>
	<p>
		<form action="" method="post">
			<label>
			Username
			<label>
			<input type="text" name="user_name" placeholder="enter your name here...">
			<br>
			<input type="submit" value="submit">
		</form>
	</p>
	<p><a href="index.php">Home</a></p>
</body>
</html>