<?php
include('../../config.php');

$id_ventas = $_POST['id_ventas'];

// Preparamos la consulta para eliminar todos los productos del carrito con este id_ventas
$sql = "DELETE FROM tb_carrito WHERE id_ventas = :id_ventas";
$query = $pdo->prepare($sql);
$query->bindParam(':id_ventas', $id_ventas);

if ($query->execute()) {
    echo "success";
} else {
    echo "error";
}
?>