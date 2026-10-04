<?php

include_once __DIR__ . '/../../config.php';

$sql_productos = "SELECT 
    p.idProductos, 
    p.codigo, 
    p.nomProductos, 
    p.stockProductos, 
    p.stockMinimo, 
    p.precioCompra, 
    p.precioVenta, 
    p.fecha_ingreso, 
    p.unidadMedida,
    t.usuarioTrabajador
FROM productos AS p
LEFT JOIN trabajadores as t on t.idTrabajadores = p.idTrabajadores ";

$squery_productos = $pdo->prepare($sql_productos);
$squery_productos->execute();

$productos_datos = $squery_productos->fetchAll(PDO::FETCH_ASSOC);

// Limpia los valores numéricos de ambos stocks
foreach ($productos_datos as &$producto) {
    // AGREGAMOS 'stockMinimo' AL ARRAY
    foreach (['stockProductos', 'stockMinimo'] as $campo) {
        if (!isset($producto[$campo])) {
            continue;
        }
        $valor = trim((string) $producto[$campo]);
        if ($valor === '') {
            continue;
        }
        if (strpos($valor, ',') !== false) {
            $valor = str_replace('.', '', $valor);
            $valor = str_replace(',', '.', $valor);
        } else {
            $valor = str_replace(',', '', $valor);
        }
        $numero = (float) $valor;
        if (floor($numero) == $numero) {
            $producto[$campo] = (string) (int) $numero;
        } else {
            $producto[$campo] = rtrim(rtrim(number_format($numero, 2, ',', ''), '0'), ',');
        }
    }
}
unset($producto);