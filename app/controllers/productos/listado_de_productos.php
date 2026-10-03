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

  // Limpia los valores numéricos: sin puntos de miles y con coma como separador decimal
  foreach ($productos_datos as &$producto) {
      foreach (['stockProductos'] as $campo) {
          if (!isset($producto[$campo])) {
              continue;
          }
          $valor = trim((string) $producto[$campo]);
          if ($valor === '') {
              continue;
          }
          // Si viene con coma, los puntos son separadores de miles: se eliminan
          if (strpos($valor, ',') !== false) {
              $valor = str_replace('.', '', $valor);
              $valor = str_replace(',', '.', $valor);
          } else {
              // Sin coma: el punto es separador decimal (ej: 59000.000, 72.00)
              $valor = str_replace(',', '', $valor);
          }
          $numero = (float) $valor;
          if (floor($numero) == $numero) {
              $producto[$campo] = (string) (int) $numero;
          } else {
              // Formatear con coma decimal y sin puntos de miles
              $producto[$campo] = rtrim(rtrim(number_format($numero, 2, ',', ''), '0'), ',');
          }
      }
  }
  unset($producto);