<?php
include('../../config.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Acceso no permitido");
}

// Capturar o definir la fecha/hora de creación
if (!isset($fechaHora) || empty($fechaHora)) {
    $fechaHora = date('Y-m-d H:i:s');
}

// Captura y saneamiento de datos desde el formulario
$codigo = !empty($_POST['codigo']) ? $_POST['codigo'] : null;
$nomProductos = !empty($_POST['nomProductos']) ? $_POST['nomProductos'] : null;
$idTrabajadores = !empty($_POST['idTrabajadores']) ? $_POST['idTrabajadores'] : null;

// Saneamiento de Stocks (remueve separadores si los hay)
$stockProductos = isset($_POST['stockProductos']) ? str_replace('.', '', $_POST['stockProductos']) : 0;
$stockMinimo = isset($_POST['stockMinimo']) ? str_replace('.', '', $_POST['stockMinimo']) : 0;

// SANEAMIENTO DE PRECIOS:
// Remueve puntos de miles y cambia comas decimales por puntos para evitar el truncamiento de MySQL
$precioCompra = $_POST['precioCompra'] ?? 0;
$precioCompra = str_replace('.', '', $precioCompra); // "70.000" pasa a "70000"
$precioCompra = str_replace(',', '.', $precioCompra); // "70,50" pasa a "70.50"

$precioVenta = $_POST['precioVenta'] ?? 0;
$precioVenta = str_replace('.', '', $precioVenta);  // "85.000" pasa a "85000"
$precioVenta = str_replace(',', '.', $precioVenta);  // "85,50" pasa a "85.50"

$fecha_ingreso = !empty($_POST['fecha_ingreso']) ? $_POST['fecha_ingreso'] : date('Y-m-d H:i:s');
$unidadMedida = $_POST['unidadMedida'] ?? null;

try {
    $sentencia = $pdo->prepare("INSERT INTO productos
        (idTrabajadores, codigo, nomProductos, stockProductos, stockMinimo, precioCompra, precioVenta, fecha_ingreso, unidadMedida, fyh_creacion)
        VALUES
        (:idTrabajadores, :codigo, :nomProductos, :stockProductos, :stockMinimo, :precioCompra, :precioVenta, :fecha_ingreso, :unidadMedida, :fyh_creacion)
    ");

    $sentencia->bindParam(':idTrabajadores', $idTrabajadores, $idTrabajadores === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
    $sentencia->bindParam(':codigo', $codigo);
    $sentencia->bindParam(':nomProductos', $nomProductos);
    $sentencia->bindParam(':stockProductos', $stockProductos);
    $sentencia->bindParam(':stockMinimo', $stockMinimo);
    $sentencia->bindParam(':precioCompra', $precioCompra);
    $sentencia->bindParam(':precioVenta', $precioVenta);
    $sentencia->bindParam(':fecha_ingreso', $fecha_ingreso);
    $sentencia->bindParam(':unidadMedida', $unidadMedida);
    $sentencia->bindParam(':fyh_creacion', $fechaHora);

    if ($sentencia->execute()) {
        $_SESSION['mensaje'] = "Se registró el producto correctamente";
        $_SESSION['icono'] = "success";
        header('Location: ' . $URL . '/productos/index.php');
        exit();
    } else {
        $_SESSION['mensaje'] = "No se pudo registrar el producto";
        $_SESSION['icono'] = "error";
        header('Location: ' . $URL . '/productos/create.php');
        exit();
    }
} catch (Exception $e) {
    die("Error al registrar el producto: " . $e->getMessage());
}
?>