<?php
include_once "Narracao.class.php";
include_once "MySQL.class.php";


class ControleNarracao{
	
	public function acaoUsuario($acao,$narracao){
		
		if($acao=="inserir"){
			$this->inserir($narracao);
		}else if($acao=="alterar"){
			$this->alterar($narracao);
		}else if($acao=="excluir"){
			$this->excluir($narracao);
		}	
	}
	
	public function listarTodos(){
		$conexao = new MySQL();
		$sql = "select * from narracao";
		$resultado = $conexao->consulta($sql);
		if($resultado){
			$narracoes = array();
			foreach($resultado as $narracao){
				$eq = new Narracao('','','','','');
				$eq->setId($narracao['idNarracao']);
				$eq->setTitulo($narracao['titulo']);
				$eq->setIdUsuario($narracao['idUsuario']);
				$eq->setAutor($narracao['autor']);
				$eq->setCompartilhada($narracao['compartilhada']);
				$eq->setSinopse($narracao['sinopse']);
				$eq->setGeneros($narracao['genero1'],$narracao['genero2']);
				$eq->setZoom($narracao['zoom']);
				$narracoes[] = $eq;
			}
			return $narracoes;
		}else{
			return "vazio";
		}
		
	}
	
	public function listarComPesquisa($pesquisa, $tipo, $genero1 =  "''", $genero2 = "''"){
		$conexao = new MySQL();
		$sql = "";
		if ($tipo == 'sem genero'){
			$sql = "select * from narracao where compartilhada = 1 and titulo like '%".$pesquisa."%' or autor like '%".$pesquisa."%'";
		}else if($tipo == 'um genero'){
			$sql = "select * from narracao where compartilhada = 1 and (titulo like '%".$pesquisa."%' or autor like '%".$pesquisa."%') and (genero1 = '".$genero1."' or genero2 = '".$genero1."')";
		}else if($tipo == 'dois generos'){
			$sql = "select * from narracao where compartilhada = 1 and (titulo like '%".$pesquisa."%' or autor like '%".$pesquisa."%') and (genero1 = '".$genero1."' and genero2 = '".$genero2."' or genero1 = '".$genero2."' and genero2 = '".$genero1."')";
		}
		$resultado = $conexao->consulta($sql);
		if($resultado){
			$narracoes = array();
			foreach($resultado as $narracao){
				$eq = new Narracao('','','','','');
				$eq->setId($narracao['idNarracao']);
				$eq->setTitulo($narracao['titulo']);
				$eq->setIdUsuario($narracao['idUsuario']);
				$eq->setAutor($narracao['autor']);
				$eq->setCompartilhada($narracao['compartilhada']);
				$eq->setSinopse($narracao['sinopse']);
				$eq->setGeneros($narracao['genero1'],$narracao['genero2']);
				$eq->setZoom($narracao['zoom']);
				$narracoes[] = $eq;
			}
			return $narracoes;
		}else{
			return array();
		}
		
	}
	

	public function listarCompartilhadas(){
		$conexao = new MySQL();
		$sql = "select * from narracao where compartilhada = 1";
		$resultado = $conexao->consulta($sql);
		if($resultado){
			$narracoes = array();
			foreach($resultado as $narracao){
				$eq = new Narracao('','','','','');
				$eq->setId($narracao['idNarracao']);
				$eq->setTitulo($narracao['titulo']);
				$eq->setIdUsuario($narracao['idUsuario']);
				$eq->setAutor($narracao['autor']);
				$eq->setCompartilhada($narracao['compartilhada']);
				$eq->setSinopse($narracao['sinopse']);
				$eq->setGeneros($narracao['genero1'],$narracao['genero2']);
				$eq->setZoom($narracao['zoom']);
				$narracoes[] = $eq;
			}
			return $narracoes;
		}else{
			return "vazio";
		}
		
	}
	
	public function listarUm($id){
		$conexao = new MySQL();
		$sql = "select * from narracao where idNarracao=$id";
		$resultado = $conexao->consulta($sql);
		if($resultado){
			$eq = new Narracao('','','','','');
			$eq->setId($resultado[0]['idNarracao']);
			$eq->setTitulo($resultado[0]['titulo']);
			$eq->setIdUsuario($resultado[0]['idUsuario']);
			$eq->setAutor($resultado[0]['autor']);
			$eq->setCompartilhada($resultado[0]['compartilhada']);
			$eq->setSinopse($resultado[0]['sinopse']);
			$eq->setGeneros($resultado[0]['genero1'],$resultado[0]['genero2']);
			$eq->setZoom($resultado[0]['zoom']);
			return $eq;
		}else{
			return "vazio";
		}
		
	}
	
	public function listarComUsuario($id){
		$conexao = new MySQL();
		$sql = "SELECT * FROM usuario, narracao where usuario.idUsuario = narracao.idUsuario and usuario.idUsuario =  $id";
		$resultado = $conexao->consulta($sql);
		$narracoes = array();
		foreach($resultado as $narracao){
			$eq = new Narracao('','','','');
			$eq->setId($narracao['idNarracao']);
			$eq->setTitulo($narracao['titulo']);
			$eq->setIdUsuario($narracao['idUsuario']);
			$eq->setAutor($narracao['autor']);
			$eq->setCompartilhada($narracao['compartilhada']);
			$eq->setSinopse($narracao['sinopse']);
			$eq->setGeneros($narracao['genero1'],$narracao['genero2']);
			$eq->setZoom($narracao['zoom']);
			$narracoes[] = $eq;
		}
		return $narracoes;
		
	}
	
	public function inserir($narracao){
		$conexao = new MySQL();
		$sql = "insert into narracao (titulo,idUsuario,autor) values ('".$narracao->getTitulo()."','".$narracao->getIdUsuario()."','".$narracao->getAutor()."')";
		$resultado = $conexao->executa($sql);
		return $resultado;
	}
	
	
	public function alterar($narracao){
		$conexao = new MySQL();
		$sql = "update narracao set titulo = '".$narracao->getTitulo()."', idUsuario = '".$narracao->getIdUsuario()."', autor = '".$narracao->getAutor()."', compartilhada = ".$narracao->getCompartilhada().",zoom = ".$narracao->getZoom().", sinopse = '".$narracao->getSinopse()."', genero1 = '".$narracao->getGeneros()[0]."', genero2 = '".$narracao->getGeneros()[1]."' where idNarracao =  ".$narracao->getId();
		$resultado = $conexao->executa($sql);
		return $resultado;
	}
	
	public function excluir($narracao){
		$conexao = new MySQL();
		$sql = "delete from narracao where idNarracao = ".$narracao->getId();
		$resultado = $conexao->executa($sql);
		return $resultado;
	}
	
}

?>