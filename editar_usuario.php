<?php
	include_once 'ControleUsuario.class.php';
	session_start();
	
	if (! isSet($_SESSION['senha'])){
		header("location: login.php");
	}
	
	$controle = new ControleUsuario();
	$usuarios = $controle->listarTodos();
	$id = $_SESSION["id"];
	foreach ($usuarios as $usuario){
		if ($usuario->getId() == $id){
			$_SESSION["nome"] = $usuario->getNome();
			$_SESSION["senha"] = $usuario->getSenha();
		}
	}
	if (! empty($_POST)){
		$nome = $_POST['nome'];
		$email = $_SESSION["email"];
		$senha = $_POST['senha'];
		$confirma = $_POST['confirma'];
		$imagem = $_SESSION['imagem'];
		
		if ($senha == $confirma){		
			$controle->alterar(new Usuario($id,$nome,$email,$senha,$imagem));
			$_SESSION["nome"] = $_POST["nome"];
			$_SESSION["salvo"] = 'salvo';
			header("location: ferramenta.php");
			
		}else{
			header("location: editar_usuario.php");
		}
	}else{
		?>
		<html>
		<head>
		   <title>INASH - Editar Usuário</title>

			<meta charset="utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1" />

			<link rel="stylesheet" href="css/kube.min.css" />
			<link rel="stylesheet" href="css/estilo.css" />    
			<link rel="stylesheet" href="css/cores.css" />    
			<script src="js/kube.min.js"></script>
			<script src="js/muda_cores.js"></script>
			<script>
				var confere = false;
				function verificaSenhas(){
					senha = document.getElementsByName('senha')[0].value;
					confirma = document.getElementsByName('confirma')[0].value;
					if (confirma.length > 0){
						if (senha == confirma){
							document.getElementById('nao_confere').style.visibility = 'hidden';
							confere = true;
						}else{
							document.getElementById('nao_confere').style.visibility = 'visible';
							confere = false;
						}
					}else{
						confere = false;
					}
				}
				
				function alerta(elemento){
					if (elemento.value.length > 0){
						elemento.className = "width-50";
					}else{
						elemento.className = "input-error width-50";
					}
				}
				
				
				
				function inicia(){
					document.getElementsByName("nome")[0].value = "<?php echo $_SESSION["nome"]; ?>";
					document.getElementsByName("senha")[0].value = "<?php echo $_SESSION["senha"]; ?>";
					document.getElementsByName("confirma")[0].value = "<?php echo $_SESSION["senha"]; ?>";
					bloqueia();
				}
				
				function bloqueia(){
					verificaSenhas();
					nome = document.getElementsByName("nome")[0].value;
					senha = document.getElementsByName('senha')[0].value;
					confirma = document.getElementsByName('confirma')[0].value;
					if (nome.length <= 0 || !confere || senha.length <= 0 ){
						document.getElementsByName("botao")[0].disabled = true;
					}else{
						document.getElementsByName("botao")[0].disabled = false;
					}
					setTimeout(bloqueia, 100);
				}
				
				function mostrarTela(){
					document.getElementById('tela').style.display = 'block';
					document.getElementById('titulo').value = "";
				}
				
				function setarVermelho(){
					mudaVermelho();
					window.location.href = "setarCores.php?cor=vermelho&caminho=editar_usuario.php";
				}
				
				function setarAzul(){
					mudaAzul();
					window.location.href = "setarCores.php?cor=azul&caminho=editar_usuario.php";
				}
				
				function setarCinza(){
					mudaCinza();
					window.location.href = "setarCores.php?cor=cinza&caminho=editar_usuario.php";
				}
				
				function setarAmarelo(){
					mudaAmarelo();
					window.location.href = "setarCores.php?cor=amarelo&caminho=editar_usuario.php";
				}
				
				function setarVerde(){
					mudaVerde();
					window.location.href = "setarCores.php?cor=verde&caminho=editar_usuario.php";
				}
				
				function setarLaranja(){
					mudaLaranja();
					window.location.href = "setarCores.php?cor=laranja&caminho=editar_usuario.php";
				}
				
				window.onload = inicia;
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
					<?php
						if ($_SESSION['imagem'] == null){
							echo "<a href = 'salvaImagem.php'><img id = 'icone' src ='icones/foto_padrao.png'/></a><br>";
						}else{
							echo "<a href = 'salvaImagem.php'><img id = 'icone' src = 'imagens/".$_SESSION['imagem']."'/></a><br>";
						}
					?>
					<h5 style = 'margin-top : 20px;'><?php echo $_SESSION["nome"]; ?></h5>
					<h5 style = 'margin-top : 20px;'><?php echo $_SESSION["email"]; ?></h5>
				</div>
				<div id="conteudo" class="unit-80">
					<form method="post" action="editar_usuario.php" class="forms" style = 'margin-top : 1%;'>
						<fieldset>
							<label>
								<p>Nome</p>
								<input type="text" name="nome" onblur = "alerta(this)" class="width-50" />
							</label>
							<label>
								<p>Nova senha</p>
								<input type="password" name="senha" onblur = "alerta(this)" onkeyup = "verificaSenhas()" class="width-50" />
							</label>
							<label>
								<p>Confirma senha</p>
								<input type="password" name="confirma" onblur = "alerta(this)" onkeyup = "verificaSenhas()" class="width-50" />
							</label>
							<p id = 'nao_confere'>Senhas não conferem</p>
							<button class="btn" name = 'botao' value = 'salvar'>Salvar</button>
							<a href = 'excluir.php' class = 'btn'>Excluir</a>
						</fieldset>
					</form>
				</div>
			</div>
			
			<div class="units-row end">
				<div id="rodape" class="unit-100">
					<a href = 'inicio.php' class = 'link' style = 'margin-top : 10px;'><img style = 'margin-top : -15px;' src = 'icones/voltar.png'/></a>
					<?php include_once "partes/rodape.php" ?>
				</div>
			</div>
		</body>
		</html>
	<?php
	}
	include_once "partes/verifica_cores.php";
?>
