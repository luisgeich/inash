<?php
	session_start();
	
	if (! isSet($_SESSION["senha"])){
		header("location: login.php?caminho=ferramenta.php");
	}
	
	unset($_SESSION["nao_compartilhou"]);
	
	if (isSet($_SESSION["idNarracao"])){
		unset($_SESSION["idNarracao"]);
	}
	if (! empty($_POST)){
		if (isSet($_POST["salvar"])){
			include_once 'ControleNarracao.class.php';
			$controle = new ControleNarracao();
			$idUsuario = $_SESSION["id"];
			$titulo = $_POST["titulo"];
			$narracao = new Narracao("",$titulo,$idUsuario,$_SESSION['nome']);
			$controle->inserir($narracao);
		}
	}
?>
<html>
<head>
   <title>INASH - Ferramenta</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="css/kube.min.css" />
	<link rel="stylesheet" href="css/estilo.css" />    
	<link rel="stylesheet" href="css/cores.css" />    
	<link rel="stylesheet" href="css/telas.css" />    
	<script src="js/kube.min.js"></script>
	<script src="js/muda_cores.js"></script>
	<script>
		function mostrarTela(){
			document.getElementById('adiciona_narrativa').style.display = 'block';
			document.getElementById('titulo').value = "";
		}
		
		function ocultarTela(){
			document.getElementById('adiciona_narrativa').style.display = 'none';
			document.getElementById('titulo').value = "";
		}
		
		function apaga(){
			document.getElementById('salvo').style.visibility = 'hidden';
		}
		
		function setarVermelho(){
			mudaVermelho();
			window.location.href = "setarCores.php?cor=vermelho&caminho=ferramenta.php";
		}
		
		function setarAzul(){
			mudaAzul();
			window.location.href = "setarCores.php?cor=azul&caminho=ferramenta.php";
		}
		
		function setarCinza(){
			mudaCinza();
			window.location.href = "setarCores.php?cor=cinza&caminho=ferramenta.php";
		}
		
		function setarAmarelo(){
			mudaAmarelo();
			window.location.href = "setarCores.php?cor=amarelo&caminho=ferramenta.php";
		}
		
		function setarVerde(){
			mudaVerde();
			window.location.href = "setarCores.php?cor=verde&caminho=ferramenta.php";
		}
		
		function setarLaranja(){
			mudaLaranja();
			window.location.href = "setarCores.php?cor=laranja&caminho=ferramenta.php";
		}
		
		window.onload = setTimeout(apaga,5000);
	</script>
	
	
</head>

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
					echo "<a href = 'salvaImagem.php'><img id = 'icone' src ='icones/foto_padrao.png'/></a><br>";
				}else{
					echo "<a href = 'salvaImagem.php'><img id = 'icone' src = 'imagens/".$_SESSION['imagem']."'/></a><br>";
				}
			?>
			
			<h6 id = 'salvo' style = 'margin-top : 3%; color : green;'>
				<?php 
					if (isSet($_SESSION["salvo"])){
						echo "Informações salvas com sucesso";
					}
				?>
			</h6>
			<h5 style = 'margin-top : 10%;'><?php echo $_SESSION["nome"]; ?></h5>
			<h5 style = 'margin-top : 5%;'><?php echo $_SESSION["email"]; ?></h5>
			<a class="btn" href = 'editar_usuario.php' style = 'position : relative; margin : auto; margin-top : 40%;'>Editar</a>
		</div>
		<div id="conteudo" class="unit-80" style = "overflow : hidden;">
			<div id = 'adicionar' style = 'margin-right : 5%; margin-top : -5%;'><br><br><br><img style = "cursor: pointer" title = 'Adicionar Nova Narração' onclick = 'mostrarTela()' src = 'icones/add.png'/></div>
			<h3 style = 'margin-top : 5%; width : 100%;'>Escolha uma narrativa</h3>
			<div style = 'height : 40%; overflow : auto; position : absolute; width : 75%;'>
				<br>
				<form method = 'get' action = 'narrativa.php'>
				<?php
					include_once 'ControleNarracao.class.php';
					$controle = new ControleNarracao();
					$idUsuario = $_SESSION["id"];
					$narracoes = $controle->listarComUsuario($idUsuario);
					foreach ($narracoes as $narracao){
						echo "<button style = 'width : 20%; font-size : 100%; margin-bottom : 1.5%;' class = 'narracao' name = 'narracao' value=".$narracao->getId()."><img src = 'icones/livro_fechado_pequeno.png' style = 'margin-right : 2%;'>".$narracao->getTitulo()."</button><br>";
					}
				?>
				</form>
				</div>
				<a href = 'editar_narracoes.php' style = 'position : absolute; margin : 1%; bottom : 12.5%; left : 20%'><img style = 'height : 50px; width : 50px;' src = 'icones/lixeira.png'/></a>
			
		</div>
	</div>
	
	<div id = 'adiciona_narrativa'>
		<form action="ferramenta.php" method="POST">
			<fieldset>
			<label>
				<div class="unit-centered unit-80">
					<h5>Insira o titulo da narrativa:</h5>
					<input type="text" name="titulo" class = 'unit-100 unit-centered' />
				</div>
			</label>
			<br>
			<div class="units-row units-split">
				<div class="unit-50"><button style = 'border-radius : 0px;'class="btn btn-blue width-100" value = 'salvar' name = 'salvar'>Salvar</button></div>
				<div class="unit-50"><button style = 'border-radius : 0px;'class="btn width-100">Cancelar</button></div>
			</div>
			</fieldset>
		</form>
	</div>
	
	<div class="units-row end">
		<div id="rodape" class="unit-100">
		<a href = 'inicio.php' class = 'link' style = 'margin-top : 1%;'><img style = 'margin-top : -40%;' src = 'icones/voltar.png'/></a>
			<?php include_once "partes/rodape.php" ?>
	</div>
</body>
<?php
	include_once "partes/verifica_cores.php";
?>
</html>