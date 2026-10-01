<?php

include_once __DIR__ . '/../../config.php';

$sql_compras = "SELECT 
    co.id_compra as id_compra,
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
INNER JOIN proveedores as prov ON co.idProveedores = prov.idProveedores";

$squery_compras = $pdo->prepare($sql_compras);
$squery_compras->execute();

$compras_datos = $squery_compras->fetchAll(PDO::FETCH_ASSOC);