<?php  
$f1 = '09/01/2018';
$f2 = '09/19/2018';
$fecha1 = new DateTime($f1.' 00:00:00');//fecha inicial
$fecha2 = new DateTime($f2.' 00:00:00');//fecha de cubrid_error_code()
$dias = $fecha2->diff($fecha1);


echo $dias->format('%Y años %m meses %d days %H horas %i minutos 
%s segundos');//00 años 0 meses 0 días 08 horas 0 minutos 0 segundos
echo "<br>";
echo $dias->format('%d');
echo "<br>";
echo strtotime($f1);
