<?php
	session_start();
	
?>
<html>
<head>
   <title>INASH - Inicio</title>

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
			window.location.href = "setarCores.php?cor=vermelho&caminho=inicio.php";
		}
		
		function setarAzul(){
			mudaAzul();
			window.location.href = "setarCores.php?cor=azul&caminho=inicio.php";
		}
		
		function setarCinza(){
			mudaCinza();
			window.location.href = "setarCores.php?cor=cinza&caminho=inicio.php";
		}
		
		function setarAmarelo(){
			mudaAmarelo();
			window.location.href = "setarCores.php?cor=amarelo&caminho=inicio.php";
		}
		
		function setarVerde(){
			mudaVerde();
			window.location.href = "setarCores.php?cor=verde&caminho=inicio.php";
		}
		
		function setarLaranja(){
			mudaLaranja();
			window.location.href = "setarCores.php?cor=laranja&caminho=inicio.php";
		}
		
		window.onload = setTimeout(apaga,5000);
	</script>
	
	
</head>

<body>
	<div class="units-row end">
		<div id="cabecalho" class="unit-100">
			<h1 id = 'logo'>INASH</h1>
			<?php
				if (isSet($_SESSION['senha'])){
					echo "<a href = 'sair.php' class = 'link'><img src = 'icones/sair.png'/></a>";
				}else{
					echo "<a href = 'login.php' class = 'link'><img src = 'icones/login.png'/></a>";
				}
			?>
		</div>
	</div>
	
	<div id="centro" class="units-row end units-split">
		<div id="perfil" class="unit-20">
			<?php
				if (! isSet($_SESSION['imagem'])){
					echo "<a href = 'salvaImagem.php'><img id = 'icone' src ='icones/foto_padrao.png'/></a><br>";
				}else{
					if ($_SESSION['imagem'] == null){
						echo "<a href = 'salvaImagem.php'><img id = 'icone' src ='icones/foto_padrao.png'/></a><br>";
					}else{
						echo "<a href = 'salvaImagem.php'><img id = 'icone' src = 'imagens/".$_SESSION['imagem']."'/></a><br>";
					}
					
				}
			?>
			<h5 style = 'margin-top : 10%;'><?php if (isSet($_SESSION["nome"])){echo $_SESSION["nome"];}else{echo "Usuário não autenticado";} ?></h5>
			<h5 style = 'margin-top : 5%;'><?php if (isSet($_SESSION["email"])){echo $_SESSION["email"];}?></h5>
			<?php
				if (isSet($_SESSION["email"])){
					echo "<a class='btn' href = 'editar_usuario.php' style = 'position : relative; margin : auto; margin-top : 40%;'>Editar</a>";
				}
			?>
			
		</div>
		<div id="conteudo" class="unit-80">
			<br><br>
			<h2>Escolha um modo para usar a ferramenta !</h2>
			<br><br><br><br>
			<div class = 'opcao'>
				<a href = 'ferramenta.php'><img src = 'icones/lapis.png'></a>
				<br><br>
				<span>Escrita</span>
			</div>
			
			<div class = 'opcao'>
				<a href = 'leitura.php'><img src = 'icones/oculos.png'></a>
				<br><br>
				<span>Leitura</span>
			</div>
			
		</div>
	</div>
	
	<div class="units-row end">
		<div id="rodape" class="unit-100">
			<?php include_once "partes/rodape.php" ?>
		</div>
	</div>
</body>
<?php
	include_once "partes/verifica_cores.php";
?>


</html>