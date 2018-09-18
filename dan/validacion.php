<?php 
/**
 * 
 */
class Valida
{
	/* funcion que quita caracteres especiales y convierte a minusculatodo */
	static public function quitarCaracteres($texto){
		$texto = filter_var(strtolower($texto), FILTER_SANITIZE_STRING);
		return $texto;
	}
	/* funcion que permite caracteres especiales pero evita laejecucion de los mismos */
	static public function inhabilitarCaracteres($texto)
	{
		$texto = htmlspecialchars($texto);
		return $texto;
	}
	/* funcion que valida si un parrafo es valido al tamaño de caracteres */
	static public function textoValido($texto,$caracteres)
	{
		return $texto;
	}
	/* funcion que valida una palabra  */
	
	static public function palabraValida($pwd){

		return false;
	}
	static public function pwdValido($pwd){
		
		return false;
	}
	/* funcion para limpiar correo */
	static public function limpiarCorreo($correo)
	{
		$correo = filter_var(strtolower($correo, FILTER_SANITIZE_EMAIL));
		return $correo;
	}
	/* funcion para validar el numero de caracteres */
	static public function valTamaño($text,$n1,$n2)
	{
		if (strlen($text)>=abs($n1)&&strlen($text)<=abs($n2)) {
			return true;
		}else{
			return false;
		}
	}
	static public function valFRecepcion($fr)
	{
		$hoy = strtotime('01-09-2018');
		$fr = strtotime($fr);
		if ($fr>=$hoy) {
			return true;
		}else{
			return false;
		}
	}
	/* Validar telefonos a 10 digitos */
	static public function limpiarTelefono($t)
	{
		$tel = str_replace("-", "", $t);
		$tel = str_replace("(", "", $tel);
		$tel = str_replace(")", "", $tel);
		$tel = str_replace(" ", "", $tel);
		return $tel;
	}
	
	
}


$var = new Valida();
echo var_dump($var->valFRecepcion('2018-09-01'));

