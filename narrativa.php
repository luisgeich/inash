<?php
	session_start();
	include_once "ControleNarracao.class.php";
	include_once 'ControleCapitulo.class.php';
	include_once 'ControleLink.class.php';
	
	if (! isSet($_SESSION['senha'])){
		header("location: login.php");
	}
	
	if (! isSet($_SESSION['idNarracao']) && ! isSet($_GET["narracao"])){
		header("location: ferramenta.php");
	}
	
	if (isSet($_SESSION["idCap"])){
		unset($_SESSION["idCap"]);
	}
	
	
	$permitido = false;
	$controle = new ControleNarracao();
	$narrativas = $controle->listarComUsuario($_SESSION["id"]);
	if (isSet($_SESSION["idNarracao"])){
		$permitido = true;
		$id = $_SESSION["idNarracao"];
	}else{
		foreach ($narrativas as $narrativa){
			if ($narrativa->getId() == $_GET["narracao"]){
				$_SESSION["idNarracao"] = $_GET["narracao"];
				$permitido = true;
				$id = $_GET["narracao"];
			}
		}
	}
	
	$narrativa_atual;
	$controle = new ControleNarracao();
	$narrativas = $controle->listarTodos();
	if (isSet($_SESSION["idNarracao"])){
		$id = $_SESSION["idNarracao"];
	}else{
		$id = $_GET["narracao"];
	}
	
	foreach ($narrativas as $narrativa){
		if ($narrativa->getId() == $id){
			$narrativa_atual = $narrativa;
		}
	}
	
	$controleCap = new ControleCapitulo();
	$capitulos = $controleCap->listarComNarracao($id);
	$iniciais = 0;
	foreach($capitulos as $capitulo){
		if ($capitulo->getInicial() == 1){
			$iniciais += 1;
		}
	}
	
	if ($iniciais != 1){
		$narrativa_atual->setCompartilhada(0);
		$controleNarracao = new ControleNarracao();
		$controleNarracao->alterar($narrativa_atual);
	}
	
	function addCap($titulo,$inicial){
		$controleCap = new ControleCapitulo();
		$idNarracao = $_SESSION["idNarracao"];
		$capitulo = new Capitulo("",$titulo,"",$idNarracao,$inicial);
		$controleCap->inserir($capitulo);
		unset($_SESSION["nao_compartilhou"]);
		header("location: narrativa.php");
	}
	
	
	
	if ($permitido){
		if (! empty($_GET)){
			if (isSet($_GET["salvar"])){
				if (isSet($_GET["inicial"])){
					addCap($_GET["titulo"],1);
				}else{
					addCap($_GET["titulo"],0);
				}
				
			}else if(isSet($_GET["salvar_escolha"])){
				$controle = new ControleLink();
				$links = $controle->listarComNarracao($id);
				$link_atual;
				$idLink = $_GET["idEscolha"];
				foreach($links as $link){
					if($link->getId() == $idLink){
						$link_atual = $link;
						break;
					}
				}
				$link_atual->setEscolha($_GET['escolha']);
				if ($_GET['escolha'] == null || $iniciais != 1){
					$narrativa_atual->setCompartilhada(0);
					$controleNarracao = new ControleNarracao();
					$controleNarracao->alterar($narrativa_atual);
				}
				$controle->alterar($link_atual);
				unset($_SESSION["nao_compartilhou"]);
				header("location: narrativa.php");
			}
			if (isSet($_GET["excluir_ligacao"])){
				$controle = new ControleLink();
				$links = $controle->listarComNarracao($id);
				$link_atual;
				$idLink = $_GET["idEscolha"];
				foreach($links as $link){
					if($link->getId() == $idLink){
						$link_atual = $link;
						break;
					}
				}
				$controle->excluir($link_atual);
				unset($_SESSION["nao_compartilhou"]);
				header("location: narrativa.php");
			}else if(isSet($_GET["sim"])){
				$controle = new ControleLink();
				if($_GET['opcao'] == 'opcao1'){
					$origem = $_GET['id1'];
					$destino = $_GET['id2'];
				}else{
					$origem = $_GET['id2'];
					$destino = $_GET['id1'];
				}
				
				$novo = new Link('',$origem,$destino,null,$_SESSION["idNarracao"]);
				$controle->inserir($novo);
				if ($narrativa_atual->getCompartilhada() == 1){
					$_SESSION["nao_compartilhou"] = "desfeita";
				}
				$narrativa_atual->setCompartilhada(0);
				$controleNarracao = new ControleNarracao();
				$controleNarracao->alterar($narrativa_atual);
				header("location: narrativa.php");
			}else if(isSet($_GET["salvar_narracao"])){
				$controle = new ControleNarracao();
				$narrativa_atual->setTitulo($_GET["novo_titulo"]);
				$controle->alterar($narrativa_atual);
				unset($_SESSION["nao_compartilhou"]);
				header("location: narrativa.php");
			}else if(isSet($_GET["excluir_capitulo"])){
				$controle = new ControleCapitulo();
				$controle->excluir(new Capitulo($_GET["id_excluir"],'','','',''));
				unset($_SESSION["nao_compartilhou"]);
				header("location: narrativa.php");
			}else if(isSet($_GET['compartilhar'])){
				$controle = new ControleLink();
				$links = $controle->listarComNarracao($id);
				if ($_GET['compartilhar'] == 'sim'){
					$ok = true;
					foreach($links as $link){
						if ($link->getEscolha() == null){
							$ok = false;
							break;
						}
					}
					
					if ($iniciais != 1){
						$ok = false;
					}
					
					if ($ok){
						$narrativa_atual->setCompartilhada(1);
						unset($_SESSION["nao_compartilhou"]);
					}else{
						if ($iniciais < 1){
							$_SESSION["nao_compartilhou"] = "sem_iniciais";
						}else if($iniciais > 1){
							$_SESSION["nao_compartilhou"] = "muitos_iniciais";
						}else{
							$_SESSION["nao_compartilhou"] = "links";
						}
					}
				}else if($_GET['compartilhar'] == 'nao'){
					unset($_SESSION["nao_compartilhou"]);
					$narrativa_atual->setCompartilhada(0);
				}
				
				
				$controle = new ControleNarracao();
				$controle->alterar($narrativa_atual);
				header("location: narrativa.php");
			}
		}
		
	?>
<html>
<head>
	<?php
		echo "<title>INASH - ".$narrativa_atual->getTitulo()."</title>";
	?>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<link rel="stylesheet" href="css/kube.min.css" />
	<link rel="stylesheet" href="css/estilo.css" /> 
	<link rel="stylesheet" href="css/cores.css" /> 
	<link rel="stylesheet" href="css/telas.css" /> 
	<link href="http://cdnjs.cloudflare.com/ajax/libs/qtip2/2.2.0/jquery.qtip.min.css" rel="stylesheet" type="text/css" />
	
	<script src="js/kube.min.js"></script>
	<script src="js/muda_cores.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script src="http://cytoscape.github.io/cytoscape.js/api/cytoscape.js-latest/cytoscape.min.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/qtip2/2.2.0/jquery.qtip.min.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/qtip2/2.2.0/jquery.qtip.min.js"></script>
	<script src="https://cdn.rawgit.com/cytoscape/cytoscape.js-qtip/2.1.0/cytoscape-qtip.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	
	<?php
		include_once "partes/cytoscape.php";
	?>
</head>
<body id = 'body' style = 'overflow : hidden'>
	<?php
		if (isSet($_SESSION['nao_compartilhou'])){
			if ($_SESSION['nao_compartilhou'] == "links"){
				echo "<script>alert('Você possui ligações sem escolha definida.Não foi possivel compartilhar');</script>";
			}else if($_SESSION['nao_compartilhou'] == "sem_iniciais"){
				echo "<script>alert('Você não definiu nenhum capitulo inicial.Não foi possivel compartilhar');</script>";
			}else if($_SESSION['nao_compartilhou'] == "muitos_iniciais") {
				echo "<script>alert('Você definiu mais de um capitulo como o inicial.Não foi possivel compartilhar');</script>";
			}else if($_SESSION['nao_compartilhou'] == 'desfeita'){
				echo "<script>alert('Uma ligação foi criada sem escolha definida. Compartilhamento desfeito');</script>";
			}
			
		}
	?>
	<div class="units-row end">
		<div id="cabecalho" class="unit-100">
			<h1 id = 'logo'>INASH</h1>
			<a onclick = "getPositions(null)" href = 'sair.php' class = 'link'><img src = 'icones/sair.png'/></a>
		</div>
	</div>
	
	<div id="centro" class="units-row end units-split">
		<div id="perfil" class="unit-20">
			<img id = 'icone' src ='icones/livro_aberto.png'/><br>
			<br>
			<form method = 'GET' action = 'narrativa.php'> 
				<h3 id = 'titulo_narracao' style="cursor: pointer" onclick = 'acao()'>
				<?php
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
					echo $narrativa_atual->getTitulo();
				?>
				</h3>
				<button onclick = "getPositions(null)" class="btn" id = 'salvar_narracao' value = 'salvar_narracao' name = 'salvar_narracao' style = 'visibility : hidden'>Salvar</button>
			</form>
			<h3><a class = 'narracao' style = 'text-decoration : none' href = 'editar_narrativa.php'>Editar gênero/sinopse</a></h3>
			<?php
				echo "<a class='btn' id = 'ler' style = 'position : relative; margin-top : 15%;' onclick = 'getPositions(null)' href = 'ler.php?narrativa=".$id."&capitulo=inicial&caminho=narrativa.php'>Ler</a>";
			?>
			
		</div>

		</div>
		<p class = 'aviso' id = 'iniciais'><?php
			$controle = new ControleCapitulo();
			if (isSet($_SESSION["idNarracao"])){
				$id = $_SESSION["idNarracao"];
			}else{
				$id = $_GET["narracao"];
			}
			$capitulos = $controle->listarComNarracao($id);
		
			if ($iniciais > 1){
				echo "Você definiu mais de um capitulo como o inicial, por favor defina apenas 1!";
			}else if($iniciais < 1 && count($capitulos) > 0){
				echo "Você não definiu nenhum capitulo como inicial, por favor, faça isso!";
			}else{
				echo "";
			}
		?>
		</p>
		
		<div id = 'ferramentas' class = 'menu' style = 'position : absolute; right : 0px; top : 22.5%;' >
			<div id = 'menu'>
				<br><br>
				<img style = 'cursor: pointer; margin-top : -100%;' title = 'Adicionar Novo Capitulo'  onclick = 'mostrarTela()' src = 'icones/add.png'/>
				<img style = 'cursor: pointer; margin-top : 180%;' onclick = 'redefinir()' title = 'Redefinir para Posições Iniciais' src = 'icones/redefinir.png'/>
				<?php
					if ($narrativa_atual->getCompartilhada() == 0){
						echo "<img style = 'cursor: pointer; margin-top : 200%;' onclick = 'setCompartilhar(true)' title = 'Compartilhar Narrativa com Outros Usuários' src = 'icones/compartilhar.png'/>";
					}else{
						echo "<img style = 'cursor: pointer; margin-top : 200%;' onclick = 'setCompartilhar(false)' title = 'Parar Compartilhamento de Narrativa' src = 'icones/compartilhado.png'/>";
					}
				?>
				
			</div>
		</div>
		<div id="cy" class="unit-80">
	
		</div>
		<div id = 'zoom'>
			<p><img onclick = 'mais()' src = 'icones/mais.png'/></p>
			<br>
			<p>Z</p>
			<p>O</p>
			<p>O</p>
			<p>M</p>
			<p><img onclick = 'menos()' src = 'icones/menos.png'/></p>
		</div>
		<img title = 'Ative e clique sobre um capitulo para deleta-lo' onclick = 'abilitaMartelo()' id = 'martelo' src = 'icones/hammer.png'/>
	</div>
	
	<div id = 'tela_novo_capitulo'>
		<form action="narrativa.php" method="GET" name = 'f1'>
			<fieldset  style = 'margin-top : -5.5%'>
				<label >
					<div class="unit-centered unit-80">
						<h5>Insira o titulo do capítulo:</h5>
						<input type="text" id = 'titulo' name="titulo" class="width-100" />
						<br><input style = 'margin : 3%;' type='checkbox' class = 'check' name="inicial" id="inicial">
						<label for="inicial">Capítulo Inicial</label>
					</div>
				</label>
				
				<div class="units-row units-split">
					<div class="unit-50"><button onclick = "getPositions(null)" style = 'border-radius : 0px;'class="btn btn-blue width-100" name = 'salvar'>Salvar</button></div>
					<div class="unit-50"><a onclick = 'ocultarTelas()' style = 'border-radius : 0px;'class="btn width-100" name = "narracao">Cancelar</a></div>
				</div>
			</fieldset>
		</form>
	</div>
	
	<?php

		$lista_navegadores = array('MSIE', 'Firefox', 'Safari', 'Chrome', 'Edge'); //Aqui devemos colocar a lista dos navegadores
		$navegador_usado = $_SERVER['HTTP_USER_AGENT'];
		foreach($lista_navegadores as $valor_verificar){
			if(strrpos($navegador_usado, $valor_verificar)){
				$navegador = $valor_verificar;
			}
		}
	?>
	<div id = 'escolha_tela'>
		<form action="narrativa.php" method="GET">
			<?php
				if ($navegador == 'Safari' || $navegador == 'Chrome'){
					?>
					<fieldset style = 'margin-top : -10px;'>
					<label> 
					<?php
				}else{
					?>
					<fieldset style = 'margin-top : -8%;'>
					<label style = 'margin : 1%;'> 
					<?php
				}
				?>
					<div class="unit-centered unit-80">
						<h5>Insira o texto que servirá que opção para este capítulo durante o texto:</h5>
						<input type="text" id = 'escolha' name="escolha" class="width-100" />
					</div>
				</label>
				<?php
					if ($navegador == 'Safari' || $navegador == 'Chrome'){
						echo "<br>";
					}
				?>
				<input type = 'hidden' name = 'idEscolha' id = 'idEscolha'/>
				<div class="units-row units-split">
					<div class="unit-30"><button onclick = "getPositions(null)" style = 'border-radius : 0px;'class="btn width-100" name = 'excluir_ligacao'>Excluir</button></div>
					<div class="unit-40"><button onclick = "getPositions(null)" style = 'border-radius : 0px;'class="btn btn-blue width-100" name = 'salvar_escolha'>Salvar</button></div>
					<div class="unit-30"><a onclick = 'ocultarTelas();' style = 'border-radius : 0px;'class="btn width-100">Cancelar</a></div>
				</div>
			</fieldset>
		</form>
	</div>
	
	<div id = 'tela_excluir'>
		<form action="narrativa.php" method="GET">
		<fieldset>
			<label>
				<div class="unit-100"><h5 id = 'confirma_excluir'>Deseja excluir esse Capítulo ?</h5></div>
			</label>
			<br><br><br><br>
			<input type = 'hidden' name = 'id_excluir' id = 'id_excluir'/>
			<div class="units-row units-split">
				<div class="unit-50"><button onclick = "getPositions(null)" style = 'border-radius : 0px;'class="btn btn-blue width-100" name = 'excluir_capitulo'>Sim</button></div>
				<div class="unit-50"><a onclick = 'ocultarTelas()' style = 'border-radius : 0px;'class="btn width-100">Cancelar</a></div>
			</div>
		</fieldset>
		</form>
	</div>
	
	
	<div id = 'adiciona_ligacao'>
		<form action="narrativa.php" method="GET">
			<fieldset>
			<label>
				<div class="width-100"><h5 id = 'confirma'>Você deseja fazer com que ...</h5></div><br>
			</label>
			<input type = 'hidden' name = 'id1' id = 'id1'/>
			<input type = 'hidden' name = 'id2' id = 'id2'/>
			<input type="radio" name="opcao" value="opcao1"/><label id = "opcao1"></label><br>
			<input type="radio" name="opcao" value="opcao2"/><label id = "opcao2"></label><br><br>
			<div class="units-row units-split">
				<div class="unit-50"><button onclick = "getPositions(null)" style = 'border-radius : 0px;'class="btn btn-blue width-100" name = 'sim'>Sim</button></div>
				<div class="unit-50"><a onclick = 'ocultarTelas()' style = 'border-radius : 0px;'class="btn width-100">Cancelar</a></div>
			</div>
			</fieldset>
		</form>
	</div>
	
	<div class="units-row end">
		<div id="rodape" class="unit-100">
			<a onclick = "getPositions(null)" href = 'ferramenta.php' class = 'link' ><img style = 'margin-top : -10px;' src = 'icones/voltar.png'/></a>
			<?php include_once "partes/rodape.php" ?>
		</div>
	</div>
</body>

</html>
<?php
	}
	include_once "partes/verifica_cores.php";
?>

