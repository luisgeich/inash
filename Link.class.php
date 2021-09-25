<?php 
	class Link{
		private $idLink;
		private $idOrigem;
		private $idDestino;
		private $escolha;
		private $idNarracao;
		
		public function __construct($idLink,$idOrigem,$idDestino,$escolha,$idNarracao){
			$this->idOrigem = $idOrigem;
			$this->idLink = $idLink;
			$this->idDestino = $idDestino;
			$this->escolha = $escolha;
			$this->idNarracao = $idNarracao;
		}
		
		public function setId($idLink){
			$this->idLink = $idLink;
		}
		
		public function getId(){
			return $this->idLink;
		}
		
		public function setIdOrigem($idOrigem){
			$this->idOrigem = $idOrigem;
		}
		
		public function getIdOrigem(){
			return $this->idOrigem;
		}
		
		public function getIdDestino(){
			return $this->idDestino;
		}
		
		public function setIdDestino($idDestino){
			$this->idDestino = $idDestino;
		}
		
		public function getEscolha(){
			return $this->escolha;
		}
		
		public function setEscolha($escolha){
			$this->escolha = $escolha;
		}
		
		public function getIdNarracao(){
			return $this->idNarracao;
		}
		
		public function setIdNarracao($idNarracao){
			$this->idNarracao = $idNarracao;
		}	
	}
?>