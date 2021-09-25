<?php
include_once "Usuario.class.php";
include_once "MySQL.class.php";


class ControleUsuario{
	
	public function acaoUsuario($acao,$usuario){
		
		if($acao=="inserir"){
			$this->inserir($usuario);
		}else if($acao=="alterar"){
			$this->alterar($usuario);
		}else if($acao=="excluir"){
			$this->excluir($usuario);
		}	
	}
	
	public function listarTodos(){
		$conexao = new MySQL();
		$sql = "select * from usuario";
		$resultado = $conexao->consulta($sql);
		if($resultado){
			$usuarios = array();
			foreach($resultado as $usuario){
				$eq = new Usuario('','','','');
				$eq->setId($usuario['idUsuario']);
				$eq->setNome($usuario['nome']);
				$eq->setEmail($usuario['email']);
				$eq->setSenha($usuario['senha']);
				$eq->setImagem($usuario['imagem']);
				$usuarios[] = $eq;
			}
			return $usuarios;
		}else{
			return "vazio";
		}
		
	}
	
	public function listarUm($id){
		$conexao = new MySQL();
		$sql = "select * from usuario where idUsuario=$id";
		$resultado = $conexao->consulta($sql);
		if($resultado){
			$eq = new Usuario('','','','');
			$eq->setId($resultado[0]['idUsuario']);
			$eq->setNome($resultado[0]['nome']);
			$eq->setEmail($resultado[0]['email']);
			$eq->setSenha($resultado[0]['senha']);
			$eq->setImagem($resultado[0]['imagem']);
			return $eq;
		}else{
			return "vazio";
		}
		
	}
	
	public function inserir($usuario){
		$conexao = new MySQL();
		$sql = "insert into usuario (nome,email,senha) values ('".$usuario->getNome()."','".$usuario->getEmail()."','".$usuario->getSenha()."')";
		$resultado = $conexao->executa($sql);
		return $resultado;
	}
	
	
	public function alterar($usuario){
		$conexao = new MySQL();
		$sql = "update usuario set nome = '".$usuario->getNome()."', email = '".$usuario->getEmail()."', senha = '".$usuario->getSenha()."' , imagem = '".$usuario->getImagem()."' where idUsuario =  ".$usuario->getId();
		$resultado = $conexao->executa($sql);
		return $resultado;
	}
	
	public function excluir($usuario){
		$conexao = new MySQL();
		$sql = "delete from usuario where idUsuario = ".$usuario->getId();
		$resultado = $conexao->executa($sql);
		return $resultado;
	}
	
}

?>