<?php
$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);
if (empty($email) || empty($password)) {
	$msg =  "メールアドレスとパスワードを入力してください。";
} else {
	try {
		$dbh = new PDO ("mysql:host=localhost;dbname=conoha;charset=utf8", 'root', 'xxxxxxxxxx');
	} catch (PDOException $e) {
		echo $e->getMessage();
		exit();
	}	
		$sql = "SELECT * FROM admin WHERE email = :email AND password = :password";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':password', $password);
		$stmt->execute();
		$row = $stmt->fetch();
		if ($row) {
			$msg = "ログインしました。";
			$sql = "SELECT * FROM inquiries ORDER BY create_date DESC";
			$res = $dbh->query($sql);
		} else {
			$msg = "メールアドレスかパスワードが間違っています。";
		}
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>お問い合わせ管理</title>
<meta charset="utf-8">
</head>
<body>
<?php echo $msg; ?>
<table>
<?php foreach ($res as $value): ?>
<tr>
<th>お問い合わせid</th>
<td><?php echo $value['id']; ?></td>
</tr>
<tr>
<th>受信日時</th>
<td><?php echo $value['create_date']; ?></td>
</tr>
<tr>
<th>名前</th>
<td><?php echo $value['last_name'] . $value['first_name']; ?></td>
</tr>
<tr>
<th>フリガナ</th>
<td><?php echo $value['last_name_furigana'] . $value['first_name_furigana']; ?></td>
</tr>
<tr>
<th>電話</th>
<td><?php echo $value['tell']; ?></td>
</tr>
<tr>
<th>メールアドレス</th>
<td><?php echo $value['email']; ?></td>
</tr>
<tr>
<th>お問い合わせ内容</th>
<td><?php echo $value['content']; ?></td>
</tr>
<?php endforeach; ?>
</table>
<a href="adminlogin.php">ログイン画面に戻る</a>
</body>
</html>
