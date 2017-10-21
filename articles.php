<?php require_once './config.php';
try {
	
	$conn = new PDO("mysql:host=" . Config::DB_HOST . ";dbname=" . Config::DB_NAME, Config::DB_USERNAME, Config::DB_PASSWORD);
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		saveArticle($conn, $_POST);
	}
	$articles = getArticles($conn);
	
}catch(PDOException $e){
		echo "Error: " . $e->getMessage();
		exit;
}

function saveArticle($conn, $params){
	$params = sanitize($params);
	$statement = $conn->prepare("INSERT INTO articles(title, summary, body) VALUES(:title, :summary, :body)");
	$statement->execute(array(
			"title" => $params['title'],
			"summary" => $params['summary'],
			"body" => $params['body']
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
	<?php foreach($articles as $article): ?>
	<h1><?php echo $article['title'] ?></h1>
	<p><?php echo $article['summary'] ?></p>
	<?php endforeach ?>
	<h2>Add Article</h2>
	<form method="post" action="">
	<label>Title</label>
	<input type="text" name="title" required><br>
	<label>Summary</label>
	<textarea name="summary" required></textarea>
	<br>
	<label>Body</label>
	<textarea name="body" required></textarea>
	<input type="submit">
	<br>
</body>
</html>