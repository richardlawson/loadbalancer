<?php require_once './config.php';
try {
	$errors = [];
	$conn = new PDO("mysql:host=" . Config::DB_HOST . ";dbname=" . Config::DB_NAME, Config::DB_USERNAME, Config::DB_PASSWORD);
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$filename = savePhoto($errors);
		if(empty($errors)){
			saveArticle($conn, $_POST, $filename);
		}
	}
	$articles = getArticles($conn);
	
}catch(PDOException $e){
		echo "Error: " . $e->getMessage();
		exit;
}

function savePhoto(&$errors){
	$filename = "";
	if($_FILES['photo']['name']){
		if(!$_FILES['photo']['error'])
		{
			$valid_file = true;
			
			//now is the time to modify the future file name and validate the file
			$new_file_name = $_FILES['photo']['name']; //rename file
			$filename = $new_file_name;
			if($_FILES['photo']['size'] > (1024000)) //can't be larger than 1 MB
			{
				$valid_file = false;
				$errors[] = 'Oops!  Your file\'s size is to large.';
			}
	
			//if the file has passed the test
			if($valid_file){
				//move it to where we want it to be
				move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/'.$new_file_name);
				$message = 'Congratulations!  Your file was accepted.';
				$filename = $new_file_name;
			}
		}
		//if there is an error...
		else{
			//set that to be the returned message
			$message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['photo']['error'];
		}
	}
	return $filename;
	
}

function saveArticle($conn, $params, $photo){
	$params = sanitize($params);
	$statement = $conn->prepare("INSERT INTO articles(title, summary, body, photo) VALUES(:title, :summary, :body, :photo)");
	$statement->execute(array(
			"title" => $params['title'],
			"summary" => $params['summary'],
			"body" => $params['body'],
			"photo" => $photo
	));
}

function sanitize($params){
	$sanitizedParams = [];
	foreach($params as $key => $value){
		$sanitizedParams[$key] = strip_tags($value);
	}
	return $sanitizedParams;
}

function getArticles($conn){
	$stmt = $conn->prepare("SELECT * FROM articles ORDER BY id DESC");
	$stmt->execute();
	$articles = $stmt->fetchAll();
	return $articles;
}
?>
<html>
<head>
	<title>Articles</title>
</head>
<body>
	<p><a href="index.php">Home</a></p>
	<?php if(!empty($errors)):?>
		<p>Could not save article because of errors:</p>
		<ul>
		<?php foreach($errors as $error): ?>
			<li><?php echo $error ?></li>
		<?php endforeach ?>
	<?php endif ?>
	<?php foreach($articles as $article): ?>
		<h1><?php echo $article['title'] ?></h1>
		<p><?php echo $article['summary'] ?></p>
		<?php if($article['photo'] != ''):?>
		<img src="uploads/<?php echo $article['photo'] ?>" width="75" height="75">
		<?php endif ?>
	<?php endforeach ?>
	<h2>Add Article</h2>
	<form method="post" action="" enctype="multipart/form-data">
	<label>Title</label>
	<input type="text" name="title" required><br>
	<label>Image</label>
	<input type="file" name="photo"><br>
	<label>Summary</label>
	<textarea name="summary" required></textarea>
	<br>
	<label>Body</label>
	<textarea name="body" required></textarea>
	<input type="submit">
	<br>
</body>
</html>