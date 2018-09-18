<?php 
$fechauno = '18-01-2018';
$fechados = '10-02-2018';
echo "Con while <br>";

$fechaaamostar = $fechauno;
while(strtotime($fechados) >= strtotime($fechauno)){
	if(strtotime($fechados) != strtotime($fechaaamostar)){
		echo "$fechaaamostar<br />";
	$fechaaamostar = date("d-m-Y", strtotime($fechaaamostar . " + 1 day"));
	}else{
		echo "$fechaaamostar<br />";
	break;}	
	}
	$dias = 9;
echo "::::::::::::::::::::::::<br>";
echo date("d-m-Y", strtotime('01-01-2019' . " + ".$dias." day")).'<br>';
echo "::::::::::::::::::::::::<br>";

echo "Con For <br>";
$fechaInicio=strtotime("18-01-2018");
$fechaFin=strtotime("10-02-2018");
for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
    echo date("d-m-Y", $i)."<br>";
}

