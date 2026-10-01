<?php
include('../../config.php');

// Si la sesión no ha iniciado aún, la iniciamos
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    die("Acceso no permitido");
}

$idProveedores = $_GET['idProveedores'] ?? null;

if ($idProveedores) {
    $sentencia = $pdo->prepare("DELETE FROM proveedores WHERE idProveedores = :idProveedores");

    if ($sentencia->execute([':idProveedores' => $idProveedores])) {
        $_SESSION['mensaje'] = "Se eliminó el Proveedor correctamente";
        $_SESSION['icono'] = "success";
    } else {
        $_SESSION['mensaje'] = "Error, no se pudo eliminar en la base de datos";
        $_SESSION['icono'] = "error";
    }
    ?>
    <script>
        location.href = "<?php echo $URL;?>/proveedores";
    </script>
    <?php
} else {
    die("ID no proporcionado");
}