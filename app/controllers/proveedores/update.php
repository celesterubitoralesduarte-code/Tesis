<?php
include('../../config.php');

// Verificar si la sesión no está activa antes de iniciarla
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$idProveedores = $_GET['idProveedores'] ?? null;
$nombre_proveedor = $_GET['nombre_proveedor'] ?? null;
$celular = $_GET['celular'] ?? null;
$telefono = $_GET['telefono'] ?? null;
$empresa = $_GET['empresa'] ?? null;
$email = $_GET['email'] ?? null;
$rucProveedores = $_GET['rucProveedores'] ?? null;
$direccion = $_GET['direccion'] ?? null;

if ($idProveedores) {
    $sentencia = $pdo->prepare("UPDATE proveedores SET 
        nombre_proveedor = :nombre_proveedor,
        celular = :celular,
        telefono = :telefono,
        empresa = :empresa,
        email = :email,
        rucProveedores = :rucProveedores,
        direccion = :direccion
        WHERE idProveedores = :idProveedores");

    $sentencia->bindParam(':nombre_proveedor', $nombre_proveedor);
    $sentencia->bindParam(':celular', $celular);
    $sentencia->bindParam(':telefono', $telefono);
    $sentencia->bindParam(':empresa', $empresa);
    $sentencia->bindParam(':email', $email);
    $sentencia->bindParam(':rucProveedores', $rucProveedores);
    $sentencia->bindParam(':direccion', $direccion);
    $sentencia->bindParam(':idProveedores', $idProveedores);

    if ($sentencia->execute()) {
        $_SESSION['mensaje'] = "Se actualizó al proveedor correctamente";
        $_SESSION['icono'] = "success";
        ?>
        <script>
            location.href = "<?php echo $URL;?>/proveedores";
        </script>
        <?php
    } else {
        $_SESSION['mensaje'] = "Error, no se pudo actualizar en la base de datos";
        $_SESSION['icono'] = "error";
        ?>
        <script>
            location.href = "<?php echo $URL;?>/proveedores";
        </script>
        <?php
    }
}