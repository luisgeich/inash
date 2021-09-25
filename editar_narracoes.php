<?php
	session_start();
	include_once "ControleNarracao.class.php";
	include_once "ControleAvaliacao.class.php";
	
	if (! isSet($_SESSION['senha'])){
		header("location: login.php");
	}
	
	$controle = new ControleNarracao();
	$controleAvaliacao = new ControleAvaliacao();
	$narracoes = $controle->listarComUsuario($_SESSION["id"]);
	if (! empty ($_POST)){
		if (isSet($_POST["excluir"])){
			foreach($narracoes as $narracao){
				if (isSet($_POST["".$narracao->getId().""])){
					$avaliacoes = $controleAvaliacao->listarComNarracao($narracao->getId());
					if ($avaliacoes != 'vazio'){
						foreach($avaliacoes as $avaliacao){
							$controleAvaliacao->excluir($avaliacao);
						}
					}
					
					$controle->excluir($narracao);
				}
			}
			header("location: ferramenta.php");
		}		
	}
?>
<html>
<head>
   <title>INASH - Excluir Narrações</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="css/kube.min.css" />
    <link rel="stylesheet" href="css/cores.css" />
	<link rel="stylesheet" href="css/estilo.css" />    
	<script src="js/kube.min.js"></script>
	<script src="js/muda_cores.js"></script>
	<script>
		function verifica(){
			var elems = document.f1.elements;
			
			var marcados = 0;
			for(var i=0; i<elems.length; i++) {
				if (elems[i].checked){
					marcados ++;
				}
			}
			
			if (marcados == elems.length){
				document.getElementById("todos").checked = true;
			}
			if (marcados < elems.length){
				document.getElementById("todos").checked = false;
			}
			
		}
		
		function verifica_todos(){
			var elems = document.f1.elements;
			if (document.getElementById("todos").checked){
				for(var i=0; i<elems.length; i++) {
					elems[i].checked = true;
				}
			}else{
				for(var i=0; i<elems.length; i++) {
					elems[i].checked = false;
				}
			}
		}
		
		function setarVermelho(){
			mudaVermelho();
			window.location.href = "setarCores.php?cor=vermelho&caminho=editar_narracoes.php";
		}
		
		function setarAzul(){
			mudaAzul();
			window.location.href = "setarCores.php?cor=azul&caminho=editar_narracoes.php";
		}
		
		function setarCinza(){
			mudaCinza();
			window.location.href = "setarCores.php?cor=cinza&caminho=editar_narracoes.php";
		}
		
		function setarAmarelo(){
			mudaAmarelo();
			window.location.href = "setarCores.php?cor=amarelo&caminho=editar_narracoes.php";
		}
		
		function setarVerde(){
			mudaVerde();
			window.location.href = "setarCores.php?cor=verde&caminho=editar_narracoes.php";
		}
		
		function setarLaranja(){
			mudaLaranja();
			window.location.href = "setarCores.php?cor=laranja&caminho=editar_narracoes.php";
		}
		
		window.onload = carregaItens;
	</script>
	
</head>
<?php
	
	if (isSet($_SESSION["nome"])){
		?>
		<body>
			<div class="units-row end">
				<div id="cabecalho" class="unit-100">
					<h1 id = 'logo'>INASH</h1>
					<a href = 'sair.php' class = 'link'><img src = 'icones/sair.png'/></a>
				</div>
			</div>
			
			<div id="centro" class="units-row end units-split">
				<div id="perfil" class="unit-20">
					<?php
						if ($_SESSION['imagem'] == null){
							echo "<img id = 'icone' src ='icones/foto_padrao.png'/><br>";
						}else{
							echo "<img id = 'icone' src = 'imagens/".$_SESSION['imagem']."'/><br>";
						}
						
					?>
					<h5 style = 'margin-top : 20px;'><?php echo $_SESSION["nome"]; ?></h5>
					<h5 style = 'margin-top : 20px;'><?php echo $_SESSION["email"]; ?></h5>
				</div>
				<div id="conteudo" class="unit-80">
					<fieldset style = 'padding-bottom : 19%; margin-top : 5%;'><legend>Selecione as narrativas que deseja excluir</legend>
					<ul class="forms-list">
					<li>
						<input type='checkbox' onclick = "verifica_todos()" name="todos" id="todos">
						<label for="todos">Todos</label></li>
					</li>
					<form method = "POST" name = 'f1' action = "editar_narracoes.php" class = "forms" style = 'height : 32%; overflow : auto; position : absolute; float : left; width : 50%;'>
						<?php
							include_once 'ControleNarracao.class.php';
							$controle = new ControleNarracao();
							$idUsuario = $_SESSION["id"];
							$narracoes = $controle->listarComUsuario($idUsuario);
							foreach ($narracoes as $narracao){
								echo "<li>
										<input type='checkbox' onclick = 'verifica()' class = 'check' name=".$narracao->getId()." id=".$narracao->getId().">
										<label for=".$narracao->getId().">".$narracao->getTitulo()."</label></li>";
							}
						?>
						</ul>
						<button class="btn" id = 'excluir' value = 'excluir' name = 'excluir' style = 'position : fixed; left : 55%; bottom : 100px;'>Excluir</button>
					</form>
					</fieldset>
				</div>
			</div>
			<div class="units-row end">
				<div id="rodape" class="unit-100">
					<a href = 'ferramenta.php' class = 'link' style = 'margin-top : 10px;'><img style = 'margin-top : -15px;' src = 'icones/voltar.png'/></a>
					<?php include_once "partes/rodape.php" ?>
				</div>
			</div>
		</body>
		<?php
	}else{
		header("location: login.php");
	}
	include_once "partes/verifica_cores.php";
?>


</html>