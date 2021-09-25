<?php
	session_start();
	include_once 'ControleCapitulo.class.php';
	include_once 'ControleNarracao.class.php';
	$controle = new ControleCapitulo();
	$capitulos = $controle->listarComNarracao($_SESSION['idNarracao']);
	$elems = $_GET['elems'];
	$link = $_GET['link'];
	$zoom = $_GET['zoom'];
	
	echo $zoom;
	
	if ($elems != 'redefinir'){
		$elems_array = explode("[",$elems);
		foreach ($elems_array as $caps){
			$capitulo_array = explode("|",$caps);
			foreach ($capitulos as $capitulo){
				if ($capitulo->getId() == $capitulo_array[0]){
					$capitulo->setPosX($capitulo_array[1]);
					$capitulo->setPosY($capitulo_array[2]);
					$controle->alterar($capitulo);
				}
			}
		}
	}else{
		foreach ($capitulos as $capitulo){
			$capitulo->setPosX(null);
			$capitulo->setPosY(null);
			echo $capitulo->getPosX();
			$controle->alterar($capitulo);
		}
	}
	
	if ($zoom < -3){
		$zoom = -3;
	}else if($zoom > 3){
		$zoom = 3;
	}
	
	$controle = new ControleNarracao();
	$narrativa = $controle->listarUm($_SESSION['idNarracao']);
	$narrativa->setZoom($zoom);
	$controle->alterar($narrativa);
	
	if ($link != null){
		if (! isSet($_GET['caminho'])){
			header("location:". $link."");
		}else{
			header("location:". $link."&caminho=".$_GET["caminho"]."");
		}
		
	}
?>