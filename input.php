<?php 
session_start(); 
$errors = array();
if (!empty($_POST['submit'])) {
	$last_name = htmlspecialchars($_POST['last_name']);
	$first_name = htmlspecialchars($_POST['first_name']);
	$last_name_furigana = htmlspecialchars($_POST['last_name_furigana']);
	$first_name_furigana = htmlspecialchars($_POST['first_name_furigana']);
	$tell = htmlspecialchars($_POST['tell']);
	$email = htmlspecialchars($_POST['email']);
	$email_confirm = htmlspecialchars($_POST['email_confirm']);
	$content = htmlspecialchars($_POST['content']);

	if (empty($last_name) || empty($first_name)) {
		$errors['name'] = "名前（姓名）を入力してください。";
	}
	if (empty($last_name_furigana) || empty($first_name_furigana)) {
		$errors['furigana'] = "フリガナ(セイメイ）を入力してください。";
	} elseif (!preg_match('/^[ァ-ヶー]+$/u', $last_name_furigana) || !preg_match('/^[ァ-ヶー]+$/u', $first_name_furigana)) {
		$errors['furigana'] = "フリガナは全角カナで入力してください。";
	}
	if (empty($tell)) {
		$errors['tell'] = "電話番号を入力してください。";
	} elseif (!preg_match('/[0-9]{9,11}/', $tell)) {
		$errors['tell'] = "電話番号は9~11桁の半角数字で入力してください。";
	}
	if (empty($email)) {
		$errors['email'] = "メールアドレスを入力してください。";
	}
	if (empty($email_confirm)) {
		$errors['email_confirm'] = "確認用メールアドレスを入力してください。";
	}
	if ($email !== $email_confirm) {
		$errors['email_error'] = "メールアドレスが一致していません。";
	}
	if (count($errors) === 0) {
		$_SESSION['posted'] = array(
			"last_name" => $last_name,
			"first_name" => $first_name,
			"last_name_furigana" => $last_name_furigana,
			"first_name_furigana" => $first_name_furigana,
			"tell" => $tell,
			"email" => $email,
			"email_confirm" => $email_confirm,
			"content" => $content,
		);
		header('location: confirm.php');
		exit();
	}
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>お問い合わせフォーム</title>
<style>
.errormsg {color:red;}
</style>
</head>
<body>
<h1>お問い合わせフォーム</h1>
<?php 
function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}
?>
<form action="" method="POST">
<p>名前
<label>姓</lebel><input type="text" name="last_name" value="<?php if (!empty($last_name)) { echo $last_name; } elseif (isset($_SESSION['posted']['last_name'])) { echo $_SESSION['posted']['last_name']; } ?>">
<label>名</label><input type ="text" name="first_name" value="<?php if (!empty($first_name)) { echo $first_name; } elseif (isset($_SESSION['posted']['first_name'])) { echo $_SESSION['posted']['first_name']; } ?>"><br>
<div class="errormsg"><?php if(!empty($errors['name'])) { echo $errors['name']; } ?></div>
</p>
<p>フリガナ
<label>セイ</lebel><input type="text" name="last_name_furigana" placeholder="全角カナ" value="<?php if (!empty($last_name_furigana)) { echo $last_name_furigana; } elseif (isset($_SESSION['posted']['last_name_furigana'])) { echo $_SESSION['posted']['last_name_furigana']; } ?>">
<label>メイ</label><input type ="text" name="first_name_furigana" value="<?php if (!empty($first_name_furigana)) { echo $first_name_furigana; } elseif (isset($_SESSION['posted']['first_name_furigana'])) { echo $_SESSION['posted']['first_name_furigana']; } ?>"><br>
<div class="errormsg"><?php if(!empty($errors['furigana'])) { echo $errors['furigana']; } ?></div>
</p>
<p><label>電話番号</label><input type="tel" name="tell" placeholder="9~11桁" value="<?php if (!empty($tell)) { echo $tell; } elseif (isset($_SESSION['posted']['tell'])) { echo $_SESSION['posted']['tell']; } ?>"></p>
<div class="errormsg"><?php if(!empty($errors['tell'])) { echo $errors['tell']; } ?></div>
<p><label>メールアドレス</label><input type="email" name="email" value="<?php if (!empty($email)) { echo $email; } elseif (isset($_SESSION['posted']['email'])) { echo $_SESSION['posted']['email']; } ?>"></p>
<div class="errormsg"><?php if(!empty($errors['email'])) { echo $errors['email']; } ?></div>
<p><label>確認用メールアドレス</label><input type="email" name="email_confirm" value="<?php if (!empty($email_confirm)) { echo $email_confirm; } elseif (isset($_SESSION['posted']['email_confirm'])) { echo $_SESSION['posted']['email_confirm']; } ?>"></p>
<div class="errormsg"><?php if(!empty($errors['email_confirm'])) { echo $errors['email_confirm']; } ?></div>
<div class="errormsg"><?php if(!empty($errors['email_error'])) { echo $errors['email_error']; } ?></div>
<p><label>お問い合わせ内容</label><br><textarea name="content" rows="4" cols="40"><?php if (!empty($content)) { echo $content; } elseif (isset($_SESSION['posted']['content'])) { echo $_SESSION['posted']['content']; } ?></textarea></p>
<input type="submit" name="submit" value="確認画面へ">
</form>
</body>
</html>
