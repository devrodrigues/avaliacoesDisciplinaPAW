<?php
function calculaCompra($clientes, $compras) {
	$comprasMes = array();
	for($i = 0; $i < count($clientes); $i ++){
		if(array_key_exists($clientes[$i], $comprasMes)){
			$comprasMes[$clientes[$i]] += $compras[$i];			
		} else {
			$comprasMes[$clientes[$i]] = $compras[$i];
		}

	}

	print_r($comprasMes);
}

$clientes = array(1, 2, 1, 3, 2, 3, 1, 4, 1);
$compras = array(19.22, 30.22, 5.99, 200.89, 54.00, 79.23, 13.45, 13.05, 100.19);
calculaCompra($clientes, $compras);
?>