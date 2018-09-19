<?php
class Conexion{
	static public function conectar(){
		$conex = new PDO("mysql:host=localhost;dbname=seguros",
			            "root",
			            "abrir123");
		//$conex->exec("set names utf8");
		return $conex;
	}
}