<?php
session_start();
if(!isset($_SESSION["senha"])){
	header("location: sair.php");
}else{
	if (! isSet($_GET['caminho'])){
		header("location: inicio.php");
	}else{
		header("location: ".$_GET['caminho']);
	}
}
?>