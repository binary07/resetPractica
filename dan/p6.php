<?php 

echo "::::::::::::::::::::::::<br>";
//echo date("d-m-Y", strtotime('01-01-2019' . " + ".$dias." day")).'<br>';
echo "::::::::::::::::::::::::<br>";

$tolernciaInicio = 15;
$tolernciaSubsecuente = 4;
$totalDiasP = 365;

$primerPago = 0;

$folioP = 'pol9989668';
$conn = new PDO('mysql:host=localhost;dbname=seguros','root','abrir123');
$stmt = $conn->prepare("SELECT * from poliza inner join pago on poliza.fol_pol = pago.fol_pol where poliza.fol_pol = :fp order by pago.fecha asc");
$stmt->execute(array(':fp'=>$folioP));
$pagosBD = $stmt->fetchAll();
if ($pagosBD!=null) {
  $stmt->execute(array(':fp'=>$folioP));
  $pripag = $stmt->fetch();
  $primerPago = $pripag['cantidad'];
  echo $primerPago.'jajajajajajajaj<br>';
}

        $stmtVigencias = $conn->prepare("SELECT * from poliza where fol_pol = :np");
        $stmtVigencias->execute(array(':np'=>$folioP));
        $infoo = $stmtVigencias->fetch();
        $fecha1 = $infoo['vigencia_inicio'];
        $fecha2 = $infoo['vigencia_fin'];
        $prima = doubleval($infoo['prima']);

foreach ($pagosBD as $i => $value) {
  echo "Fecha ".$value['fecha'].' Abonó ' .$value['cantidad'].'<br>';
}    
       $p2=0;$ddd=0;
       $tp = $infoo['tipo_pago'];
       $ddd = doubleVal($prima-$primerPago);
       if ($tp=='mensual') {
       	$pagos = 12;
          if ($primerPago == 0) { $p2 = doubleVal($ddd/$pagos);
            $primerPago = $p2;
          }else{$p2 = doubleVal($ddd/($pagos-1));}
       }elseif ($tp=='trimestral') {
       	$pagos = 4;
          if ($primerPago == 0) { $p2 = doubleVal($ddd/$pagos);
            $primerPago = $p2;
          }else{$p2 = doubleVal($ddd/($pagos-1));}
       }elseif ($tp=='semestral') {
       	$pagos = 2;
          if ($primerPago == 0) { $p2 = doubleVal($ddd/$pagos);
            $primerPago = $p2;
          }else{$p2 = doubleVal($ddd/($pagos-1));}
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
       


        if ($pagosBD!=null) {//si hay pago
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
       }else{
          for ($i=0; $i < sizeof($fechasPago); $i++) { 
          if ($i==0) {$tl = $tolernciaInicio; $pague = $data['primerPago'];
          }else{$tl = $tolernciaSubsecuente;$pague = $data['pagosDe'];} $pagado = 0; $recibio = 'Aún no se realiza el pago';$fp = 'No hay registro';
          echo "<b>Pago </b>".++$i.' <b>Fecha de Pago </b>'.$fechasPago[--$i].'<b>, Se aceptan pagos hasta </b>'.date("Y-m-d", strtotime($fechasPago[$i] . " + ".$tl." day")).'<b>, Monto $ </b>'.$pague.' <b>Estatus</b> '.$pagado.' <b>Recibió</b> '.$recibio.' <b>Fecha</b> '.$fp.'<br>';
          }
       }
       echo ":::::::::::::::::::::::::::::::::<br>";
      