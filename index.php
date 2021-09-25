<?php
	session_start();
	include_once "ControleAvaliacao.class.php";
	include_once "ControleNarracao.class.php";
	
	$controle = new ControleAvaliacao();
	
	$maximo = $controle->listarMaximo();
	$n1 = $controle->listarMelhor($maximo);
	
	$maximo = $controle->listarMaximo($n1);
	$n2 = $controle->listarMelhor($maximo);
	
	while ($n1 == $n2){
		$n2 = $controle->listarMelhor($maximo, $n1);
	}
	
	$maximo = $controle->listarMaximo($n2, $n1);
	$n3 = $controle->listarMelhor($maximo);
	
	while ($n2 == $n3 or $n1 == $n3){
		$n3 = $controle->listarMelhor($maximo, $n2, $n1);
	}
	
?>
<html>
<head>
   <title>INASH</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="css/kube.min.css" />
	<link rel="stylesheet" href="css/estilo.css" />    
	<link rel="stylesheet" href="css/cores.css" />    
	<style>
		.balao_esquerda{
			z-index: 100;
			position : absolute;
			margin-left : 9.5%;
			padding : 1%;
			border-radius : 10px;
			display : none;
			opacity : 0;
		}

	</style>
	<script src="js/kube.min.js"></script>
	<script src="js/muda_cores.js"></script>
	<script>
		function setarVermelho(){
			mudaVermelho();
			window.location.href = "setarCores.php?cor=vermelho&caminho=index.php";
		}
		
		function setarAzul(){
			mudaAzul();
			window.location.href = "setarCores.php?cor=azul&caminho=index.php";
		}
		
		function setarCinza(){
			mudaCinza();
			window.location.href = "setarCores.php?cor=cinza&caminho=index.php";
		}
		
		function setarAmarelo(){
			mudaAmarelo();
			window.location.href = "setarCores.php?cor=amarelo&caminho=index.php";
		}
		
		function setarVerde(){
			mudaVerde();
			window.location.href = "setarCores.php?cor=verde&caminho=index.php";
		}
		
		function setarLaranja(){
			mudaLaranja();
			window.location.href = "setarCores.php?cor=laranja&caminho=index.php";
		}
		
		window.onload = carregaItens;
	</script>
</head>
<body>
	<div class="units-row end">
		<div id="cabecalho" class="unit-100">
			<h1 id = 'logo'>INASH</h1>
			<a href = 'login.php' class = 'link'><img src = 'icones/login.png'/></a>
			<a href = 'cadastro.php' class = 'link'><img src = 'icones/cadastro.png'/></a>
		</div>
	</div>
	
	<div class="units-row end">
		<div class = "unit-50" id = "centro">
			<h1>INASH</h1>
			<br>
			<div id = 'texto_corrido'>
				<h5 class = 'texto_corrido'>INASH desenvolvida como um <a title = 'link para a página do projeto' href = "#">projeto</a> de pesquisa, auxilia tanto escritores profissionais e amadores quanto desentereçados pela leitura e escrita à criar e compartilhar suas narrativas, através de um prático e interativo sistema de grafos.</h5>
				<h5 class = 'texto_corrido'>Suas histórias contarão com um poderoso recurso que permitirá aos leitores interfirirem no futuro da trama, ao paço que você escolhe opções que eles terão.</h5>
				<h5 class = 'texto_corrido'>INASH permite também que você leia as narrativas compartilhadas por todos os usuários.</h5>
			</div>
		</div>
		<div class = 'unit-50' id = 'centro'>
			<h2>Tenha uma prévia de nossas narrativas :</h2><br>
			<?php
				$controle = new ControleNarracao();
				$narrativa1 = $controle->listarUm($n1);
				$narrativa2 = $controle->listarUm($n2);
				$narrativa3 = $controle->listarUm($n3);
				
				$narrativas = array($narrativa1, $narrativa2, $narrativa3);
				foreach($narrativas as $narrativa){
					echo "<div class = 'imagem-sinopse'>";
					echo "<img src = 'icones/livro_fechado.png'><br>";
					if ($narrativa->getSinopse() != "" && $narrativa->getSinopse() != " "){	
						$valor_height = (5 * (strlen($narrativa->getSinopse()) - 230))/170;
						$valor_width = (3 * (strlen($narrativa->getSinopse()) - 230))/170;
						$width = 20 + $valor_width;
						$height = 21 + $valor_height;
						$posY = -1 * (((2 * (strlen($narrativa->getSinopse()) - 230))/170) + 14);
						echo "<div class = 'balao_esquerda' style = 'width : ".$width."%; height : ".$height."%;margin-top : ".$posY."%;'><p>".$narrativa->getSinopse()."</p></div>";
					}else{
						echo "<div class = 'balao_esquerda' style = 'width : 14.2%; height : 15.2%; margin-left : 13%; margin-top : -11.7%;'><p>Sinopse não liberada pelo autor</p></div>";
					}
					echo "</div>"; 
					echo "<a class='narracao' style = 'text-decoration : none;' href = 'ler.php?narrativa=".$narrativa->getId()."&capitulo=inicial&caminho=index.php'>".$narrativa->getTitulo()."<br><span> por: ".$narrativa->getAutor()."</span></a><br><br>";
				}
			
			?>
		</div>
		<div class = "unit-50" ></div>
	</div>
	<div id="rodape" class="unit-100">
		<?php include_once "partes/rodape.php" ?>
	</div>
</body>
</html>
<?php
	include_once "partes/verifica_cores.php";
?>