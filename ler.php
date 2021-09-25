<?php
	session_start();
	include_once "ControleCapitulo.class.php";
	include_once "ControleLink.class.php";
	include_once "ControleAvaliacao.class.php";
	
	if (! isSet($_GET["capitulo"])){
		header("location: ferramenta.php");
	}
	
	$nao_logado = false;
	if (isSet($_GET["caminho"])){
		if ($_GET['caminho'] == 'index.php'){
			$nao_logado = true;
		}
		if (isSet($_GET['genero1'])){
			$_SESSION["caminho"] = $_GET["caminho"]."&genero1=".$_GET['genero1']."&genero2=".$_GET['genero2'];	
		}else{
			$_SESSION["caminho"] = $_GET["caminho"];
		}
		
	}
	
	if ($_SESSION['caminho'] == 'index.php'){
			$nao_logado = true;
	}
	
	
	if (isSet($_GET['marcar'])){
		$controleAvaliacao = new ControleAvaliacao();
		$avaliacao = $controleAvaliacao->listarComUsuario($_GET['narrativa'], $_SESSION['id']);
		if ($_GET['marcar'] == 'like'){
			$avaliacao->setAvaliacao(1);
		}else{
			$avaliacao->setAvaliacao(-1);
		}
		$controleAvaliacao->alterar($avaliacao);
		
	}
	
	$caminho_narrativa = false;
	$ha_avaliacao = false;
	if ($_SESSION['caminho'] == 'narrativa.php'){
		$caminho_narrativa = true;
	}
	
	if (! $nao_logado){
		$controleAvaliacao = new ControleAvaliacao();
		$avaliacao = $controleAvaliacao->listarComUsuario($_GET['narrativa'], $_SESSION['id']);
		if ($avaliacao == "vazio" && ! $caminho_narrativa){
			$avaliacao_nova = new Avaliacao('',$_GET['narrativa'],$_SESSION['id'],0);
			$controleAvaliacao->inserir($avaliacao_nova);
		}else{
			$ha_avaliacao = true;
		}
	}
	
	$controle = new ControleCapitulo();
	$capitulos = $controle->listarComNarracao($_GET['narrativa']);
	$iniciais = array();
	foreach($capitulos as $capitulo){
		if ($capitulo->getInicial() == 1){
			array_push($iniciais, $capitulo);
		}
	}
	$iniciais_num = count($iniciais);
?>
<html>
<head>
   <title>INASH - Ler</title>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<link rel="stylesheet" href="css/kube.min.css" />
	<link rel="stylesheet" href="css/estilo.css" />    
	<link rel="stylesheet" href="css/cores.css" />    
	<script src="js/kube.min.js"></script>
	<script src="js/muda_cores.js"></script>
	<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
	<script>
		function setarVermelho(){
			mudaVermelho();
			window.location.href = "setarCores.php?cor=vermelho&caminho=ler.php?narrativa="+"<?php echo $_GET['narrativa']?>"+"&capitulo="+"<?php echo $_GET['capitulo']?>";
		}
		
		function setarAzul(){
			mudaAzul();
			window.location.href = "setarCores.php?cor=azul&caminho=ler.php?narrativa="+"<?php echo $_GET['narrativa']?>"+"&capitulo="+"<?php echo $_GET['capitulo']?>";
		}
		
		function setarCinza(){
			mudaCinza();
			window.location.href = "setarCores.php?cor=cinza&caminho=ler.php?narrativa="+"<?php echo $_GET['narrativa']?>"+"&capitulo="+"<?php echo $_GET['capitulo']?>";
		}
		
		function setarAmarelo(){
			mudaAmarelo();
			window.location.href = "setarCores.php?cor=amarelo&caminho=ler.php?narrativa="+"<?php echo $_GET['narrativa']?>"+"&capitulo="+"<?php echo $_GET['capitulo']?>";
		}
		
		function setarVerde(){
			mudaVerde();
			window.location.href = "setarCores.php?cor=verde&caminho=ler.php?narrativa="+"<?php echo $_GET['narrativa']?>"+"&capitulo="+"<?php echo $_GET['capitulo']?>";
		}
		
		function setarLaranja(){
			mudaLaranja();
			window.location.href = "setarCores.php?cor=laranja&caminho=ler.php?narrativa="+"<?php echo $_GET['narrativa']?>"+"&capitulo="+"<?php echo $_GET['capitulo']?>";
		}
		
		function marcar(opcao){
			if (opcao == 1){
				window.location.href = "ler.php?marcar=like&narrativa="+"<?php echo $_GET['narrativa']?>"+"&capitulo="+"<?php echo $_GET['capitulo']?>";
			}else{
				window.location.href = "ler.php?marcar=unlike&narrativa="+"<?php echo $_GET['narrativa']?>"+"&capitulo="+"<?php echo $_GET['capitulo']?>";
			}
		}
		
		window.onload = carregaItens;
	</script>
  </head>
</head>
<body>
	<div class="units-row end">
		<div id="cabecalho" class="unit-100">
			<h1 id = 'logo'>INASH</h1>
			<?php
				if ($nao_logado){
					echo "<a href = 'login.php' class = 'link'><img src = 'icones/login.png'/></a>";
				}else{
					echo "<a href = 'sair.php' class = 'link'><img src = 'icones/sair.png'/></a>";
				}
			?>
		
		</div>
	</div>
	
	<div id="centro" 
	
	class="units-row end units-split">
		<div id="perfil" class="unit-20">
			<br>
			<br>
			<h3 id = 'titulo_capitulo' onclick = 'acao()'>Capítulo: 
				<?php
					if ($iniciais_num == 1){
						if ($_GET['capitulo'] == 'inicial'){
							$capitulo_atual = $iniciais[0];
						}else{
							foreach($capitulos as $capitulo){
								if ($capitulo->getId() == $_GET['capitulo']){
									$capitulo_atual = $capitulo;
								}
							}
						}
						echo $capitulo_atual->getTitulo();
					}
				?>
			</h3>
			<br>
			<h3>Capítulos Anteriores:</h3>
			<div style = 'overflow : auto; height : 10%'>
			<?php
				if ($iniciais_num == 1){
					include_once "ControleLink.class.php";
					$controle = new ControleLink();
					$ids = $controle->listarAnteriores($capitulo_atual->getId());
					$controleCap = new ControleCapitulo();
					$capitulos = $controleCap->listarTodos();
					$jaUsados = array();
					foreach($capitulos as $capitulo){
						foreach($ids as $id){
							if($id == $capitulo->getId() && ! in_array($id, $jaUsados)){
								echo "<a style = 'text-decoration : none;'class = 'capitulo' href = 'ler.php?narrativa=".$_GET['narrativa']."&capitulo=".$id."' >".$capitulo->getTitulo()."</a><br>";
								$jaUsados[] = $id;
							}
						}
					}
				}
			?>
			</div>
			<h3>Próximos Capítulos:</h3>
			<div style = 'overflow : auto; height : 10%'>
				<?php
					if ($iniciais_num == 1){
						include_once "ControleLink.class.php";
						$controle = new ControleLink();
						$ids = $controle->listarProximos($capitulo_atual->getId());
						$controleCap = new ControleCapitulo();
						$capitulos = $controleCap->listarTodos();
						$jaUsados = array();
						foreach($capitulos as $capitulo){
							foreach($ids as $id){
								if($id == $capitulo->getId() && ! in_array($id, $jaUsados)){
									echo "<a style = 'text-decoration : none;'class = 'capitulo' href = 'ler.php?narrativa=".$_GET['narrativa']."&capitulo=".$id."' >".$capitulo->getTitulo()."</a><br>";
									$jaUsados[] = $id;
								}
							}
						}
					}
				?>
			</div>
			<div id = 'fixed'>
				<?php
					if ($iniciais_num == 1){
						$idInicial = $iniciais[0]->getId();
						echo "<h3><a style = 'text-decoration : none;' class = 'capitulo' href = 'ler.php?narrativa=".$_GET['narrativa']."&capitulo=".$idInicial."' > Capítulo Incial </a></h3><br>";
					}
					
				?>
				<div id="avaliacao">
				<?php
					if (! $nao_logado){
						if (! $caminho_narrativa){
							$controleAvaliacao = new ControleAvaliacao();
							$avaliacao = $controleAvaliacao->listarComUsuario($_GET['narrativa'], $_SESSION['id']);
							if ($avaliacao == 'vazio' || $avaliacao->getAvaliacao() == 0){
								echo "<img title = 'Gostei' onclick = 'marcar(1)' id = 'like' src = 'icones/like_desmarcado.png'>";
								echo "<img title = 'Não Gostei' onclick = 'marcar(2)' id = 'unlike' src = 'icones/unlike_desmarcado.png'>";
							}else{
								if ($avaliacao->getAvaliacao() == 1){
									echo "<img title = 'Gostei' onclick = 'marcar(1)' id = 'like' src = 'icones/like_marcado.png'>";
									echo "<img title = 'Não Gostei' onclick = 'marcar(2)' id = 'unlike' src = 'icones/unlike_desmarcado.png'>";
								}else if($avaliacao->getAvaliacao() == -1){
									echo "<img title = 'Gostei' onclick = 'marcar(1)' id = 'like' src = 'icones/like_desmarcado.png'>";
									echo "<img title = 'Não Gostei' onclick = 'marcar(2)' id = 'unlike' src = 'icones/unlike_marcado.png'>";
								}else{
									echo "<img title = 'Gostei' onclick = 'marcar(1)' id = 'like' src = 'icones/like_desmarcado.png'>";
									echo "<img title = 'Não Gostei' onclick = 'marcar(2)' id = 'unlike' src = 'icones/unlike_desmarcado.png'>";
								}
							}
								
						}else{
							$controleAvaliacao = new ControleAvaliacao();
							$avaliacoes = $controleAvaliacao->listarComNarracao($_GET['narrativa']);
							$likes = 0;
							$unlikes = 0;
							if ($avaliacoes != 'vazio'){
								foreach($avaliacoes as $avaliacao){
									if ($avaliacao->getAvaliacao() == 1){
										$likes += 1;
									}else if($avaliacao->getAvaliacao() == -1){
										$unlikes += 1;
									}
								}
							}
							echo "<img title = 'Gostei : ".$likes."' id = 'like' style = 'cursor : auto;' src = 'icones/like_desmarcado.png'><sub>".$likes."</sub>";
							echo "<img title = 'Não Gostei : ".$unlikes."' id = 'unlike' style = 'cursor : auto;' src = 'icones/unlike_desmarcado.png'><sub>".$unlikes."</sub>";
						
						}
					}else{
						echo "<img title = 'Logue-se para votar' id = 'like' src = 'icones/like_desmarcado.png'>";
						echo "<img title = 'Logue-se para votar' id = 'unlike' src = 'icones/unlike_desmarcado.png'>";
					}
					
				?>
				</div>
			</div>
		</div>
		<div id="conteudo" class="unit-80 historia">
			<br>
			<br>
			<h3>
			<?php
				
				$iniciais_num = count($iniciais);
				if ($iniciais_num > 1){
					echo "Você definiu mais de um capítulo como o inicial, por favor defina apenas 1!";
				}else if($iniciais_num < 1){
					echo "Você não definiu nenhum capítulo como inicial, por favor, faça isso!";
				}else{	
					if ($_GET['capitulo'] == 'inicial'){
						$capitulo_atual = $iniciais[0];
					}else{
						foreach($capitulos as $capitulo){
							if ($capitulo->getId() == $_GET['capitulo']){
								$capitulo_atual = $capitulo;
							}
						}
					}
					echo $capitulo_atual->getTitulo();
				}
			?>
			</h3><br><br>
			<div class="unit-centered unit-90" id = 'texto'>
			<p>
				<?php
					if ($iniciais_num == 1){
						echo $capitulo_atual->getConteudo();
					}
					
				?>
			</p>
			<?php
				if ($iniciais_num == 1){
					$controleLink = new ControleLink();
					$proximos = $controleLink->listarProximos($capitulo_atual->getId());
					foreach($proximos as $proximo){
						$link = $controleLink->listarLink($capitulo_atual->getId(), $proximo);
						echo "<a class = 'escolha' href = ler.php?narrativa=".$_GET['narrativa']."&capitulo=".$link->getIdDestino().">".$link->getEscolha()."</a><br>";
					}
				}
			?>
			</div>
		</div>
	</div>

	<div class="units-row end">
		<div id="rodape" class="unit-100">
			<?php
				echo "<a href = '". $_SESSION["caminho"]."' class = 'link' style = 'margin-top : 10px;'><img style = 'margin-top : -15px;' src = 'icones/voltar.png'/></a>";
			?>
			
			<?php include_once "partes/rodape.php" ?>
		</div>
	</div>
</body>	
</html>	
<?php
	include_once "ControleCapitulo.class.php";
	$controle = new ControleCapitulo();
	$id = $_GET["narrativa"];
	$capitulos = $controle->listarComNarracao($id);
	$iniciais = 0;
	foreach($capitulos as $capitulo){
		if ($capitulo->getInicial() == 1){
			$iniciais += 1;
		}
	}
	include_once "partes/verifica_cores.php";
?>