<?php 
	class Avaliacao{
		private $id;
		private $idNarracao;
		private $idUsuario;
		private $avaliacao;
		
		public function __construct($id,$idNarracao,$idUsuario,$avaliacao){
			$this->id = $id;
			$this->idNarracao = $idNarracao;
			$this->idUsuario = $idUsuario;
			$this->avaliacao = $avaliacao;
		}
		
		public function getId(){
			return $this->id;
		}
		
		public function setId($id){
			$this->id = $id;
		}
		
		public function getIdNarracao(){
			return $this->idNarracao;
		}
		
		public function setIdNarracao($idNarracao){
			$this->idNarracao = $idNarracao;
		}
		
		public function getIdUsuario(){
			return $this->idUsuario;
		}
		
		public function setIdUsuario($idUsuario){
			$this->idUsuario = $idUsuario;
		}
		
		public function getAvaliacao(){
			return $this->avaliacao;
		}
		
		public function setAvaliacao($avaliacao){
			$this->avaliacao = $avaliacao;
		}	
		
	}
?>