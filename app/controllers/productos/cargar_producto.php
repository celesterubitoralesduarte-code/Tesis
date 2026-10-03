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

  // Limpia valores numéricos: sin puntos de miles y con coma como separador decimal
  $limpiarNumero = function ($valor) {
      $valor = trim((string) $valor);
      if ($valor === '') {
          return '';
      }
      if (strpos($valor, ',') !== false) {
          // Si viene con coma, los puntos son separadores de miles
          $valor = str_replace('.', '', $valor);
          $valor = str_replace(',', '.', $valor);
      } else {
          // Sin coma: el punto es separador decimal (ej: 59000.000, 72.00)
          $valor = str_replace(',', '', $valor);
      }
      $numero = (float) $valor;
      if (floor($numero) == $numero) {
          return (string) (int) $numero;
      }
      return rtrim(rtrim(number_format($numero, 2, ',', ''), '0'), ',');
  };

  // Extracción de datos de la consulta SQL del controlador
foreach ($productos_datos as $productos_dato) {
    $codigo = $productos_dato['codigo'];
    $nomProductos = $productos_dato['nomProductos'];
    $idTrabajadores = $productos_dato['idTrabajadores'];
    $stockProductos = $limpiarNumero($productos_dato['stockProductos']);
    $stockMinimo = $productos_dato['stockMinimo'];
    $precioCompra = $productos_dato['precioCompra'];
    $precioVenta = $productos_dato['precioVenta'];
    $fecha_ingreso = $productos_dato['fecha_ingreso'];
    $unidadMedida = $productos_dato['unidadMedida'];
    $usuarioTrabajador = $productos_dato['usuarioTrabajador'];
}