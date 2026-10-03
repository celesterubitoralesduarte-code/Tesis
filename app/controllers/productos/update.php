<?php
include('../../config.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Acceso no permitido");
}

// 1. Validar que idProductos esté presente
$idProductos = $_POST['idProductos'] ?? null;

if (!$idProductos) {
    session_start();
    $_SESSION['mensaje'] = "Error: No se encontró el ID del producto";
    $_SESSION['icono'] = "error";
    header('Location: ../../../productos/');
    exit();
}

$codigo = !empty($_POST['codigo']) ? $_POST['codigo'] : null;
$nomProductos = !empty($_POST['nomProductos']) ? $_POST['nomProductos'] : null;
$idTrabajadores = !empty($_POST['idTrabajadores']) ? $_POST['idTrabajadores'] : null;

// 2. Limpieza de Stocks: solo se cambia la coma decimal por punto y se convierte a float.
// Si viene como entero puro (ej: 10, 59, 10000, 59000), se guarda tal cual sin eliminar caracteres.
$stockProductos = (float)str_replace(',', '.', $_POST['stockProductos'] ?? 0);
$stockMinimo    = (float)str_replace(',', '.', $_POST['stockMinimo'] ?? 0);

// 3. Limpieza de Precios: Se eliminan puntos y comas de formato visual
$precioCompra_Limpio = (float)preg_replace('/[^0-9]/', '', $_POST['precioCompra'] ?? 0);
$precioVenta_Limpio  = (float)preg_replace('/[^0-9]/', '', $_POST['precioVenta'] ?? 0);

// NOTA: Se divide entre 1000 para mantener consistencia si en la base de datos se almacena como float/decimal (ej: 72.00)
$precioCompra = $precioCompra_Limpio / 1000;
$precioVenta  = $precioVenta_Limpio / 1000;

// 4. Formatear la fecha para que guarde fecha y hora completas
$fecha_ingreso_raw = $_POST['fecha_ingreso'] ?? date('Y-m-d');
$fecha_ingreso     = date('Y-m-d H:i:s', strtotime($fecha_ingreso_raw));

$unidadMedida = $_POST['unidadMedida'] ?? null;
$fechaHora    = date('Y-m-d H:i:s');

// 5. Preparar la sentencia SQL
$sentencia = $pdo->prepare("UPDATE productos 
    SET 
        nomProductos      = :nomProductos,
        stockProductos    = :stockProductos,
        stockMinimo       = :stockMinimo,
        precioCompra      = :precioCompra,
        precioVenta       = :precioVenta,
        fecha_ingreso     = :fecha_ingreso,
        unidadMedida      = :unidadMedida,
        fyh_actualizacion = :fyh_actualizacion 
    WHERE idProductos     = :idProductos");

$sentencia->bindParam(':nomProductos', $nomProductos);
$sentencia->bindParam(':stockProductos', $stockProductos);
$sentencia->bindParam(':stockMinimo', $stockMinimo);
$sentencia->bindParam(':precioCompra', $precioCompra);
$sentencia->bindParam(':precioVenta', $precioVenta);
$sentencia->bindParam(':fecha_ingreso', $fecha_ingreso);
$sentencia->bindParam(':unidadMedida', $unidadMedida);
$sentencia->bindParam(':fyh_actualizacion', $fechaHora);
$sentencia->bindParam(':idProductos', $idProductos);

session_start();

if ($sentencia->execute()) {
    $_SESSION['mensaje'] = "Se actualizó el Producto de la manera correcta";
    $_SESSION['icono'] = "success";

    header('Location: ../../../productos/');
    exit();
} else {
    $_SESSION['mensaje'] = "No se pudo actualizar a la base de datos";
    $_SESSION['icono'] = "error";

    header('Location: ../../../productos/update.php?id=' . $idProductos);
    exit();
}
?>