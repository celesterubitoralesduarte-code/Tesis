<?php
include('../../config.php');

// Recibimos el ID del producto
$id_producto = $_POST['id_producto'] ?? $_POST['idProductos'] ?? $_GET['id_producto'] ?? $_GET['idProductos'] ?? null;

if ($id_producto) {
    try {
        // CORREGIDO: Usamos idProductos (como está en tu base de datos) en lugar de id_producto
        $sentencia = $pdo->prepare("UPDATE productos SET estado = 0 WHERE idProductos = :id_producto");
        $sentencia->bindParam(':id_producto', $id_producto);
        
        if ($sentencia->execute()) {
            $_SESSION['mensaje'] = "El producto se desactivó correctamente";
            $_SESSION['icono'] = "success";
            header('Location: ' . $URL . '/productos');
            exit();
        } else {
            $_SESSION['mensaje'] = "No se pudo desactivar el producto";
            $_SESSION['icono'] = "error";
            header('Location: ' . $URL . '/productos');
            exit();
        }

    } catch (PDOException $e) {
        $_SESSION['mensaje'] = "Error en la base de datos al intentar desactivar el producto.";
        $_SESSION['icono'] = "error";
        header('Location: ' . $URL . '/productos');
        exit();
    }
} else {
    $_SESSION['mensaje'] = "No se encontró el ID del producto.";
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/productos');
    exit();
}