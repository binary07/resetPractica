<?php 
/*$stmt = new PDO('mysql:host=localhost;dbname=falcon','root','abrir123');
echo "Conectado<br>";
$query = $stmt->prepare("SELECT count(folio_ordencompra) from ordendcompra where solicitante = :n");
		$query->execute(array(':n'=>'Dan Cabrera Teotan'));
$query = $query->fetchColumn();
echo 'cantidadad: '.abs($query);

if ($query) {
    echo "Si encontre lo que pediste -> No puede registrar : error";
 } else {
    echo "No  encontre -> puede registrar : ok";
 }
*/



$conn = new PDO('mysql:host=localhost;dbname=seguros','root','abrir123');
echo "Conectado<br>";
$stmt = $conn->prepare("SELECT vigencia_fin from poliza where num_pol = :np order by vigencia_fin desc");
		$stmt->execute(array(':np'=>'asd123'));
		$stmt = $stmt->fetch();

echo 'valor: '.$stmt['vigencia_fin'];
