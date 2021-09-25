<?php
include_once "Avaliacao.class.php";
include_once "MySQL.class.php";


class ControleAvaliacao{
	
	public function acaoAvaliacao($acao,$avaliacao){
		
		if($acao=="inserir"){
			$this->inserir($avaliacao);
		}else if($acao=="alterar"){
			$this->alterar($avaliacao);
		}else if($acao=="excluir"){
			$this->excluir($avaliacao);
		}	
	}
	
	public function listarTodos(){
		$conexao = new MySQL();
		$sql = "select * from avaliacao";
		$resultado = $conexao->consulta($sql);
		if($resultado){
			$avaliacaos = array();
			foreach($resultado as $avaliacao){
				$eq = new Avaliacao('','','','');
				$eq->setId($avaliacao['idAvaliacao']);
				$eq->setIdNarracao($avaliacao['idNarracao']);
				$eq->setIdUsuario($avaliacao['idUsuario']);
				$eq->setAvaliacao($avaliacao['avaliacao']);
				$avaliacaos[] = $eq;
			}
			return $avaliacaos;
		}else{
			return "vazio";
		}
		
	}
	
	//SELECT IdNarracao, MAX(soma) FROM ( SELECT IdNarracao, SUM(avaliacao) AS soma FROM avaliacao GROUP BY IdNarracao ) a

	
	public function listarUm($id){
		$conexao = new MySQL();
		$sql = "select * from avaliacao where idAvaliacao=".$id;
		$resultado = $conexao->consulta($sql);
		if($resultado){
			$eq = new Avaliacao('','','','');
			$eq->setId($resultado[0]['idAvaliacao']);
			$eq->setIdNarracao($resultado[0]['idNarracao']);
			$eq->setIdUsuario($resultado[0]['idUsuario']);
			$eq->setAvaliacao($resultado[0]['avaliacao']);
			return $eq;
		}else{
			return "vazio";
		}
		
	}
	
	public function listarMaximo($primeiro = -1, $segundo = -1){
		$conexao = new MySQL();
		$sql = "SELECT MAX(soma) as maximo FROM (SELECT idNarracao, SUM(avaliacao) AS soma FROM avaliacao where idNarracao != ".$primeiro." and idNarracao != ".$segundo." GROUP BY IdNarracao )a ";
		$resultado = $conexao->consulta($sql);
		if($resultado){
			return $resultado[0]['maximo'];
		}else{
			return "vazio";
		}
		
	}
	
	public function listarMelhor($maximo, $primeira = -1, $segunda = -1){
		$conexao = new MySQL();
		$sql = "SELECT idNarracao FROM (SELECT idNarracao, SUM(avaliacao) AS soma FROM avaliacao GROUP BY IdNarracao )a where soma = ".$maximo." and (idNarracao != ".$primeira." and idNarracao != ".$segunda.")" ;
		$resultado = $conexao->consulta($sql);
		if($resultado){
			return $resultado[0]['idNarracao'];
		}else{
			return "vazio";
		}
		
	}
	
	public function listarComNarracao($idNarracao){
		$conexao = new MySQL();
		$sql = "select * from avaliacao where idNarracao=".$idNarracao;
		$resultado = $conexao->consulta($sql);
		if($resultado){
			$avaliacaos = array();
			foreach($resultado as $avaliacao){
				$eq = new Avaliacao('','','','');
				$eq->setId($avaliacao['idAvaliacao']);
				$eq->setIdNarracao($avaliacao['idNarracao']);
				$eq->setIdUsuario($avaliacao['idUsuario']);
				$eq->setAvaliacao($avaliacao['avaliacao']);
				$avaliacaos[] = $eq;
			}
			return $avaliacaos;
		}else{
			return "vazio";
		}
		
	}
	
	public function listarComUsuario($idNarracao, $idUsuario){
		$conexao = new MySQL();
		$sql = "select * from avaliacao where idNarracao=".$idNarracao." and idUsuario=".$idUsuario;
		$resultado = $conexao->consulta($sql);
		if($resultado){
			$eq = new Avaliacao('','','','');
			$eq->setId($resultado[0]['idAvaliacao']);
			$eq->setIdNarracao($resultado[0]['idNarracao']);
			$eq->setIdUsuario($resultado[0]['idUsuario']);
			$eq->setAvaliacao($resultado[0]['avaliacao']);
			return $eq;
		}else{
			return "vazio";
		}
		
	}
	
	public function inserir($avaliacao){
		$conexao = new MySQL();
		$sql = "insert into avaliacao (idNarracao,idUsuario,avaliacao) values ('".$avaliacao->getIdNarracao()."','".$avaliacao->getIdUsuario()."','".$avaliacao->getAvaliacao()."')";
		$resultado = $conexao->executa($sql);
		return $resultado;
	}
	
	
	public function alterar($avaliacao){
		$conexao = new MySQL();
		$sql = "update avaliacao set idNarracao = '".$avaliacao->getIdNarracao()."', idUsuario = '".$avaliacao->getIdUsuario()."', avaliacao = '".$avaliacao->getAvaliacao()."' where idAvaliacao =  ".$avaliacao->getId();
		$resultado = $conexao->executa($sql);
		return $resultado;
	}
	
	public function excluir($avaliacao){
		$conexao = new MySQL();
		$sql = "delete from avaliacao where idAvaliacao = ".$avaliacao->getId();
		$resultado = $conexao->executa($sql);
		return $resultado;
	}
	
}

?>