<?php
	include_once 'ControleUsuario.class.php';
	session_start();
	if (! empty($_POST)){
		$nome = $_POST['nome'];
		$email = $_POST['email'];
		$senha = $_POST['senha'];
		$confirma = $_POST['confirma'];
		
		if ($senha == $confirma){		
		
			$igual = false;
			$controle = new ControleUsuario();
			$usuarios = $controle->listarTodos();
			foreach ($usuarios as $usuario){
				if ($usuario->getEmail() == $email){
					$igual = true;
				}
			}
			if (! $igual){
				$controle->inserir(new Usuario("",$nome,$email,$senha));
				$_SESSION["nome"] = $_POST["nome"];
				header("location: cadastro_completo.php");
			}else{
				$_SESSION["email_usado"] = true;
				header("location: cadastro.php");
			}
		}else{
			header("location: cadastro.php");
		}
	}else{
		?>
	<html>
		<head>
		   <title>INASH - Cadastro</title>

			<meta charset="utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1" />

			<link rel="stylesheet" href="css/kube.css" />
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
							document.getElementById('aviso').innerHTML = '';
							confere = true;
						}else{
							document.getElementById('aviso').innerHTML = 'Senhas não conferem';
							confere = false;
						}
					}
					
					if (senha.length > 16){
						document.getElementById('aviso').innerHTML = 'Senha com 16 caracteres no máximo';
					}else if (confere){
						document.getElementById('aviso').innerHTML = '';
					}
				}
				
				function alerta(elemento){
					if (elemento.value.length > 0){
						elemento.className = "width-50";
					}else{
						elemento.className = "input-error width-50";
					}
				}
				
				function exibeAlerta(){
					document.getElementById('aviso').innerHTML = 'E-mail já usado';
				}
				
				function bloqueia(){
					nome = document.getElementsByName("nome")[0].value;
					email = document.getElementsByName("email")[0].value;
					if (email.length <= 0 || nome.length <= 0 || !confere){
						document.getElementsByName("botao")[0].disabled = true;
					}else{
						document.getElementsByName("botao")[0].disabled = false;
					}
					carregaItens();
					setTimeout(bloqueia, 100);
				}
				
				
				function setarVermelho(){
					mudaVermelho();
					window.location.href = "setarCores.php?cor=vermelho&caminho=cadastro.php";
				}
				
				function setarAzul(){
					mudaAzul();
					window.location.href = "setarCores.php?cor=azul&caminho=cadastro.php";
				}
				
				function setarCinza(){
					mudaCinza();
					window.location.href = "setarCores.php?cor=cinza&caminho=cadastro.php";
				}
				
				function setarAmarelo(){
					mudaAmarelo();
					window.location.href = "setarCores.php?cor=amarelo&caminho=cadastro.php";
				}
				
				function setarVerde(){
					mudaVerde();
					window.location.href = "setarCores.php?cor=verde&caminho=cadastro.php";
				}
				
				function setarLaranja(){
					mudaVerde();
					window.location.href = "setarCores.php?cor=laranja&caminho=cadastro.php";
				}
				
				window.onload = bloqueia;
			</script>
			
		</head>
		<body>
			<div class="units-row end">
				<div id="cabecalho" class="unit-100">
					<h1 id = 'logo'>INASH</h1>
					<a href = 'login.php' class = 'link'><img src = 'https://cdn1.iconfinder.com/data/icons/customicondesign-mini-deepcolour-png/48/Login_in.png'/></a>
					
				</div>
			</div>
			
			<div class="units-row end">
				<div class = "unit-100" id = "centro" style = 'margin-top : 150px;'>
					<form method="post" action="cadastro.php" class="forms">
					<fieldset>
						<legend>Preencha todos os campos para efetuar o cadastro</legend>
						<label>
							<input type="text" name="nome" onblur = "alerta(this)" placeholder="Nome" class="width-50" />
						</label>
						<label>
							<input type="email" name="email" onblur = "alerta(this)" placeholder="Email" class="width-50" />
						</label>
						<label>
							<input type="password" name="senha" onblur = "alerta(this)" onkeyup = "verificaSenhas()" placeholder="Senha" class="width-50" />
						</label>
						<label>
							<input type="password" name="confirma" onblur = "alerta(this)" onkeyup = "verificaSenhas()" placeholder="Confirma Senha" class="width-50" />
						</label>
						<p class = 'aviso' id = 'aviso'></p>
							<?php
								if (isSet($_SESSION["email_usado"])){
									echo '<script>exibeAlerta()</script>';
								}
							?>
						<button class="btn" name = 'botao' value = 'Cadastrar'>Cadastrar</button>
					</fieldset>
					</form>
				</div>
			</div>
			<br>
			<div id="rodape" class="unit-100">
			<a href = 'sair.php' class = 'link'><img style = 'margin-top : -10px;' src = 'icones/voltar.png'/></a>
			<?php include_once "partes/rodape.php" ?>
		</div>
		</body>
<?php
	}
	include_once "partes/verifica_cores.php";
?>
</html>