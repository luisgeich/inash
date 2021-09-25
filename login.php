<?php
	session_start();
?>
<html>
<head>
   <title>INASH - Login</title>

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
			window.location.href = "setarCores.php?cor=vermelho&caminho=login.php";
		}
		
		function setarAzul(){
			mudaAzul();
			window.location.href = "setarCores.php?cor=azul&caminho=login.php";
		}
		
		function setarCinza(){
			mudaCinza();
			window.location.href = "setarCores.php?cor=cinza&caminho=login.php";
		}
		
		function setarAmarelo(){
			mudaAmarelo();
			window.location.href = "setarCores.php?cor=amarelo&caminho=login.php";
		}
		
		function setarVerde(){
			mudaVerde();
			window.location.href = "setarCores.php?cor=verde&caminho=login.php";
		}
		
		function setarLaranja(){
			mudaLaranja();
			window.location.href = "setarCores.php?cor=laranja&caminho=login.php";
		}
		
		function mostraErro(){
			document.getElementById('nao_encontrou').style.visibility = 'visible';
		}
		
		window.onload = carregaItens;
	</script>
</head>
<body>
	<div class="units-row">
		<div id="cabecalho" class="unit-100">
			<h1 id = 'logo'>INASH</h1>
			<a href = 'sair.php' class = 'link'><img src = 'icones/voltar.png'/></a>
		</div>
	</div>
	
	<div class="units-row" id = 'centro'>
		<div  class="unit-centered unit-40">
			<?php
				if (! isSet($_GET['caminho'])){
					echo "<form method='post' action='verifica.php' class='forms' id = 'form'>";
				}else{
					echo "<form method='post' action='verifica.php?caminho=".$_GET['caminho']."' class='forms' id = 'form'>";
				}
				
			?>
			<fieldset>
				<legend>Prencha todos os campos para efetuar login</legend>
				<label>
					<input type="text" name="login" placeholder="Email" class="width-50" />
				</label>
				<label>
					<input type="password" name="senha" placeholder="Senha" class="width-50" />
				</label>
				<p class = 'link_login'><a href = '#'>Esqueceu sua senha?</a></p>
				<p class = 'link_login'><a href = 'cadastro.php'>Não possui cadastro?</a></p>
				<p class = 'link_login' id = 'nao_encontrou' style = 'margin-bottom : 10px; color : red; visibility : hidden'>Login ou senha incorretos</p>
				<button class="btn" name = 'botao' value = 'Entrar'>Log in</button>
				</fieldset>
			</form>
		</div>
	</div>
	
	<div class="units-row">
		<div id="rodape" class="unit-100">
			<?php include_once "partes/rodape.php" ?>
		</div>
	</div>
</body>
<?php
	include_once "partes/verifica_cores.php";
?>
</html>

<?php
		if (isSet($_SESSION['nao_encontrou'])){
			echo "<script>mostraErro();</script>";
		}
	?>