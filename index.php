<?php

if(session_status() == PHP_SESSION_NONE)
	session_start();

$dbHost = "localhost";
$dbUser = "root";
$dbPass = "jackthegsd";
$dbName = "ca";
$index = true;

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if($conn->connect_error) {
	print("db connection failed: " . $conn->connection_error);
}

if(isset($_GET['logout'])) {
	unset($_SESSION['user']);
	$url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	header("location: /");
}

if(isset($_SESSION['user']))
	include('rate.php');
else
	include('login.php');

$conn->close();

?>