<?php
include_once "Link.class.php";
include_once "MySQL.class.php";


class ControleLink{
	
	public function acaoUsuario($acao,$link){
		
		if($acao=="inserir"){
			$this->inserir($link);
		}else if($acao=="alterar"){
			$this->alterar($link);
		}else if($acao=="excluir"){
			$this->excluir($link);
		}	
	}
	
	public function listarTodos(){
		$conexao = new MySQL();
		$sql = "select * from link";
		$resultado = $conexao->consulta($sql);
		if($resultado){
			$links = array();
			foreach($resultado as $link){
				$eq = new Link('','','','','','');
				$eq->setId($link['idLink']);
				$eq->setIdOrigem($link['idOrigem']);
				$eq->setIdDestino($link['idDestino']);
				$eq->setEscolha($link['escolha']);
				$eq->setIdNarracao($link['idNarracao']);
				$links[] = $eq;
			}
			return $links;
		}else{
			return "vazio";
		}
		
	}
	
	
	
	public function listarProximos($idOrigem){
		$conexao = new MySQL();
		$sql = "SELECT DISTINCT * FROM link where idOrigem =  $idOrigem";
		$resultado = $conexao->consulta($sql);
		$links = array();
		foreach($resultado as $link){
			$links[] = $link['idDestino'];
		}
		return $links;
	}
	
	public function listarAnteriores($idDestino){
		$conexao = new MySQL();
		$sql = "SELECT DISTINCT * FROM link where idDestino =  $idDestino";
		$resultado = $conexao->consulta($sql);
		$links = array();
		foreach($resultado as $link){
			$links[] = $link['idOrigem'];
		}
		return $links;
	}
	
	public function listarUm($idLink){
		$conexao = new MySQL();
		$sql = "select * from link where idLink = $idLink";
		$resultado = $conexao->consulta($sql);
		if($resultado){
			$eq = new Link('','','','','','');
			$eq->setId($resultado[0]['idLink']);
			$eq->setIdOrigem($resultado[0]['idOrigem']);
			$eq->setIdDestino($resultado[0]['idDestino']);
			$eq->setEscolha($resultado[0]['escolha']);
			$eq->setIdNarracao($resultado[0]['idNarracao']);
			return $eq;
		}else{
			return "vazio";
		}
		
	}
	
	public function listarLink($idOrigem, $idDestino){
		$conexao = new MySQL();
		$sql = "select * from link where idOrigem=$idOrigem and idDestino = $idDestino";
		$resultado = $conexao->consulta($sql);
		if($resultado){
			$eq = new Link('','','','','','');
			$eq->setId($resultado[0]['idLink']);
			$eq->setIdOrigem($resultado[0]['idOrigem']);
			$eq->setIdDestino($resultado[0]['idDestino']);
			$eq->setEscolha($resultado[0]['escolha']);
			$eq->setIdNarracao($resultado[0]['idNarracao']);
			return $eq;
		}else{
			return "vazio";
		}
		
	}
	
	public function listarComNarracao($id){
		$conexao = new MySQL();
		$sql = "SELECT * FROM narracao, link where narracao.idNarracao = link.idNarracao and narracao.idNarracao =  $id";
		$resultado = $conexao->consulta($sql);
		$links = array();
		foreach($resultado as $link){
			$eq = new Link('','','','','','');
			$eq->setId($link['idLink']);
			$eq->setIdOrigem($link['idOrigem']);
			$eq->setIdDestino($link['idDestino']);
			$eq->setEscolha($link['escolha']);
			$eq->setIdNarracao($link['idNarracao']);
			$links[] = $eq;
		}
		return $links;
		
	}
	
	public function inserir($link){
		$conexao = new MySQL();
		$sql = "insert into link (idOrigem,idDestino, escolha,idNarracao) values ('".$link->getIdOrigem()."','".$link->getIdDestino()."','".$link->getEscolha()."','".$link->getIdNarracao()."')";
		$resultado = $conexao->executa($sql);
		return $resultado;
	}
	
	
	public function alterar($link){
		$conexao = new MySQL();
		$sql = "update link set idOrigem = '".$link->getIdOrigem()."',idDestino = '".$link->getIdDestino()."', escolha = '".$link->getEscolha()."',idNarracao = '".$link->getIdNarracao()."' where idLink = ".$link->getId();
		$resultado = $conexao->executa($sql);
		return $resultado;
	}
	
	public function excluir($link){
		$conexao = new MySQL();
		$sql = "delete from link where idLink = ".$link->getId();
		$resultado = $conexao->executa($sql);
		return $resultado;
	}
	
}

?>