<?php
include('../../config.php');

$id_ventas_temp = $_POST['id_ventas'] ?? '';
$id_cliente     = $_POST['id_cliente'] ?? '';
$total_pagado   = $_POST['total_pagado'] ?? 0;
$fyh_creacion   = date('Y-m-d H:i:s');

$total_pagado = round((float)$total_pagado);

// Si el cajero dejó vacío el campo cliente, asignamos automáticamente el ID 1 (Cliente Ocasional / S/N)
if (empty($id_cliente)) {
    $id_cliente = 1; 
}

$total_pagado = (float)$total_pagado;

if (empty($id_ventas_temp) || $total_pagado <= 0) {
    echo "error_datos";
    exit;
}

try {
    // Iniciamos la transacción SQL para garantizar integridad de datos
    $pdo->beginTransaction();

    // 1. Obtener los productos cargados en el carrito temporal primero para validar stock
    $query_carrito = $pdo->prepare("SELECT * FROM tb_carrito WHERE id_ventas = :id_ventas");
    $query_carrito->execute([':id_ventas' => $id_ventas_temp]);
    $items = $query_carrito->fetchAll(PDO::FETCH_ASSOC);

    if (count($items) == 0) {
        $pdo->rollBack();
        echo "carrito_vacio";
        exit;
    }

    // Validar stock disponible antes de registrar la venta
    foreach ($items as $item) {
        $idProductos = $item['idProductos'];
        $cantidad    = (float)$item['cantidad'];

        $check_stock = $pdo->prepare("SELECT stockProductos FROM productos WHERE idProductos = :idProductos");
        $check_stock->execute([':idProductos' => $idProductos]);
        $producto = $check_stock->fetch(PDO::FETCH_ASSOC);

        if (!$producto || $producto['stockProductos'] < $cantidad) {
            $pdo->rollBack();
            echo "stock_insuficiente";
            exit;
        }
    }

    // 2. Insertar la cabecera en la tabla 'ventas'
    $sentencia_venta = $pdo->prepare("INSERT INTO ventas (id_cliente, total_pagado, fyh_creacion) 
                                        VALUES (:id_cliente, :total_pagado, :fyh_creacion)");
    $sentencia_venta->execute([
        ':id_cliente'   => $id_cliente,
        ':total_pagado' => $total_pagado,
        ':fyh_creacion' => $fyh_creacion
    ]);

    // Obtenemos el ID oficial de la venta guardada
    $id_venta_oficial = $pdo->lastInsertId();

    foreach ($items as $item) {
        $idProductos = $item['idProductos'];
        $cantidad    = (float)$item['cantidad'];

        // 3. Registrar en la tabla 'tb_detalle_ventas'
        $sentencia_detalle = $pdo->prepare("INSERT INTO tb_detalle_ventas (id_ventas, idProductos, cantidad, fyh_creacion) 
                                            VALUES (:id_ventas, :idProductos, :cantidad, :fyh_creacion)");
        $sentencia_detalle->execute([
            ':id_ventas'    => $id_venta_oficial,
            ':idProductos'  => $idProductos,
            ':cantidad'     => $cantidad,
            ':fyh_creacion' => $fyh_creacion
        ]);

        // 4. Restar automáticamente la cantidad al stock del producto
        $sentencia_stock = $pdo->prepare("UPDATE productos 
                                           SET stockProductos = stockProductos - :cantidad 
                                           WHERE idProductos = :idProductos");
        $sentencia_stock->execute([
            ':cantidad'    => $cantidad,
            ':idProductos' => $idProductos
        ]);
    }

    // 5. Limpiar el carrito temporal para esa venta
    $sentencia_limpiar = $pdo->prepare("DELETE FROM tb_carrito WHERE id_ventas = :id_ventas");
    $sentencia_limpiar->execute([':id_ventas' => $id_ventas_temp]);

    // Confirmamos toda la transacción
    $pdo->commit();

    echo "success-" . $id_venta_oficial;
    exit;

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "error_servidor: " . $e->getMessage();
}