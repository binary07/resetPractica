<?php 

echo "::::::::::::::::::::::::<br>";
//echo date("d-m-Y", strtotime('01-01-2019' . " + ".$dias." day")).'<br>';
echo "::::::::::::::::::::::::<br>";
$fecha1 = '2018-01-01';
$fecha2 = '2019-01-01';
$tolernciaInicio = 15;
$tolernciaSubsecuente = 4;
$totalDiasP = 365;
$prima = 120;
$primerPago = 60;

$conn = new PDO('mysql:host=localhost;dbname=seguros','root','abrir123');
$stmt = $conn->prepare("SELECT * from pago where fol_pol = :np");
    $stmt->execute(array(':np'=>'pol-0001'));
    $pagosBD = $stmt->fetchAll();

foreach ($pagosBD as $value) {
  echo "Fecha ".$value['fecha'].' Abonó ' .$value['cantidad'].'<br>';
}
echo "::::::::::::::::::::::::<br>";
       //$derechop = doubleval($datos['dp']);
       //$derechop = 200;
       $p2=0;$ddd=0; $kk=0;
       //$tipopagop = $datos['tipo_pago'];//semestral
       $tp = 'semestral';
       $ddd = doubleVal($prima-$primerPago);
       if ($tp=='mensual') {
       	$pagos = 12;
       	$p2 = doubleVal($ddd/($pagos-1));
       }elseif ($tp=='trimestral') {
       	$pagos = 4;
       	$p2 = doubleVal($ddd/($pagos-1));
       }elseif ($tp=='semestral') {
       	$pagos = 2;
       	$p2 = doubleVal($ddd/($pagos-1));
       }elseif ($tp=='anual') {
       	$pagos = 1;
        $p2 = 0;
       }
        
        $data = array('totalPagos'=>$pagos,
        			'primerPago'=>$primerPago,
        			'pagosDe'=>$p2);
        var_dump($data);
        echo "<br>::::::::::::::::::::::::::::.<br>";
        echo "fechas de pago<br>";
        
        $dias =  intval($totalDiasP / $pagos);
        echo "Cada cuantos dias: $dias <br>";
        $cont = 0;
        for ($i=0; $i < $pagos; $i++) { 
          $fechasPago[$i]= date("Y-m-d", strtotime($fecha1 . " + ".$cont." day"));
          $cont = $cont + $dias;
        }
        //echo "Fechas: <br>";
        echo var_dump($fechasPago);
        echo "<br>::::::::::::::::::::::::<br>";
        $fx = '2018-01-05';//
        $fy = $fechasPago[0]; $pagado = 0;




        foreach ($pagosBD as $i => $v) {
          if ($i==0) {$tl = $tolernciaInicio; $pague = $data['primerPago'];
          }else{$tl = $tolernciaSubsecuente;$pague = $data['pagosDe'];} 
          if ($v['fecha']>=$fechasPago[$i]&&$v['fecha']<=date("Y-m-d", strtotime($fechasPago[$i] . " + ".$tl." day"))&&$v['cantidad']>=$data['pagosDe']) {
            $pagado = 1;
            $recibio = $v['usuario_mov'];
            $fp = $v['fecha'];
          }else{$pagado = 0; $recibio = 'Aún no se realiza el pago';$fp = 'No hay registro';}
          echo "<b>Pago </b>".++$i.' <b>Fecha de Pago </b>'.$fechasPago[--$i].'<b>, Se aceptan pagos hasta </b>'.date("Y-m-d", strtotime($fechasPago[$i] . " + ".$tl." day")).'<b>, Monto $ </b>'.$pague.' <b>Estatus</b> '.$pagado.' <b>Recibió</b> '.$recibio.' <b>Fecha</b> '.$fp.'<br>';
        }