<?php
	include_once 'ControleUsuario.class.php';
	
	if(isset($_POST) && $_POST["botao"] == "Entrar"){
		$controle = new ControleUsuario();
		$usuarios = $controle->listarTodos();
		
		$login  = $_POST["login"];
		$senha  = $_POST["senha"];
		$encontrou = false;
		foreach ($usuarios as $usuario){
			
			if ($login == $usuario->getEmail() && $senha == $usuario->getSenha()){
				session_start();
				$_SESSION["id"] = $usuario->getId();
				$_SESSION["nome"] = $usuario->getNome();
				$_SESSION["senha"] = $usuario->getSenha();
				$_SESSION["email"] = $usuario->getEmail();
				$_SESSION["imagem"] = $usuario->getImagem();
				$encontrou = true;
				
				if (isSet($_SESSION['nao_encontrou'])){
					unset($_SESSION['nao_encontrou']);
				}
				
				if (! isSet($_GET['caminho'])){
					header("location: restrita.php");
				}else{
					header("location: restrita.php?caminho=".$_GET['caminho']);
				}
				
			}
		}
		
		if (! $encontrou){
			session_start();
			session_unset();
			$_SESSION["nao_encontrou"] = true;
			header("location: login.php");
		}
	}else{
		header("location: sair.php");
	}
?>