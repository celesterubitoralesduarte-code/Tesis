<?php
include('../../config.php');

$id_ventas   = $_POST['id_ventas'] ?? '';
$idProductos = $_POST['idProductos'] ?? '';
$cantidad    = $_POST['cantidad'] ?? '';
$fyh_creacion = date('Y-m-d H:i:s');

if (empty($id_ventas) || empty($idProductos) || empty($cantidad)) {
    echo "error_datos_incompletos";
    exit;
}

$cantidad = (float)$cantidad;

// Insertamos directamente cada pesaje/unidades como un ítem individual en la tabla
$sentencia = $pdo->prepare("INSERT INTO tb_carrito (id_ventas, idProductos, cantidad, fyh_creacion) 
                            VALUES (:id_ventas, :idProductos, :cantidad, :fyh_creacion)");

$ejecutado = $sentencia->execute([
    ':id_ventas'    => $id_ventas, 
    ':idProductos'  => $idProductos, 
    ':cantidad'     => $cantidad, 
    ':fyh_creacion' => $fyh_creacion
]);

if ($ejecutado) {
    echo "success";
} else {
    echo "error_al_insertar";
}