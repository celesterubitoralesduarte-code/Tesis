<?php
include('../../config.php');

header('Content-Type: application/json');

$nombre_cliente  = trim($_POST['nombre_cliente'] ?? '');
$ruc_ci_cliente  = trim($_POST['ruc_ci_cliente'] ?? '');
$celular_cliente = trim($_POST['celular_cliente'] ?? '');
$email_cliente   = trim($_POST['email_cliente'] ?? '');
$fyh_creacion    = date('Y-m-d H:i:s');

// Solo verificamos que los indispensables no vengan vacíos
if (empty($nombre_cliente) || empty($ruc_ci_cliente)) {
    echo json_encode(['status' => 'error', 'message' => 'El Nombre y el RUC/CI son obligatorios.']);
    exit;
}

try {
    $sentencia = $pdo->prepare("INSERT INTO clientes (nombre_cliente, ruc_ci_cliente, celular_cliente, email_cliente, fyh_creacion) 
                                VALUES (:nombre_cliente, :ruc_ci_cliente, :celular_cliente, :email_cliente, :fyh_creacion)");
    
    $sentencia->execute([
        ':nombre_cliente'  => $nombre_cliente,
        ':ruc_ci_cliente'  => $ruc_ci_cliente,
        ':celular_cliente' => $celular_cliente, // Se guarda vacío si no se cargó
        ':email_cliente'   => $email_cliente,   // Se guarda vacío si no se cargó
        ':fyh_creacion'    => $fyh_creacion
    ]);

    $id_cliente_nuevo = $pdo->lastInsertId();

    echo json_encode([
        'status'     => 'success',
        'id_cliente' => $id_cliente_nuevo,
        'nombre'     => $nombre_cliente,
        'ruc'        => $ruc_ci_cliente
    ]);

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}