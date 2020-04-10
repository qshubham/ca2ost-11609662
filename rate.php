<?php

if(!isset($index))
	header('redirect: /');

$sql = "select id, name from movies;";
$res = $conn->query($sql);
$movie = null;

function show_movie() {
	global $conn;
	$ret = null;
	
	$sql = "select * from movies where id=" . $_POST['movie'];
	$m_res = $conn->query($sql);
	while($row = $m_res->fetch_assoc()) {
		$ret = $row;
	}
	return $ret;
}

function rate_movie() {
	global $conn;
	$sql = "update movies set avg_rate = (avg_rate + " . $_POST['rate'] . ") / (no_rate + 1), no_rate = no_rate + 1 where id = ". $_POST['movie'];
	if(!$conn->query($sql)) {
		die("Error updating movies ". $conn->error);
	}
}

if(isset($_POST['movie_rate'])) {
	rate_movie();
	$movie = show_movie();
}

if(isset($_POST['movie_select'])) {
	$movie = show_movie();
}
?>

<html>

<head>
	<title>Welcome <?php echo $_SESSION['user'] ?></title>
</head>

<body>
<a href="?logout=1">logout</a>
<form method="post">
	select movie:
	<select name="movie">
		<?php while($row = $res->fetch_assoc()) { ?>
		<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
		<?php } ?>
	</select>
	<input type="submit" name="movie_select" />
</form>

<?php if($movie != null) { ?>

<p>Name: <?php echo $movie['name'] ?></p>
<p>Avg Rate: <?php echo round($movie['avg_rate'], 2) ?></p>
<p>No. Ratings: <?php echo $movie['no_rate'] ?></p>
<form method="post">
<input type='hidden' name='movie' value = "<?php echo $movie['id'] ?>" />
your rating: 
<select name="rate">
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>
	<option value="5">5</option>
</select>
<input type="submit" name="movie_rate" />
</form>
<?php } ?>

</body>

</html>
