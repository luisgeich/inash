<?php
	session_start();
	if (! isSet($_SESSION["nome"])){
		header("location: index.php");
	}else{
		?>
		<html>
			<head>
			   <title>INASH - Cadastro Completo</title>

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
						window.location.href = "setarCores.php?cor=vermelho&caminho=cadastro_completo.php";
					}
					
					function setarAzul(){
						mudaAzul();
						window.location.href = "setarCores.php?cor=azul&caminho=cadastro_completo.php";
					}
					
					function setarCinza(){
						mudaCinza();
						window.location.href = "setarCores.php?cor=cinza&caminho=cadastro_completo.php";
					}
					
					function setarAmarelo(){
						mudaAmarelo();
						window.location.href = "setarCores.php?cor=amarelo&caminho=cadastro_completo.php";
					}
					
					function setarVerde(){
						mudaVerde();
						window.location.href = "setarCores.php?cor=verde&caminho=cadastro_completo.php";
					}
					
					function setarLaranja(){
						mudaLaranja();
						window.location.href = "setarCores.php?cor=laranja&caminho=cadastro_completo.php";
					}
					
					window.onload = carregaItens;
				</script>
				
				<style>
					.link_login{
						margin-top : 0px;
						margin-bottom : 0px;
						color : black;
						text-decoration : none;
						margin-left : 0px;
						text-align : center;
						font-weight : bold;
						
					}
					
					.link_login:hover{
						color : gray;
					}
				</style>
			</head>
			<body>
				<div class="units-row end">
					<div id="cabecalho" class="unit-100">
						<h1 id = 'logo'>INASH</h1>
						<a href = 'login.php' class = 'link'><img src = 'https://cdn1.iconfinder.com/data/icons/customicondesign-mini-deepcolour-png/48/Login_in.png'/></a>
					</div>
				</div>
				<br><br>
				<div class="unit-centered unit-40">
					<div class = "unit-100" id = "centro" style = 'margin-top : 100px;'>
						<h1 style = 'color:green; margin-top : 200px;'><?php echo $_SESSION["nome"]?>, seu cadastro foi efetuado com sucesso</h1>
						<p>Faça <a class = 'link_login' href = 'login.php'>login</a> para continuar</p>
					</div>
				</div>
				<div id="rodape" class="unit-100">
					<a href = 'sair.php' class = 'link'><img style = 'margin-top : -10px;' src = 'https://cdn0.iconfinder.com/data/icons/typicons-2/24/arrow-back-48.png'/></a>
					<?php include_once "partes/rodape.php" ?>
				</div>
			</body>
		</html>
	<?php
	}
	include_once "partes/verifica_cores.php";
?>
