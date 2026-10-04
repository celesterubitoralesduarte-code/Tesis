<?php

include_once __DIR__ . '/../../config.php';

$sql_ventas = "SELECT * FROM ventas";

$squery_ventas = $pdo->prepare($sql_ventas);
$squery_ventas->execute();

$ventas_datos = $squery_ventas->fetchAll(PDO::FETCH_ASSOC);