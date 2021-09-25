<?php
include_once "Capitulo.class.php";
include_once "MySQL.class.php";


class ControleCapitulo{
	
	public function acaoUsuario($acao,$capitulo){
		
		if($acao=="inserir"){
			$this->inserir($capitulo);
		}else if($acao=="alterar"){
			$this->alterar($capitulo);
		}else if($acao=="excluir"){
			$this->excluir($capitulo);
		}	
	}
	
	public function listarTodos(){
		$conexao = new MySQL();
		$sql = "select * from capitulo";
		$resultado = $conexao->consulta($sql);
		if($resultado){
			$capitulos = array();
			foreach($resultado as $capitulo){
				$eq = new Capitulo('','','','','','','');
				$eq->setId($capitulo['idCapitulo']);
				$eq->setTitulo($capitulo['titulo']);
				$eq->setConteudo($capitulo['conteudo']);
				$eq->setIdNarracao($capitulo['idNarracao']);
				$eq->setInicial($capitulo['inicial']);
				$eq->setPosX($capitulo['posX']);
				$eq->setPosY($capitulo['posY']);
				$capitulos[] = $eq;
			}
			return $capitulos;
		}else{
			return "vazio";
		}
		
	}
	
	public function listarUm($id){
		$conexao = new MySQL();
		$sql = "select * from capitulo where idCapitulo=$id";
		$resultado = $conexao->consulta($sql);
		if($resultado){
			$eq = new Capitulo('','','','','');
			$eq->setId($resultado[0]['idCapitulo']);
			$eq->setTitulo($resultado[0]['titulo']);
			$eq->setConteudo($resultado[0]['conteudo']);
			$eq->setIdNarracao($resultado[0]['idNarracao']);
			$eq->setInicial($resultado[0]['inicial']);
			$eq->setPosX($resultado[0]['posX']);
			$eq->setPosY($resultado[0]['posY']);
			return $eq;
		}else{
			return "vazio";
		}
		
	}
	
	public function listarComNarracao($id){
		$conexao = new MySQL();
		$sql = "SELECT * FROM narracao, capitulo where narracao.idNarracao = capitulo.idNarracao and narracao.idNarracao =  $id";
		$resultado = $conexao->consulta($sql);
		$capitulos = array();
		foreach($resultado as $capitulo){
			$eq = new Capitulo('','','','','');
			$eq->setId($capitulo['idCapitulo']);
			$eq->setTitulo($capitulo['titulo']);
			$eq->setConteudo($capitulo['conteudo']);
			$eq->setInicial($capitulo['inicial']);
			$eq->setPosX($capitulo['posX']);
			$eq->setPosY($capitulo['posY']);
			$capitulos[] = $eq;
		}
		return $capitulos;
		
	}
	
	public function inserir($capitulo){
		$conexao = new MySQL();
		$sql = "insert into capitulo (titulo,conteudo, idNarracao,inicial) values ('".$capitulo->getTitulo()."','".$capitulo->getConteudo()."','".$capitulo->getIdNarracao()."','".$capitulo->getInicial()."')";
		$resultado = $conexao->executa($sql);
		return $resultado;
	}
	
	
	public function alterar($capitulo){
		$conexao = new MySQL();
		$sql = "update capitulo set titulo = '".$capitulo->getTitulo()."', conteudo = '".$capitulo->getConteudo()."', idNarracao = '".$capitulo->getIdNarracao()."', inicial = '".$capitulo->getInicial()."' where idCapitulo =  ".$capitulo->getId();
		$resultado = $conexao->executa($sql);
		
		if (! $capitulo->getPosX() == null){ //Caso o posX for nulo o php ira salva-lo no banco como 0;
			$altera_posX = "update capitulo set posX = '". $capitulo->getPosX()."' where idCapitulo = ".$capitulo->getId();
			$conexao->executa($altera_posX);
		}else{
			$altera_posX = "update capitulo set posX = null where idCapitulo = ".$capitulo->getId();
			$conexao->executa($altera_posX);
		}
		
		if (! $capitulo->getPosY() == null){ //Caso o posY for nulo o php ira salva-lo no banco como 0;
			$altera_posY = "update capitulo set posY = '". $capitulo->getPosY()."' where idCapitulo = ".$capitulo->getId();
			$conexao->executa($altera_posY);
		}else{
			$altera_posY = "update capitulo set posY = null where idCapitulo = ".$capitulo->getId();
			$conexao->executa($altera_posY);
		}
		
		return $resultado;
	}
	
	public function excluir($capitulo){
		$conexao = new MySQL();
		$sql = "delete from capitulo where idCapitulo = ".$capitulo->getId();
		$resultado = $conexao->executa($sql);
		return $resultado;
	}
	
}

?>