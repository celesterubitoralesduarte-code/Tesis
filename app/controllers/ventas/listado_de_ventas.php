<?php

include_once __DIR__ . '/../../config.php';

$sql_ventas = "SELECT * FROM ventas";

$squery_ventas = $pdo->prepare($sql_ventas);
$squery_ventas->execute();

// 1. Consultar el último nro_venta registrado
$sql_max = "SELECT MAX(nro_venta) AS ultimo_nro FROM ventas";
$query_max = $pdo->prepare($sql_max);
$query_max->execute();
$resultado = $query_max->fetch(PDO::FETCH_ASSOC);

// 2. Calcular el siguiente número (si es null, empieza en 1)
$siguiente_nro = ($resultado['ultimo_nro']) ? $resultado['ultimo_nro'] + 1 : 1;

// 3. Incluir $siguiente_nro en tu sentencia INSERT de la venta

$ventas_datos = $squery_ventas->fetchAll(PDO::FETCH_ASSOC);