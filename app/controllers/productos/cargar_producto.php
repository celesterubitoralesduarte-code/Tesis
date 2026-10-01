<?php

$idProductos_get = $_GET['id'];

 $sql_productos = "SELECT 
    p.idProductos, 
    p.codigo, 
    p.nomProductos,
    t.idTrabajadores as idTrabajadores, 
    p.stockProductos, 
    p.stockMinimo, 
    p.precioCompra, 
    p.precioVenta, 
    p.fecha_ingreso, 
    p.unidadMedida,
    t.usuarioTrabajador
FROM productos AS p
LEFT JOIN trabajadores as t on t.idTrabajadores = p.idTrabajadores 
WHERE idProductos = '$idProductos_get'";
  $squery_productos=$pdo->prepare($sql_productos);
  $squery_productos->execute();

  $productos_datos= $squery_productos->fetchAll(PDO::FETCH_ASSOC);
  // Extracción de datos de la consulta SQL del controlador
foreach ($productos_datos as $productos_dato) {
    $codigo = $productos_dato['codigo'];
    $nomProductos = $productos_dato['nomProductos'];
    $idTrabajadores = $productos_dato['idTrabajadores'];
    $stockProductos = $productos_dato['stockProductos'];
    $stockMinimo = $productos_dato['stockMinimo'];
    $precioCompra = $productos_dato['precioCompra'];
    $precioVenta = $productos_dato['precioVenta'];
    $fecha_ingreso = $productos_dato['fecha_ingreso'];
    $unidadMedida = $productos_dato['unidadMedida'];
    $usuarioTrabajador = $productos_dato['usuarioTrabajador'];
}