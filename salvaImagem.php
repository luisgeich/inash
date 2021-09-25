<?php
	session_start();
	include_once "ControleUsuario.class.php";
	include_once "Usuario.class.php"; 
	
	if (! isSet($_SESSION['senha'])){
		header("location: login.php");
	}
	
	$controle = new ControleUsuario();
	$usuarios = $controle->listarTodos(); 
	$usuario_atual;
	
	foreach ($usuarios as $usuario){
		if ($usuario->getId() == $_SESSION['id']){
			$usuario_atual = $usuario;
		}
	}
	
	$nao_imagem = false;
	
	if (isSet($_POST["Enviar"])){
		if(preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $_FILES["arquivo"]["type"])){ //Verifica se é imagem
			$diretorio = "imagens/";
			$caminho = $diretorio.$_FILES["arquivo"]["name"];
			$arquivo = $_FILES["arquivo"]["tmp_name"];
			move_uploaded_file($arquivo, $caminho);
			$usuario_atual->setImagem($_FILES["arquivo"]["name"]);
			$_SESSION['imagem'] = $_FILES["arquivo"]["name"];
			$controle->alterar($usuario_atual);
		}else{
			$nao_imagem = true;
		}
	}else if (isSet($_POST['Excluir'])){
		$usuario_atual->setImagem(null);
		$_SESSION['imagem'] = null;
		$controle->alterar($usuario_atual);
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
			window.location.href = "setarCores.php?cor=vermelho&caminho=salvaImagem.php";
		}
		
		function setarAzul(){
			mudaAzul();
			window.location.href = "setarCores.php?cor=azul&caminho=salvaImagem.php";
		}
		
		function setarCinza(){
			mudaCinza();
			window.location.href = "setarCores.php?cor=cinza&caminho=salvaImagem.php";
		}
		
		function setarAmarelo(){
			mudaAmarelo();
			window.location.href = "setarCores.php?cor=amarelo&caminho=salvaImagem.php";
		}
		
		function setarVerde(){
			mudaVerde();
			window.location.href = "setarCores.php?cor=verde&caminho=salvaImagem.php";
		}
		
		function setarLaranja(){
			mudaLaranja();
			window.location.href = "setarCores.php?cor=laranja&caminho=salvaImagem.php";
		}
		
		window.onload = inicia;
	</script>
  </head>
</head>
<body>
	<div class="units-row end">
		<div id="cabecalho" class="unit-100">
			<h1 id = 'logo'>INASH</h1>
			<a href = 'sair.php' class = 'link'><img src = 'https://cdn1.iconfinder.com/data/icons/customicondesign-mini-deepcolour-png/48/Login_out.png'/></a>
		</div>
	</div>
	
	<div id="centro" class="units-row end units-split">
		<div id="perfil" class="unit-20">
			<?php
				if ($_SESSION['imagem'] == null){
					echo "<img id = 'icone' src ='http://cdns2.freepik.com/fotos-gratis/_318-34042.jpg'/><br>";
				}else{
					echo "<img id = 'icone' src = 'imagens/".$_SESSION['imagem']."'/><br>";
				}
				
			?>
			<h5 style = 'margin-top : 20px;'><?php echo $_SESSION["nome"]; ?></h5>
			<h5 style = 'margin-top : 20px;'><?php echo $_SESSION["email"]; ?></h5>
		</div>
		<div id="conteudo" class="unit-80">
			<br><br>
			<h1 id = 'texto'> Escolha uma nova foto</h1>
			<form action = 'salvaImagem.php' enctype="multipart/form-data" method="post">
				Arquivo: <input name="arquivo" type="file" /><br><br><br><br><br>
				<?php
					if ($nao_imagem){
						echo "<h6 class = 'aviso'>Formato não suportado</h6>";
					}
				?>
				<button class = 'btn' name = "Enviar" type="submit" value="Enviar" >Enviar</button>
				<button class = 'btn' name = "Excluir" type="submit" value="Excluir" >Excluir</button>
				
				<br>
			</form>
		</div>
	</div>
	
	<div class="units-row end">
		<div id="rodape" class="unit-100">
			<a href = 'ferramenta.php' class = 'link' style = 'margin-top : 10px;'><img style = 'margin-top : -15px;' src = 'https://cdn0.iconfinder.com/data/icons/typicons-2/24/arrow-back-48.png'/></a>
			<?php include_once "partes/rodape.php" ?>
		</div>
	</div>
</body>
</html>
<?php
include_once "partes/verifica_cores.php";
?>
