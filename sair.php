<?php
	session_start();
	$cor = $_SESSION['cor'];
	session_unset();
	$_SESSION['cor'] = $cor;
	header("location: index.php");
?>