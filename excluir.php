<?php
	session_start();
	if(!empty($_POST)){
		if (isSet($_POST["excluir"])){
			include_once 'ControleUsuario.class.php';
			include_once 'ControleNarracao.class.php';
			
			$controleNarracao = new ControleNarracao();
			$narrativas = $controleNarracao->listarComUsuario($_SESSION["id"]);
			foreach ($narrativas as $narrativa){
				if ($narrativa->getCompartilhada() == 1){
					$narrativa->setIdUsuario(0);
					$controleNarracao->alterar($narrativa);
				}
			}
			
			$controle = new ControleUsuario();
			if ($_SESSION["id"] != 0){
				$controle->excluir(new Usuario($_SESSION["id"],"",""));
			}
			
			header("location: sair.php");
		}if (isSet($_POST["cancelar"])){
			header("location: editar_usuario.php");
		}
		
		
	}
?>
<html>
	<head>
	   <title>INASH - Excluir Usuário</title>

		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<link rel="stylesheet" href="css/kube.min.css" />
		<link rel="stylesheet" href="css/estilo.css" />    
		<link rel="stylesheet" href="css/cores.css" />    
		<script src="js/kube.min.js"></script>
		<script src="js/muda_cores.js"></script>
		<script>
		function setarVermelho(){
			mudaVermelho();
			window.location.href = "setarCores.php?cor=vermelho&caminho=excluir.php";
		}
		
		function setarAzul(){
			mudaAzul();
			window.location.href = "setarCores.php?cor=azul&caminho=excluir.php";
		}
		
		function setarCinza(){
			mudaCinza();
			window.location.href = "setarCores.php?cor=cinza&caminho=excluir.php";
		}
		
		function setarAmarelo(){
			mudaAmarelo();
			window.location.href = "setarCores.php?cor=amarelo&caminho=excluir.php";
		}
		
		function setarVerde(){
			mudaVerde();
			window.location.href = "setarCores.php?cor=verde&caminho=excluir.php";
		}
		
		function setarLaranja(){
			mudaLaranja();
			window.location.href = "setarCores.php?cor=laranja&caminho=excluir.php";
		}
		
		window.onload = carregaItens;
	</script>
	</head>
	<body>
		<div class="units-row end">
			<div id="cabecalho" class="unit-100">
				<h1 id = 'logo'>INASH</h1>
				<a href = 'sair.php' class = 'link'>Sair</a>
			</div>
		</div>
		
		<div id="centro" class="units-row end units-split">
			<div id="perfil" class="unit-20">
				<img id = 'icone' src ='http://cdns2.freepik.com/fotos-gratis/_318-34042.jpg'/><br>
				<h5 style = 'margin-top : 20px;'><?php echo $_SESSION["nome"]; ?></h5>
				<h5 style = 'margin-top : 20px;'><?php echo $_SESSION["email"]; ?></h5>
			</div>
			<div id="conteudo" class="unit-80">
				<div class="unit-centered unit-40">
					<form method = 'post' action = 'excluir.php' class = 'forms' style = 'margin-top : 100px;'>
						<fieldset>
						<label>
							<div class="unit-centered unit-80">
								<h5>Você tem certeza que deseja excluir sua conta</h5>
							</div>															<!--Esses divs são para deixar centralizado, estava dando um bug-->
							<div class="unit-centered unit-35">
								<h5> permanentemente ?</h5>
							</div>
						</label>
						<br>
						<div class="units-row units-split">
							<div class="unit-50"><button style = 'border-radius : 0px;'class="btn btn-blue width-100" name = 'excluir'>OK</button></div>
							<div class="unit-50"><button style = 'border-radius : 0px;'class="btn width-100" name = 'cancelar'>Cancelar</button></div>
						</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
		
		<div class="units-row end">
			<div id="rodape" class="unit-100">
				<?php include_once "partes/rodape.php" ?>
			</div>
		</div>
	</body>
	</html>
	<?php
		include_once "partes/verifica_cores.php";
	?>