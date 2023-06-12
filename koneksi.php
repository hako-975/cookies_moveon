<?php 
	session_start();
	
	$host = 'localhost';
	$user = 'root';
	$pass = '';
	$db   = 'cookies_moveon';

	$koneksi = mysqli_connect($host, $user, $pass, $db);
?>