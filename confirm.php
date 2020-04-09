<?php
session_start();
if (!isset($_SESSION['posted'])) {
	header('location: input.php');
	exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>確認画面</title>
</head>
<body>
<h1>お問い合わせ内容</h1>
<p>この内容で送信しますか？</p>
<p>お名前</p>
<?php echo $_SESSION['posted']['last_name'] . $_SESSION['posted']['first_name']; ?>
<p>フリガナ</p>
<?php echo $_SESSION['posted']['last_name_furigana'] . $_SESSION['posted']['first_name_furigana']; ?>
<p>電話番号</p>
<?php echo $_SESSION['posted']['tell']; ?>
<p>メールアドレス</p>
<?php echo $_SESSION['posted']['email']; ?>
<p>お問い合わせ内容</p>
<?php echo $_SESSION['posted']['content']; ?>
<form action="thanks.php" method="POST">
<input type="hidden" name="last_name" value="<?php echo htmlspecialchars($_SESSION['posted']['last_name']); ?>">
<input type="hidden" name="first_name" value="<?php echo htmlspecialchars($_SESSION['posted']['first_name']); ?>">
<input type="hidden" name="last_name_furigana" value="<?php echo htmlspecialchars($_SESSION['posted']['last_name_furigana']); ?>">
<input type="hidden" name="first_name_furigana" value="<?php echo htmlspecialchars($_SESSION['posted']['first_name_furigana']); ?>">
<input type="hidden" name="tell" value="<?php echo htmlspecialchars($_SESSION['posted']['tell']); ?>">
<input type="hidden" name="email" value="<?php echo htmlspecialchars($_SESSION['posted']['email']); ?>">
<input type="hidden" name="content" value="<?php echo htmlspecialchars($_SESSION['posted']['content']); ?>">
<a href="input.php">戻る</a>
<input type="submit">
</form>
</body>
</html>
