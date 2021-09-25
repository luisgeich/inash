
<?php
	session_start();
	if (isSet($_GET)){
		echo $_GET['cor'];
		if ($_GET['cor'] == 'vermelho'){
			$_SESSION['cor'] = 'vermelho';
		}else if($_GET['cor'] == 'azul'){
			$_SESSION['cor'] = 'azul';
		}else if($_GET['cor'] == 'cinza'){
			$_SESSION['cor'] = 'cinza';
		}else if($_GET['cor'] == 'amarelo'){
			$_SESSION['cor'] = 'amarelo';
		}else if($_GET['cor'] == 'verde'){
			$_SESSION['cor'] = 'verde';
		}else if($_GET['cor'] == 'laranja'){
			$_SESSION['cor'] = 'laranja';
		}
	}
	if (isSet($_GET['capitulo'])){
		$caminho = $_GET['caminho']."&capitulo=".$_GET['capitulo'];
	}else{
		$caminho = $_GET['caminho'];
	}
	header("location: ".$caminho);
	
	
?>