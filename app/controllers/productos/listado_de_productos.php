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
  $squery_productos=$pdo->prepare($sql_productos);
  $squery_productos->execute();

  $productos_datos= $squery_productos->fetchAll(PDO::FETCH_ASSOC);