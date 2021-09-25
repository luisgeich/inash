<?php
	session_start();
	include_once "ControleNarracao.class.php";
	
	
	if (isSet($_GET["pagina"])){
		$_SESSION['pagina'] = $_GET["pagina"];
	}
	
	if (isSet($_SESSION['pagina'])){
		$pagina = $_SESSION['pagina'];
	}else{
		$pagina = 1;
	}
	
	$controle = new ControleNarracao();
	$narrativas = $controle->listarCompartilhadas();
	$compartilhadas = "";
	
	if (isSet($_GET['ids'])){
		$_SESSION['ids'] = $_GET['ids'];
		if (isSet($_GET["pesquisa"])){
			header("location: leitura.php?pagina=".$pagina."&pesquisa=".$_GET["pesquisa"]);
		}else{
			header("location: leitura.php?pagina=".$pagina);
		}
	}
	
	if (! isSet($_SESSION['ids']) || isSet($_GET['reordenar'])){
		if (isSet($_GET['pesquisa'])){
			if (isSet($_GET['genero1'])){
				$genero1 = $_GET['genero1'];
				$genero2 = $_GET['genero2'];
				if ($genero1 != "---" && $genero2 != "---"){
					if ($genero1 != $genero2){
						$narrativas = $controle->listarComPesquisa($_GET['pesquisa'], 'dois generos', $genero1, $genero2);
					}else{
						$narrativas = $controle->listarComPesquisa($_GET['pesquisa'], 'um genero', $genero1);
					}
				}else if($genero1 != "---" || $genero2 != "---"){
					if ($genero1 == "---"){
						$narrativas = $controle->listarComPesquisa($_GET['pesquisa'], 'um genero', $genero2);
					}else if($genero2 == "---"){
						$narrativas = $controle->listarComPesquisa($_GET['pesquisa'], 'um genero', $genero1);
					}
				}else{
					$narrativas = $controle->listarComPesquisa($_GET['pesquisa'], 'sem genero');
				}
			}else{
				$narrativas = $controle->listarComPesquisa($_GET['pesquisa'], 'sem genero');
			}
		}else{
			$narrativas = $controle->listarCompartilhadas();
		}
		shuffle($narrativas);
		foreach ($narrativas as $narrativa){
			$compartilhadas = $compartilhadas.$narrativa->getId()."|";	
		}
		
		if (isSet($_GET['reordenar'])){
			unset($_SESSION['ids']);
		}
	}else{
		$compartilhadas = $_SESSION['ids'];
		$compartilhadas_array = explode("|",$compartilhadas);
		$narrativas = array();
		$narrativas_em_ordem = $controle->listarCompartilhadas();
		
		foreach ($compartilhadas_array as $id){
			foreach ($narrativas_em_ordem as $narrativa){
				if ($id == $narrativa->getId()){
					array_push($narrativas,$narrativa);	
				}
			}
		}
	}
	
	$compartilhadas_num = count($narrativas);
	
	$adicionados_array = array();
?>
<html>
<head>
   <title>INASH - Leitura</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="css/kube.min.css" />
	<link rel="stylesheet" href="css/estilo.css" />    
	<link rel="stylesheet" href="css/cores.css" />    
	<script src="js/kube.js"></script>
	<script src="js/muda_cores.js"></script>
	<script>
		function setarVermelho(){
			mudaVermelho();
			window.location.href = "setarCores.php?cor=vermelho&caminho=leitura.php";
		}
		
		function setarAzul(){
			mudaAzul();
			window.location.href = "setarCores.php?cor=azul&caminho=leitura.php";
		}
		
		function setarCinza(){
			mudaCinza();
			window.location.href = "setarCores.php?cor=cinza&caminho=leitura.php";
		}
		
		function setarAmarelo(){
			mudaAmarelo();
			window.location.href = "setarCores.php?cor=amarelo&caminho=leitura.php";
		}
		
		function setarVerde(){
			mudaVerde();
			window.location.href = "setarCores.php?cor=verde&caminho=leitura.php";
		}
		
		function setarLaranja(){
			mudaLaranja();
			window.location.href = "setarCores.php?cor=laranja&caminho=leitura.php";
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
					echo "<a href = 'login.php?caminho=leitura.php' class = 'link'><img src = 'icones/login.png'/></a>";
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
			<?php
				if (! isSet($_GET['pesquisa'])){
					echo "<a href = 'leitura.php?reordenar=sim' style = 'position : absolute; margin-left : -39%;'><img title = 'Reordenar/Atualizar Narrativas' src = 'icones/redefinir.png'></a>";
				}else{
					echo "<a href = 'leitura.php?reordenar=sim&pesquisa=".$_GET['pesquisa']."&genero1=".$_GET['genero1']."&genero2=".$_GET['genero2']."' style = 'position : absolute; margin-left : -39%;'><img title = 'Reordenar/Atualizar Narrativas' src = 'icones/redefinir.png'></a>";
				}
			?>
			<div id = 'pesquisa' class="width-40">
				<form method="GET" action="" class="forms">
					<select name = 'genero1' style = 'margin-left : -105%; display : inline' class = 'genero'>
						<?php
							$generos = array("---","Ação", "Aventura", "Comédia", "Drama", "Espionagem", "Fantasia", "F. Científica" , "Romance", "Suspense", "Terror");
							foreach ($generos as $genero){
								if ($_GET['genero1'] == $genero){
									echo "<option value='".$genero."' selected>".$genero."</option>";
								}else{
									echo "<option value='".$genero."' >".$genero."</option>";
								}
							}
						?>
					</select> 
					<select name = 'genero2' style = 'margin-left : -50%; display : inline' class = 'genero'>
						<?php
							$generos = array("---","Ação", "Aventura", "Comédia", "Drama", "Espionagem", "Fantasia", "F. Científica" , "Romance", "Suspense", "Terror");
							foreach ($generos as $genero){
								if ($_GET['genero2'] == $genero){
									echo "<option value='".$genero."' selected>".$genero."</option>";
								}else{
									echo "<option value='".$genero."' >".$genero."</option>";
								}
							}
						?>
					</select> 
						<div style = 'width : 100%; margin-left : 0%; display : inline'>
							<input type="text" name="pesquisa" placeholder="Buscar narrativas por titulo ou autor" style = 'width : 80%; display : inline; height : 35px; 	border : 1px solid rgba(0,0,0,.5);' />
							<button class="btn" style = 'height : 35px;'> <img src = 'icones/lupa.png'> </button>
						</div>
				</form>
			</div>
			<br><br><br>
			<?php
				if($compartilhadas_num > 0){
					echo "<h2>Escolha uma narrativa para ler</h2>";
				}else{
					if (isSet($_GET['pesquisa'])){
						echo "<h2>Nenhum resultado para : ".$_GET['pesquisa']."</h2>";
					}
				}
			?>
		
			<div class = "unit-100"> 
				<div class = 'narrativas  unit-30'>
					<?php 
						$adicionados = ($pagina - 1) * 9;
						for ($i = $adicionados; $i <= count($narrativas); $i++){
							if ($adicionados < 3 + (($pagina - 1) * 9) && $adicionados < count($narrativas)){
								$narrativa = $narrativas[$i];
								if ($narrativa->getCompartilhada() == 1 ){
									echo "<div class = 'imagem-sinopse'>";
									echo "<img src = 'icones/livro_fechado.png'><br>";
									if ($narrativa->getSinopse() != "" && $narrativa->getSinopse() != " "){	
										$valor_height = (5 * (strlen($narrativa->getSinopse()) - 230))/170;
										$valor_width = (3 * (strlen($narrativa->getSinopse()) - 230))/170;
										$width = 20 + $valor_width;
										$height = 21 + $valor_height;
										$posY = -1 * (((2 * (strlen($narrativa->getSinopse()) - 230))/170) + 14);
										echo "<div class = 'balao' style = 'width : ".$width."%; height : ".$height."%; margin-top : ".$posY."%;'><p>".$narrativa->getSinopse()."</p></div>";
									}else{
										echo "<div class = 'balao' style = 'width : 14.2%; height : 15.2%; margin-top : -11.7%;'><p>Sinopse não liberada pelo autor</p></div>";
									}
									echo "</div>";
									if (isSet($_GET['pesquisa'])){
										echo "<a class='narracao' style = 'text-decoration : none;' href = 'ler.php?narrativa=".$narrativa->getId()."&capitulo=inicial&caminho=leitura.php?pesquisa=".$_GET['pesquisa']."&genero1=".$_GET['genero1']."&genero2=".$_GET['genero2']."'>".$narrativa->getTitulo()."<br><span> por: ".$narrativa->getAutor()."</span></a><br><br>";
									}else{
										echo "<a class='narracao' style = 'text-decoration : none;' href = 'ler.php?narrativa=".$narrativa->getId()."&capitulo=inicial&caminho=leitura.php'>".$narrativa->getTitulo()."<br><span> por: ".$narrativa->getAutor()."</span></a><br><br>";
									}
								
									$adicionados += 1;
								}
							}
						}
					?>
				</div>
				<div class = 'narrativas unit-40'>
					<?php 
						for ($i = $adicionados; $i <= count($narrativas); $i++){
							if ($adicionados < 6 + (($pagina - 1) * 9) && $adicionados < count($narrativas)){
								$narrativa = $narrativas[$i];
								if ($narrativa->getCompartilhada() == 1){
									echo "<div class = 'imagem-sinopse'>";
									echo "<img src = 'icones/livro_fechado.png'><br>";
									if ($narrativa->getSinopse() != "" && $narrativa->getSinopse() != " "){	
										$valor_height = (5 * (strlen($narrativa->getSinopse()) - 230))/170;
										$valor_width = (3 * (strlen($narrativa->getSinopse()) - 230))/170;
										$width = 20 + $valor_width;
										$height = 21 + $valor_height;
										$posY = -1 * (((2 * (strlen($narrativa->getSinopse()) - 230))/170) + 14);
										echo "<div class = 'balao' style = 'width : ".$width."%; height : ".$height."%; margin-top : ".$posY."%;margin-left : 13%;'><p>".$narrativa->getSinopse()."</p></div>";
									}else{
										echo "<div class = 'balao' style = 'width : 14.2%; height : 15.2%; margin-top : -11.7%; margin-left : 13%;'><p>Sinopse não liberada pelo autor</p></div>";
									}
									echo "</div>";
									if (isSet($_GET['pesquisa'])){
										echo "<a class='narracao' style = 'text-decoration : none;' href = 'ler.php?narrativa=".$narrativa->getId()."&capitulo=inicial&caminho=leitura.php?pesquisa=".$_GET['pesquisa']."&genero1=".$_GET['genero1']."&genero2=".$_GET['genero2']."'>".$narrativa->getTitulo()."<br><span> por: ".$narrativa->getAutor()."</span></a><br><br>";
									}else{
										echo "<a class='narracao' style = 'text-decoration : none;' href = 'ler.php?narrativa=".$narrativa->getId()."&capitulo=inicial&caminho=leitura.php'>".$narrativa->getTitulo()."<br><span> por: ".$narrativa->getAutor()."</span></a><br><br>";
									}
									$adicionados += 1;
								}
							}
						}
					?>
			</div>
			<div class = 'narrativas  unit-30'>
				<?php 
					for ($i = $adicionados; $i <= count($narrativas); $i++){
						if ($adicionados < 9 + (($pagina - 1) * 9) && $adicionados < count($narrativas)){
							$narrativa = $narrativas[$i];
							if ($narrativa->getCompartilhada() == 1){
								echo "<div class = 'imagem-sinopse'>";
								echo "<img src = 'icones/livro_fechado.png'><br>";
								if ($narrativa->getSinopse() != "" && $narrativa->getSinopse() != " "){	
									$valor_height = (5 * (strlen($narrativa->getSinopse()) - 230))/170;
									$valor_width = (3 * (strlen($narrativa->getSinopse()) - 230))/170;
									$width = 20 + $valor_width;
									$height = 21 + $valor_height;
									$posY = -1 * (((2 * (strlen($narrativa->getSinopse()) - 230))/170) + 14);
									$posX = 5.5 + ((3 * (strlen($narrativa->getSinopse()) - 230))/170);
									echo "<div class = 'balao_esquerda' style = 'width : ".$width."%; height : ".$height."%; margin-left : ". $posX * -1 ."%;margin-top : ".$posY."%;'><p>".$narrativa->getSinopse()."</p></div>";
								}else{
									echo "<div class = 'balao_esquerda' style = 'width : 14.2%; height : 15.2%; margin-top : -11.7%; margin-left : 0.7%;'><p>Sinopse não liberada pelo autor</p></div>";
								}
								echo "</div>"; 
								if (isSet($_GET['pesquisa'])){
										echo "<a class='narracao' style = 'text-decoration : none;' href = 'ler.php?narrativa=".$narrativa->getId()."&capitulo=inicial&caminho=leitura.php?pesquisa=".$_GET['pesquisa']."&genero1=".$_GET['genero1']."&genero2=".$_GET['genero2']."'>".$narrativa->getTitulo()."<br><span> por: ".$narrativa->getAutor()."</span></a><br><br>";
									}else{
										echo "<a class='narracao' style = 'text-decoration : none;' href = 'ler.php?narrativa=".$narrativa->getId()."&capitulo=inicial&caminho=leitura.php'>".$narrativa->getTitulo()."<br><span> por: ".$narrativa->getAutor()."</span></a><br><br>";
									}
								$adicionados += 1;
							}
						}
					}
				?>
			</div>
			<div style = 'position : absolute; bottom :9%; right : 2%;' >
				<?php
					$paginas_num = ceil(($compartilhadas_num)/9);

					if ($compartilhadas_num > 0){
						echo "<p style = 'display : inline-block; color: gray; font-weight : bold'>Pagina: </p>";
					}
					
					if ($pagina >= 4){
						$inicio = $pagina - 3;
					}else{
						$inicio = 1;
					}
					
					for ($i = $inicio; $i <= $pagina + 3; $i++){
						if ($i == $pagina){
							if($i <= $paginas_num){
								if (isSet($_GET['pesquisa'])){
									echo "<a class = 'pagina' style = 'color : black; margin-left : 5px;' href = leitura.php?ids=".$compartilhadas."&pagina=".$i."&pesquisa=".$_GET['pesquisa'].">".$i."</a>";
								}else{
									echo "<a class = 'pagina' style = 'color : black; margin-left : 5px;' href = leitura.php?ids=".$compartilhadas."&pagina=".$i.">".$i."</a>";
								}
							}
						}else{
							if($i <= $paginas_num){
								if (isSet($_GET['pesquisa'])){
									echo "<a class = 'pagina' style = 'margin-left : 5px' href = leitura.php?ids=".$compartilhadas."&pagina=".$i."&pesquisa=".$_GET['pesquisa'].">".$i."</a>";
								}else{
									echo "<a class = 'pagina' style = 'margin-left : 5px' href = leitura.php?ids=".$compartilhadas."&pagina=".$i.">".$i."</a>";
								}
							}
						}
						
					}
					
				?>
			</div>
		</div>
	</div>
	</div>
	<div class="units-row end">
		<div id="rodape" class="unit-100">
		<a href = 'inicio.php' class = 'link' style = 'margin-top : 1%;'><img style = 'margin-top : -40%;' src = 'icones/voltar.png'/></a>
			<?php include_once "partes/rodape.php" ?>
		</div>
	</div>
</body>
<?php
	include_once "partes/verifica_cores.php";
?>


</html>