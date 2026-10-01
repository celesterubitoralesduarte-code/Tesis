<?php
include('../../config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Acceso no permitido");
}
$rol_name = $_POST['rol_name'] ?? null;
// Insertar rol
$sentencia = $pdo->prepare("INSERT INTO tb_roles
    (rol_name, fyh_creacion)
    VALUES
    (:rol_name, :fyh_creacion)
");

$sentencia->bindParam(':rol_name', $rol_name);
$sentencia->bindParam(':fyh_creacion', $fechaHora);

// Ejecutar
if ($sentencia->execute()) {

    $_SESSION['mensaje'] = "Se registró el rol correctamente";
    $_SESSION['icono'] = "success";

    header('Location: ' . $URL . '/roles/index.php');
    exit();

} else {

    $_SESSION['mensaje'] = "No se pudo registrar el rol";
    $_SESSION['icono'] = "error";

    header('Location: ' . $URL . '/roles/update.php');
    exit();
}
?>

