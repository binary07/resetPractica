<?php 

$pwd  = 'crisTo0206' ;

$encriptar = crypt($pwd, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
echo "Encriptado: $pwd : ".$encriptar;
$desencriptar = decrypt($encriptar,'$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
echo "Desencriptar: $encriptar : ". $desencriptar;
echo "OK.";
 ?>