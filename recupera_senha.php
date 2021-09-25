<?php
	session_start();
	
	if (isSet($_POST['botao'])){
		$to = $_POST['email'];
		
	}
?>
<html>
<head>
   <title>Narrativas Interativas - Ferramenta</title>

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
			window.location.href = "setarCores.php?cor=vermelho&caminho=recupera_senha.php";
		}
		
		function setarAzul(){
			mudaAzul();
			window.location.href = "setarCores.php?cor=azul&caminho=recupera_senha.php";
		}
		
		function setarCinza(){
			mudaCinza();
			window.location.href = "setarCores.php?cor=cinza&caminho=recupera_senha.php";
		}
		
		function setarAmarelo(){
			mudaAmarelo();
			window.location.href = "setarCores.php?cor=amarelo&caminho=recupera_senha.php";
		}
		
		function setarVerde(){
			mudaVerde();
			window.location.href = "setarCores.php?cor=verde&caminho=recupera_senha.php";
		}
		
		window.onload = carregaItens;
	</script>
</head>
<body>
	<div class="units-row">
		<div id="cabecalho" class="unit-100">
			<a href = 'sair.php' class = 'link'><img src = 'icones/voltar.png'/></a>
		</div>
	</div>
	
	<div class="units-row" id = 'centro'>
		<div  class="unit-centered unit-40">
			<form method='post' action='recupera_senha.php' class='forms' id = 'form'>
			<fieldset>
				<legend>Prencha Todos os Campos Para Recuperar Sua Senha</legend>
				<label>
					<input type="text" name="login" placeholder="Email de Login" class="width-50" />
				</label>
				<label>
					<input type="password" name="email" placeholder="Email para Recuperar"class="width-50" />
				</label>
				<br>
				<button class="btn" name = 'botao' value = 'Entrar'>Recuperar</button>
				</fieldset>
			</form>
		</div>
	</div>
	
	<div class="units-row">
		<div id="rodape" class="unit-100">
			<div id = 'cores'> 
				<div class = 'cor color-red' onclick = 'setarVermelho()'></div>
				<div class = 'cor color-blue'onclick = 'setarAzul()'></div>
				<div class = 'cor color-yellow'onclick = 'setarAmarelo()'></div>
				<div class = 'cor color-green'onclick = 'setarVerde()'></div>
				<div class = 'cor color-gray'onclick = 'setarCinza()'></div>
			</div>
		</div>
	</div>
</body>
<?php
	if (! isSet($_SESSION["cor"])){
		echo '<script>mudaCinza()</script>';
	}else{
		if ($_SESSION['cor'] == 'vermelho'){
			echo '<script>mudaVermelho()</script>';
		}else if ($_SESSION['cor'] == 'azul'){
			echo '<script>mudaAzul()</script>';
		}else if ($_SESSION['cor'] == 'cinza'){
			echo '<script>mudaCinza()</script>';
		}else if ($_SESSION['cor'] == 'amarelo'){
			echo '<script>mudaAmarelo()</script>';
		}else if ($_SESSION['cor'] == 'verde'){
			echo '<script>mudaVerde()</script>';
		}
	}
?>
</html>