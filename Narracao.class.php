<?php 
	class Narracao{
		private $id;
		private $titulo;
		private $idUsuario;
		private $autor;
		private $compartilhada;
		private $sinopse;
		private $genero1;
		private $genero2;
		private $zoom;
		
		public function __construct($id,$titulo,$idUsuario,$autor,$compartilhada = 0,$genero1 = "---", $genero2 = '---', $zoom = 1){
			$this->id = $id;
			$this->titulo = $titulo;
			$this->idUsuario = $idUsuario;
			$this->autor = $autor;
			$this->compartilhada = $compartilhada;
			$this->sinopse = "";
			$this->genero1 = $genero2;
			$this->genero2 = $genero2;
			$this->zoom = $zoom;
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
		
		public function getIdUsuario(){
			return $this->idUsuario;
		}
		
		public function setIdUsuario($idUsuario){
			$this->idUsuario = $idUsuario;
		}
		
		public function getAutor(){
			return $this->autor;
		}
		
		public function setAutor($autor){
			$this->autor = $autor;
		}
		
		public function getCompartilhada(){
			return $this->compartilhada;
		}
		
		public function setCompartilhada($compartilhada){
			$this->compartilhada = $compartilhada;
		}
		
		public function getSinopse(){
			return $this->sinopse;
		}
		
		public function setSinopse($sinopse){
			$this->sinopse = $sinopse;
		}
		
		public function getGeneros(){
			$generos = array($this->genero1,$this->genero2);
			return $generos;
		}
		
		public function setGeneros($genero1, $genero2){
			$this->genero1 = $genero1;
			$this->genero2 = $genero2;
		}
		
		public function getZoom(){
			return $this->zoom;
		}
		
		public function setZoom($zoom){
			$this->zoom = $zoom;
		}
	}
?>