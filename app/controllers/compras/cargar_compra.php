<?php

include_once __DIR__ . '/../../config.php';

$id_compra_get = $_GET['id'] ?? null;

$sql_compras = "SELECT 
    co.id_compra as id_compra,
    co.idProductos as idProductos,
    co.nro_compra as nro_compra,
    co.fecha_compra as fecha_compra,
    co.idProveedores as idProveedores,
    co.comprobante as comprobante,
    co.idTrabajadores as idTrabajadores,
    co.precio_compra as precio_compra,
    co.cantidad as cantidad,
    pro.codigo as codigo,
    pro.nomProductos as nombre_producto,
    pro.stockProductos as stock,
    pro.stockMinimo as stock_minimo,
    pro.precioCompra as precio_compra_producto,
    pro.precioVenta as precio_venta,
    pro.fecha_ingreso as fecha_ingreso,
    pro.unidadMedida as unidad_medida,
    t.NomTrabajadores as nombre_usuario,
    prov.nombre_proveedor as nombre_proveedor, 
    prov.celular as celular_proveedor, 
    prov.telefono as telefono_proveedor,
    prov.empresa as empresa,
    prov.email as email_proveedor,
    prov.direccion as direccion_proveedor, 
    prov.rucProveedores as ruc_proveedor
FROM tb_compras as co 
INNER JOIN productos as pro ON co.idProductos = pro.idProductos
INNER JOIN trabajadores as t ON co.idTrabajadores = t.idTrabajadores
INNER JOIN proveedores as prov ON co.idProveedores = prov.idProveedores
WHERE co.id_compra = :id_compra
ORDER BY co.id_compra ASC";

$squery_compras = $pdo->prepare($sql_compras);
$squery_compras->execute([':id_compra' => $id_compra_get]);

$compras_datos = $squery_compras->fetchAll(PDO::FETCH_ASSOC);

foreach ($compras_datos as $compras_dato){
    $id_compra = $compras_dato['id_compra'];
    $idProductos = $compras_dato['idProductos'];
    $nro_compra = $compras_dato['nro_compra'];
    $codigo = $compras_dato['codigo'];
    $nombre_producto = $compras_dato['nombre_producto'];
    $nombre_usuario = $compras_dato['nombre_usuario'];
   
   // Formatear precios sin decimales y con punto (.) como separador de miles
    $precio_compra_producto = number_format($compras_dato['precio_compra_producto'], 0, ',', '.');
    $precio_venta = number_format($compras_dato['precio_venta'], 0, ',', '.');
   $fecha_ingreso = !empty($compras_dato['fecha_ingreso']) 
        ? date('d/m/Y', strtotime($compras_dato['fecha_ingreso'])) 
        : '';
   // Obtenemos la unidad de medida real de la base de datos
    $unidad_medida = $compras_dato['unidad_medida'] ?? 'Kilogramos (Kg)';

    // Determinamos la abreviatura (Kg, g, Und)
    switch ($unidad_medida) {
        case 'Gramos (g)':
            $sigla = 'g';
            break;
        case 'Unidades (Und)':
            $sigla = 'Und';
            break;
        default:
            $sigla = 'Kg';
            break;
    }

    // Limpiamos los ceros decimales del stock y le pegamos la abreviatura
    $stock = floatval($compras_dato['stock']) . ' ' . $sigla;
    $stock_minimo = floatval($compras_dato['stock_minimo']) . ' ' . $sigla;
    $cantidad = floatval($compras_dato['cantidad']) . ' ' . $sigla;

    $idProveedores_tabla = $compras_dato['idProveedores'];
    $nombre_proveedor_tabla = $compras_dato['nombre_proveedor'];
    $celular_proveedor = $compras_dato['celular_proveedor'];
    $telefono_proveedor = $compras_dato['telefono_proveedor'];
    $empresa = $compras_dato['empresa'];
    $email_proveedor = $compras_dato['email_proveedor'];
    $ruc_proveedor = $compras_dato['ruc_proveedor'];
    $direccion_proveedor = $compras_dato['direccion_proveedor'];

    $nro_compra = $compras_dato['nro_compra'];
    $fecha_compra = $compras_dato['fecha_compra'];
    $comprobante = $compras_dato['comprobante'];
    $precio_compra = $compras_dato['precio_compra'];
    $fecha_compra = $compras_dato['fecha_compra'];
    
   
}
?>