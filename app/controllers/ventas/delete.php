<?php
// app/controllers/ventas/borrar_venta.php

include_once __DIR__ . '/../../config.php';

if (isset($_POST['id_ventas'])) {
    $id_ventas = $_POST['id_ventas'];

    try {
        // Iniciamos una transacción para asegurar que se borre tanto el detalle como la venta principal
        $pdo->beginTransaction();

        // 1. Opcional pero recomendado: Borrar los detalles asociados a esta venta para no dejar registros huérfanos
        $sql_detalles = "DELETE FROM tb_detalle_ventas WHERE id_ventas = :id_ventas";
        $query_detalles = $pdo->prepare($sql_detalles);
        $query_detalles->execute(['id_ventas' => $id_ventas]);

        // 2. Borrar el registro principal de la venta
        $sql_venta = "DELETE FROM ventas WHERE id_ventas = :id_ventas";
        $query_venta = $pdo->prepare($sql_venta);
        $query_venta->execute(['id_ventas' => $id_ventas]);

        // Confirmamos la transacción
        $pdo->commit();

        // Redireccionamos con mensaje de éxito (puedes adaptarlo a tu sistema de sesiones/alertas)
        session_start();
        $_SESSION['mensaje'] = "Se eliminó la venta de la base de datos de manera correcta.";
        $_SESSION['icono'] = "success";
        header('Location: ' . $URL . '/ventas/index.php');
        exit();

    } catch (Exception $e) {
        // Si ocurre un error, revertimos los cambios
        $pdo->rollBack();
        
        session_start();
        $_SESSION['mensaje'] = "Error al intentar eliminar la venta: " . $e->getMessage();
        $_SESSION['icono'] = "error";
        header('Location: ' . $URL . '/ventas/index.php');
        exit();
    }
}