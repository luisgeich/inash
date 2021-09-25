<?php
	session_start();
	include_once "ControleCapitulo.class.php";
	
	unset($_SESSION["nao_compartilhou"]);
	
	if (! isSet($_SESSION['senha'])){
		header("location: login.php");
	}
	
	if (! isSet($_SESSION['idCap']) && ! isSet($_GET["capitulo"])){
		header("location: ferramenta.php");
	}
	
	if (isSet($_GET["capitulo"])){
		$_SESSION["idCap"] = $_GET["capitulo"];
	}
	
	$idCap = $_SESSION["idCap"];
	if (! empty($_POST)){
		if (isSet($_POST['botao'])){
			salvarCap();
		}
	}
	
	if (! empty($_GET)){
		if(isSet($_GET["salvar_titulo"])){
			include_once "ControleCapitulo.class.php";
			$controle = new ControleCapitulo();
			$capitulos = $controle->listarTodos();
			$capitulo_atual;
			foreach ($capitulos as $capitulo){
				if ($capitulo->getId() == $idCap){
					$capitulo_atual = $capitulo;
				}
			}
			$capitulo_atual->setTitulo($_GET["novo_titulo"]);
			$controle->alterar($capitulo_atual);
			
		}
	}
	
	function encontraAtual($idCap){
		$controle = new ControleCapitulo();
		$capitulos = $controle->listarTodos();
		$capitulo_atual;
		foreach ($capitulos as $capitulo){
			if ($capitulo->getId() == $idCap){
				$capitulo_atual = $capitulo;
			}
		}
		return $capitulo_atual;
	}
	
	function salvarCap(){
		$idCap = $_SESSION["idCap"];
		$capitulo_atual = encontraAtual($idCap);
		$capitulo_atual->setConteudo($_POST["editor1"]);
		$controle = new ControleCapitulo();
		$controle->alterar($capitulo_atual);
	}
	
	
?>
<html>
<head>
   <?php
		$capitulo_atual = encontraAtual($idCap);
		echo "<title>INASH - ".$capitulo_atual->getTitulo()."</title>";
   ?>
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
        CKEDITOR.replace( 'editor1', {enterMode: Number(2)} );
	
      };
	  
	  var eTexto = true;
		function acao(){
			if (eTexto){
				document.getElementById('salvar_titulo').style.visibility = 'visible';
				document.getElementById('titulo_capitulo').innerHTML = "<input type= 'text' style = 'text-align : center;' name = 'novo_titulo' value = '<?php
				include_once "ControleCapitulo.class.php";
				$controle = new ControleCapitulo();
				$capitulos = $controle->listarTodos();
				$capitulo_atual;
				foreach ($capitulos as $capitulo){
					if ($capitulo->getId() == $idCap){
						$capitulo_atual = $capitulo;
					}
				}
				echo $capitulo_atual->getTitulo();
			?>'>";
				eTexto = false;
			}
			
		}
		
		function marca(){
			if (document.getElementById('inicial').checked){
				window.location.href = "alterar_inicial.php?inicial=1";
			}else{
				window.location.href = "alterar_inicial.php?inicial=0";
			}
		}
		
		function setarVermelho(){
			mudaVermelho();
			window.location.href = "setarCores.php?cor=vermelho&caminho=capitulo.php";
		}
		
		function setarAzul(){
			mudaAzul();
			window.location.href = "setarCores.php?cor=azul&caminho=capitulo.php";
		}
		
		function setarCinza(){
			mudaCinza();
			window.location.href = "setarCores.php?cor=cinza&caminho=capitulo.php";
		}
		
		function setarAmarelo(){
			mudaAmarelo();
			window.location.href = "setarCores.php?cor=amarelo&caminho=capitulo.php";
		}
		
		function setarVerde(){
			mudaVerde();
			window.location.href = "setarCores.php?cor=verde&caminho=capitulo.php";
		}
		
		function setarLaranja(){
			mudaLaranja();
			window.location.href = "setarCores.php?cor=laranja&caminho=capitulo.php";
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
			<br>
			<br>
			<br>
			<form method = 'GET' action = 'capitulo.php'>
				<h3  style="cursor: pointer" id = 'titulo_capitulo' onclick = 'acao()'>Capítulo : 
					<?php
						include_once "ControleCapitulo.class.php";
						$controle = new ControleCapitulo();
						$capitulos = $controle->listarTodos();
						$capitulo_atual;
						foreach ($capitulos as $capitulo){
							if ($capitulo->getId() == $idCap){
								$capitulo_atual = $capitulo;
							}
						}
						echo $capitulo_atual->getTitulo();
					?>
				</h3>
				<button class="btn" id = 'salvar_titulo' value = 'salvar_titulo' name = 'salvar_titulo' style = 'visibility : hidden';>Salvar</button>
			</form>
			<h3>Capítulos Anteriores</h3>
			<?php
				include_once "ControleLink.class.php";
				$controle = new ControleLink();
				$ids = $controle->listarAnteriores($capitulo_atual->getId());
				$controleCap = new ControleCapitulo();
				$capitulos = $controleCap->listarTodos();
				$jaUsados = array();
				foreach($capitulos as $capitulo){
					foreach($ids as $id){
						if($id == $capitulo->getId() && ! in_array($id, $jaUsados)){
							echo "<a style = 'text-decoration : none;'class = 'capitulo' href = 'capitulo.php?capitulo=".$id."' >".$capitulo->getTitulo()."</a><br>";
							$jaUsados[] = $id;
						}
					}
				}
			?>
			<br>
			<h3>Próximos Capítulos</h3>
			<?php
				include_once "ControleLink.class.php";
				$controle = new ControleLink();
				$ids = $controle->listarProximos($capitulo_atual->getId());
				$controleCap = new ControleCapitulo();
				$capitulos = $controleCap->listarTodos();
				$jaUsados = array();
				foreach($capitulos as $capitulo){
					foreach($ids as $id){
						if($id == $capitulo->getId() && ! in_array($id, $jaUsados)){
							echo "<a style = 'text-decoration : none;'class = 'capitulo' href = 'capitulo.php?capitulo=".$id."' >".$capitulo->getTitulo()."</a><br>";
							$jaUsados[] = $id;
						}
					}
				}
			?>
			<br>
			<br>
			<br><input type='checkbox' onclick = 'marca()' class = 'check' name="inicial" id="inicial">
			<label for="inicial">Capítulo Inicial</label>
			
		</div>
		
		
		
		<div id="conteudo" class="unit-80">
			<form method = 'post' action = 'capitulo.php'>
				<textarea cols="2" maxlength = "100" id="editor1" name="editor1">
					<?php 
						 $capitulo_atual = encontraAtual($idCap);
						echo $capitulo_atual->getConteudo();
					?>
				</textarea>
			
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
	$capitulo_atual = encontraAtual($idCap);
	if ($capitulo_atual->getInicial() == 1){
		echo "<script>document.getElementById('inicial').checked = true</script>";
	}else{
		echo "<script>document.getElementById('inicial').checked = false</script>";
	}
	include_once "partes/verifica_cores.php";
?>