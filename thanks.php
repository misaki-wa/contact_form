<?php
session_start();
if (empty($_POST)) {
	header('location: input.php');
	exit();
}

try {
	$dbh = new PDO ("mysql:host=localhost;dbname=conoha;charset=utf8", 'root', 'xxxxxxxx');
} catch (PDOException $e) {
	echo $e->getMessage();
	exit();
}
$stmt = $dbh->prepare('INSERT INTO inquiries (last_name, first_name, last_name_furigana, first_name_furigana, tell, email, content, create_date) 
VALUES (:last_name, :first_name, :last_name_furigana, :first_name_furigana, :tell, :email, :content, :create_date)');
$stmt->bindParam(':last_name', $_POST['last_name']);
$stmt->bindParam(':first_name', $_POST['first_name']);
$stmt->bindParam(':last_name_furigana', $_POST['last_name_furigana']);
$stmt->bindParam(':first_name_furigana', $_POST['first_name_furigana']);
$stmt->bindParam(':tell', $_POST['tell']);
$stmt->bindParam(':email', $_POST['email']);
$stmt->bindParam(':content', $_POST['content']);
$stmt->bindParam(':create_date', date('Y/m/d H:i:s'));
$_SESSION = array();
session_destroy();
?>
<!DOCTYPE html>
<html lang="ja">
<?php if ($stmt->execute()) :?>
<head>
<title>送信完了</title>
</head>
<body>
<p>お問い合わせありがとうございました。</p>
<?php var_dump($_POST); ?>
<?php else :?>
<head>
<title>送信エラー</title>
</head>
<body>
<p>エラーです。</p>
<?php endif; ?>
<a href="input.php">お問い合わせフォームへ</a>
</body>
</html>
