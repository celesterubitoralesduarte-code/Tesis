<?php
include('../../config.php');

// Verificar si la sesión no está activa antes de iniciarla
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$nombre_proveedor = $_GET['nombre_proveedor'] ?? null;
$celular = $_GET['celular'] ?? null;
$telefono = $_GET['telefono'] ?? null;
$empresa = $_GET['empresa'] ?? null;
$email = $_GET['email'] ?? null;
$rucProveedores = $_GET['rucProveedores'] ?? null;
$direccion = $_GET['direccion'] ?? null;

$sentencia = $pdo->prepare("INSERT INTO proveedores 
    (nombre_proveedor, celular, telefono, empresa, email, rucProveedores, direccion) 
    VALUES (:nombre_proveedor, :celular, :telefono, :empresa, :email, :rucProveedores, :direccion)");

$sentencia->bindParam(':nombre_proveedor', $nombre_proveedor);
$sentencia->bindParam(':celular', $celular);
$sentencia->bindParam(':telefono', $telefono);
$sentencia->bindParam(':empresa', $empresa);
$sentencia->bindParam(':email', $email);
$sentencia->bindParam(':rucProveedores', $rucProveedores);
$sentencia->bindParam(':direccion', $direccion);

if ($sentencia->execute()) {
    $_SESSION['mensaje'] = "Se registró al proveedor correctamente";
    $_SESSION['icono'] = "success";
    ?>
    <script>
        location.href = "<?php echo $URL;?>/proveedores";
    </script>
    <?php
} else {
    $_SESSION['mensaje'] = "Error, no se pudo registrar en la base de datos";
    $_SESSION['icono'] = "error";
    ?>
    <script>
        location.href = "<?php echo $URL;?>/proveedores";
    </script>
    <?php
}