<?php

if(!isset($index))
	header('redirect: /');

$msg = '';

function login() {
	global $conn;
	global $msg;
	//var_dump($conn);
	$sql = "select 1 from users where user = '" . $_POST['user'] . "' and pass = '" . $_POST['pass'] . "';";
	$res = $conn->query($sql);

	if ($res->num_rows > 0) {
		$_SESSION['user'] = $_POST['user'];
		header("location: /");
	} else {
		$msg = 'invalid username and password';
	}
}

function register() {
	global $conn;
	global $msg;
	$sql = "select 1 from users where user = '" . $_POST['user'] . "'";
	$res = $conn->query($sql);
	if($res->num_rows > 0) {
		$msg = 'Username already exists';
	} else {
		$sql = "insert into users values('". $_POST['user'] . "', '". $_POST['pass'] ."')";
		if($conn->query($sql) === FALSE) {
			die('Couldnt insert values' . $conn->error);
		} else {
			$msg = "registration successful";
		}
	}
}

if(isset($_POST['login']))
	login();

if(isset($_POST['register']))
	register();

?>

<html>
	<head>
		<title>Login</title>
	</head>
	<body>
	<h1>Login:</h1>
		<form method="post">
			Username: <input name="user" /><br>
			Password: <input name="pass" /><br>
			<input type="submit" name="login" value="login" />
			<input type="submit" name="register" value="register" />
			<?php if($msg != '') { ?>
			<p><?php echo $msg ?></p>
			<?php } ?>
		</form>
	</body>
</html>