<?php
include('../../config.php');

$id_carrito = $_POST['id_carrito'] ?? 0;

if ($id_carrito > 0) {
    $sentencia = $pdo->prepare("DELETE FROM tb_carrito WHERE id_carrito = :id_carrito");
    $ejecutado = $sentencia->execute([':id_carrito' => $id_carrito]);

    if ($ejecutado) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "error_id_invalido";
}