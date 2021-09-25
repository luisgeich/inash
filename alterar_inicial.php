<?php
	session_start();
	include_once "ControleCapitulo.class.php";
	$controle = new ControleCapitulo();
	$capitulos = $controle->listarTodos();
	$capitulo_atual;
	foreach ($capitulos as $capitulo){
		if ($capitulo->getId() == $_SESSION["idCap"]){
			$capitulo_atual = $capitulo;
		}
	}
	if ($_GET["inicial"] == 1){
		$c = new Capitulo($capitulo_atual->getId(),$capitulo_atual->getTitulo(),$capitulo_atual->getConteudo(),$capitulo_atual->getIdNarracao(),1);
		$controle->alterar($c);
	}else if ($_GET["inicial"] == 0){
		$c = new Capitulo($capitulo_atual->getId(),$capitulo_atual->getTitulo(),$capitulo_atual->getConteudo(),$capitulo_atual->getIdNarracao(),0);
		$controle->alterar($c);
	}
	header("location: capitulo.php");
?>