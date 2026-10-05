<?php
// app/controllers/ventas/ver_venta.php

if (isset($_GET['id'])) {
    $id_venta_get = $_GET['id'];

    // 1. Consultar los datos principales de la venta y del cliente
    $sql_venta = "SELECT 
                    v.*, 
                    v.nro_venta,
                    c.nombre_cliente, 
                    c.ruc_ci_cliente, 
                    c.celular_cliente, 
                    c.email_cliente 
                  FROM ventas AS v 
                  LEFT JOIN clientes AS c ON v.id_cliente = c.id_cliente 
                  WHERE v.id_ventas = :id_ventas";
    
    $query_venta = $pdo->prepare($sql_venta);
    $query_venta->execute([':id_ventas' => $id_venta_get]);
    $venta_datos = $query_venta->fetch(PDO::FETCH_ASSOC);

    // Si no existe la venta, redirigir al listado
    if (!$venta_datos) {
        header('Location: ' . $URL . '/ventas/index.php'); // Ajusta tu ruta de redirección si es necesario
        exit();
    }

    // El número de venta (usando id_ventas si nro_venta es 0 o vacio)
    $nro_venta = !empty($venta_datos['nro_venta']) && $venta_datos['nro_venta'] != 0 ? $venta_datos['nro_venta'] : $venta_datos['id_ventas'];
    $nombre_cliente = !empty($venta_datos['nombre_cliente']) ? $venta_datos['nombre_cliente'] : 'Cliente Ocasional / S/N';
    $ruc_ci_cliente = !empty($venta_datos['ruc_ci_cliente']) ? $venta_datos['ruc_ci_cliente'] : 'S/N';
    $celular_cliente = !empty($venta_datos['celular_cliente']) ? $venta_datos['celular_cliente'] : 'No registrado';
    $email_cliente = !empty($venta_datos['email_cliente']) ? $venta_datos['email_cliente'] : 'No registrado';
    $fecha_venta = date('d/m/Y H:i', strtotime($venta_datos['fyh_creacion']));

    // 2. Consultar los productos detallados que compró este cliente
    $sql_detalles = "SELECT dt.cantidad, p.nomProductos, p.precioVenta 
                     FROM tb_detalle_ventas AS dt 
                     INNER JOIN productos AS p ON dt.idProductos = p.idProductos 
                     WHERE dt.id_ventas = :id_ventas";
    $query_detalles = $pdo->prepare($sql_detalles);
    $query_detalles->execute([':id_ventas' => $id_venta_get]);
    $detalles_productos = $query_detalles->fetchAll(PDO::FETCH_ASSOC);
}