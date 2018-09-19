<?php require_once 'conexion.php';
$tolernciaInicio = 15;
$tolernciaSubsecuente = 4;
$totalDiasP = 365;
$pagos = 1;
$primerPago = 0;
$f = 'pol5547493';
$f = 'pol9989668';
$stmt = Conexion::conectar()->prepare("SELECT * from poliza inner join pago on poliza.fol_pol = pago.fol_pol where poliza.fol_pol = :fp order by pago.fecha asc");
$stmt->execute(array(':fp'=>$f));
$pagosBD = $stmt->fetchAll();
if ($pagosBD!=null) {
  $stmt->execute(array(':fp'=>$f));
  $pripag = $stmt->fetch();
  $primerPago = $pripag['cantidad'];
}

        $stmtVigencias = Conexion::conectar()->prepare("SELECT * from poliza where fol_pol = :fp");
        $stmtVigencias->execute(array(':fp'=>$f));
        $infoo = $stmtVigencias->fetch();
        $fecha1 = $infoo['vigencia_inicio'];
        $fecha2 = $infoo['vigencia_fin'];
        $prima = doubleval($infoo['prima']);
  
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
        echo "Cálculo de Pagos<br>";
        var_dump($data);

        echo "<br>::::::::::::::::::::::::::::.<br>";
      
        $dias =  intval($totalDiasP / $pagos);
        echo "Cada $dias días, Fechas de Pago<br>";
        $cont = 0;
        for ($i=0; $i < $pagos; $i++) { 
          $fechasPago[$i]= date("Y-m-d", strtotime($fecha1 . " + ".$cont." day"));
          $cont = $cont + $dias;
        }
        var_dump($fechasPago);
        echo "<br>::::::::::::::::::::::::<br>";
       

        if ($pagosBD!=null) {//si hay pago
        foreach ($pagosBD as $i => $v) {
        	echo "Fecha ".$v['fecha'].' Abonó ' .$v['cantidad'].'<br>';
          if ($i==0) {$tl = $tolernciaInicio; $pague = $data['primerPago'];
          }else{$tl = $tolernciaSubsecuente;$pague = $data['pagosDe'];} 
          if ($v['fecha']>=$fechasPago[$i]&&$v['fecha']<=date("Y-m-d", strtotime($fechasPago[$i] . " + ".$tl." day"))) {
            $pagado = 'Pagado';
            $recibio = $v['usuario_mov'];
            $fp = $v['fecha'];
          }else{$pagado = 'No Pagado'; $recibio = 'Aún no se realiza el pago';$fp = 'No hay registro';}
          echo "<b>Pago </b>".++$i.' <b>Fecha de Pago </b>'.$fechasPago[--$i].'<b>, Se aceptan pagos hasta </b>'.date("Y-m-d", strtotime($fechasPago[$i] . " + ".$tl." day")).'<b>, Monto $ </b>'.$pague.' <b>Estatus</b> '.$pagado.' <b>Recibió</b> '.$recibio.' <b>Fecha</b> '.$fp.'<br>';
        }
       }else{
          for ($i=0; $i < sizeof($fechasPago); $i++) { 
          if ($i==0) {$tl = $tolernciaInicio; $pague = $data['primerPago'];
          }else{$tl = $tolernciaSubsecuente;$pague = $data['pagosDe'];} $pagado = 'No Pagado'; $recibio = 'Aún no se realiza el pago';$fp = 'No hay registro';
          echo "<b>Pago </b>".++$i.' <b>Fecha de Pago </b>'.$fechasPago[--$i].'<b>, Se aceptan pagos hasta </b>'.date("Y-m-d", strtotime($fechasPago[$i] . " + ".$tl." day")).'<b>, Monto $ </b>'.$pague.' <b>Estatus</b> '.$pagado.' <b>Recibió</b> '.$recibio.' <b>Fecha</b> '.$fp.'<br>';
          }
       }
       echo ":::::::::::::::::::::::::::::::::<br>";
        for ($i=0; $i < sizeof($fechasPago); $i++) {
   		  
          if ($i==0) {$tl = $tolernciaInicio; $pague = $data['primerPago'];
          }else{$tl = $tolernciaSubsecuente;$pague = $data['pagosDe'];} 

          if ($pagosBD!=null) {
          if ($v['fecha']>=$fechasPago[$i]&&$v['fecha']<=date("Y-m-d", strtotime($fechasPago[$i] . " + ".$tl." day"))) {
            $pagado = 'Pagado';
            $recibio = $v['usuario_mov'];
            $fp = $v['fecha'];
          }else{$pagado = 'No Pagado'; $recibio = 'Aún no se realiza el pago';$fp = 'No hay registro';}
      }else{
      	$pagado = 'No Pagado'; $recibio = 'Aún no se realiza el pago';$fp = 'No hay registro';
      } 
          echo "<b>Pago </b>".++$i.' <b>Fecha de Pago </b>'.$fechasPago[--$i].'<b>, Se aceptan pagos hasta </b>'.date("Y-m-d", strtotime($fechasPago[$i] . " + ".$tl." day")).'<b>, Monto $ </b>'.$pague.' <b>Estatus</b> '.$pagado.' <b>Recibió</b> '.$recibio.' <b>Fecha</b> '.$fp.'<br>';
        }
       echo 'Numero de pago en el que esta: '.sizeof($pagosBD).'<br>';