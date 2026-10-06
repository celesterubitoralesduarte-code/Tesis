<?php
include('../../config.php');

$id_producto = $_POST['id_producto'] ?? $_GET['id'] ?? null;

if ($id_producto) {
    try {
        // Cambiamos el estado a 1 para reactivarlo
        $sentencia = $pdo->prepare("UPDATE productos SET estado = 1 WHERE idProductos = :id_producto");
        $sentencia->bindParam(':id_producto', $id_producto);
        
        if ($sentencia->execute()) {
            $_SESSION['mensaje'] = "El producto se activó correctamente";
            $_SESSION['icono'] = "success";
            header('Location: ' . $URL . '/productos/inactivos.php');
            exit();
        } else {
            $_SESSION['mensaje'] = "No se pudo activar el producto";
            $_SESSION['icono'] = "error";
            header('Location: ' . $URL . '/productos/inactivos.php');
            exit();
        }

    } catch (PDOException $e) {
        $_SESSION['mensaje'] = "Error en la base de datos al intentar activar el producto.";
        $_SESSION['icono'] = "error";
        header('Location: ' . $URL . '/productos/inactivos.php');
        exit();
    }
} else {
    $_SESSION['mensaje'] = "No se encontró el ID del producto.";
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/productos/inactivos.php');
    exit();
}