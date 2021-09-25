<?php
	session_start();
	include_once "ControleNarracao.class.php";
	
	$controle = new ControleNarracao();
	$narrativas = $controle->listarTodos();
	if (isSet($_SESSION["idNarracao"])){
		$id = $_SESSION["idNarracao"];
	}else{
		$id = $_GET["narracao"];
	}
	
	$narrativa_atual;
	foreach ($narrativas as $narrativa){
		if ($narrativa->getId() == $id){
			$narrativa_atual = $narrativa;
		}
	}
	
	if (! isSet($_SESSION['senha'])){
		header("location: login.php");
	}
	
	if (isSet($_POST['salvar'])){
		$narrativa_atual->setSinopse($_POST["editor1"]);
		$controle->alterar($narrativa_atual);
	}
	
	if (isSet($_POST['salvar_generos'])){
		$narrativa_atual->setGeneros($_POST['genero1'], $_POST['genero2']);
		$controle->alterar($narrativa_atual);
	}
?>
<html>
<head>
   <title>INASH - Editar Gêneros/Sinopse</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="css/kube.min.css" />
	<link rel="stylesheet" href="css/estilo.css" />    
	<link rel="stylesheet" href="css/cores.css" />    
	<script src="js/kube.min.js"></script>
	<script src="js/muda_cores.js"></script>
	<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
	<script type="text/javascript">
		window.onload = function() {
			CKEDITOR.replace( 'editor1', {enterMode: Number(2)} )
		}
	  
		function setarVermelho(){
			mudaVermelho();
			window.location.href = "setarCores.php?cor=vermelho&caminho=editar_narrativa.php";
		}
		
		function setarAzul(){
			mudaAzul();
			window.location.href = "setarCores.php?cor=azul&caminho=editar_narrativa.php";
		}
		
		function setarCinza(){
			mudaCinza();
			window.location.href = "setarCores.php?cor=cinza&caminho=editar_narrativa.php";
		}
		
		function setarAmarelo(){
			mudaAmarelo();
			window.location.href = "setarCores.php?cor=amarelo&caminho=editar_narrativa.php";
		}
		
		function setarVerde(){
			mudaVerde();
			window.location.href = "setarCores.php?cor=verde&caminho=editar_narrativa.php";
		}
		
		function setarLaranja(){
			mudaLaranja();
			window.location.href = "setarCores.php?cor=laranja&caminho=editar_narrativa.php";
		}
		
    </script>   
  </head>
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
			<img id = 'icone' src ='icones/livro_aberto.png'/><br>
			<br>
			<h3 id = 'titulo_narracao' onclick = 'acao()'>
			<?php
				echo $narrativa_atual->getTitulo();
			?>
			</h3>
			<h4 style = 'margin-top : 15%;'>Gêneros : </h4>
			<form method = "POST" action = 'editar_narrativa.php'>
			<select name = 'genero1' style = 'background-color : rgba(255,255,255,0.5); border : 1px solid rgba(0,0,0,0.5)'>
			<?php
				$generos = array("---","Ação", "Aventura", "Comédia", "Drama", "Espionagem", "Fantasia", "F. Científica" , "Romance", "Suspense", "Terror");
				foreach ($generos as $genero){
					if ($narrativa_atual->getGeneros()[0] == $genero){
						echo "<option value='".$genero."' selected>".$genero."</option>";
					}else{
						echo "<option value='".$genero."' >".$genero."</option>";
					}
				}
			?>
			</select> 
			<select name = 'genero2' style = 'background-color : rgba(255,255,255,0.5); border : 1px solid rgba(0,0,0,0.5)'>
			<?php
				$generos = array("---","Ação", "Aventura", "Comédia", "Drama", "Espionagem", "Fantasia", "F. Científica" , "Romance", "Suspense", "Terror");
				foreach ($generos as $genero){
					if ($narrativa_atual->getGeneros()[1] == $genero){
						echo "<option value='".$genero."' selected>".$genero."</option>";
					}else{
						echo "<option value='".$genero."' >".$genero."</option>";
					}
				}
			 ?>
			 </select> 
			 <button class="btn" style = "margin-top : 15%;" name = 'salvar_generos' value = 'salvar_generos' >Salvar</button>
			</form>
		</div>
		
		<div id="conteudo" class="unit-80">
			<form method = 'post' action = 'editar_narrativa.php'>
				<textarea cols="2" maxlength = "100" id="editor1" name="editor1" onkeydown = 'verifica();'>
					<?php 
						 echo $narrativa_atual->getSinopse();
					?>
				</textarea>
				<p id = 'aviso' style = 'position : absolute; float : left; margin-left : 10px;'>* Tamanho máximo de 1000 caracteres (char)</p>
				<button class="btn" style = 'margin : auto; margin-top : 4%; position : relative;' name = 'salvar' value = 'salvar' style = 'position : fixed; bottom : 100px;'>Salvar</button>
			</form>
		</div>
		
	</div>
	</div>
</body>
	<div class="units-row end">
		<div id="rodape" class="unit-100">
			<a href = 'narrativa.php' class = 'link' style = 'margin-top : 10px;'><img style = 'margin-top : -15px;' src = 'icones/voltar.png'/></a>
			<?php include_once "partes/rodape.php" ?>
		</div>
	
</html>
<?php
	include_once "partes/verifica_cores.php";
?>