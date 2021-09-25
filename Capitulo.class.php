<?php 
	class Capitulo{
		private $id;
		private $titulo;
		private $conteudo;
		private $idNarracao;
		private $inicial;
		private $posX;
		private $posY;
		
		public function __construct($id,$titulo,$conteudo,$idNarracao, $inicial, $posX = null, $posY = null){
			$this->id = $id;
			$this->titulo = $titulo;
			$this->conteudo = $conteudo;
			$this->idNarracao = $idNarracao;
			$this->inicial = $inicial;
		}
		
		public function setId($id){
			$this->id = $id;
		}
		
		public function getId(){
			return $this->id;
		}
		
		public function getTitulo(){
			return $this->titulo;
		}
		
		public function setTitulo($titulo){
			$this->titulo = $titulo;
		}
		
		public function getConteudo(){
			return $this->conteudo;
		}
		
		public function setConteudo($conteudo){
			$this->conteudo = $conteudo;
		}
		
		public function getIdNarracao(){
			return $this->idNarracao;
		}
		
		public function setIdNarracao($idNarracao){
			$this->idNarracao = $idNarracao;
		}
		
		public function getInicial(){
			return $this->inicial;
		}
		
		public function setInicial($inicial){
			$this->inicial = $inicial;
		}
		
		public function getPosX(){
			return $this->posX;
		}
		
		public function setPosX($posX){
			$this->posX = $posX;
		}
		
		public function getPosY(){
			return $this->posY;
		}
		
		public function setPosY($posY){
			$this->posY = $posY;
		}
	}
?>