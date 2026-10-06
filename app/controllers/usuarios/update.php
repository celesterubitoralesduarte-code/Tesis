<?php
include('../../config.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Acceso no permitido");
}

$ciTrabajador      = $_POST['ciTrabajador'] ?? null;
$NomTrabajadores   = $_POST['NomTrabajadores'] ?? null;
$usuarioTrabajador = $_POST['usuarioTrabajador'] ?? null;
$id_rol            = $_POST['id_rol'] ?? null;
$pasworTrabaj      = $_POST['pasworTrabaj'] ?? null;
$pasworTrabaj_repeat = $_POST['pasworTrabaj_repeat'] ?? null;
$TelefTrabaj       = $_POST['TelefTrabaj'] ?? null;
$id_usuario        = $_POST['id_usuario'] ?? null;
$fechaHora         = date('Y-m-d H:i:s');

// 1. Validar si se quiere cambiar la contraseña (si el campo no está vacío)
if (!empty($pasworTrabaj)) {
    // Si se escribió algo, verificar que coincidan
    if ($pasworTrabaj !== $pasworTrabaj_repeat) {
        $_SESSION['mensaje'] = "Las contraseñas no coinciden";
        $_SESSION['icono'] = "error";
        header('Location: ../../../trabajadores/update.php?id=' . $id_usuario);
        exit();
    }

    // Si coinciden, hasheamos la nueva contraseña y actualizamos TODO (incluyendo contraseña)
    $pasworTrabaj = password_hash($pasworTrabaj, PASSWORD_DEFAULT);

    $sentencia = $pdo->prepare("UPDATE trabajadores 
        SET 
            ciTrabajador = :ciTrabajador,
            NomTrabajadores = :NomTrabajadores,
            usuarioTrabajador = :usuarioTrabajador,
            id_rol = :id_rol, 
            pasworTrabaj = :pasworTrabaj, 
            TelefTrabaj = :TelefTrabaj,
            fh_actualizacion = :fh_actualizacion 
        WHERE idTrabajadores = :id_usuario");

    $sentencia->bindParam(':pasworTrabaj', $pasworTrabaj);

} else {
    // Si el campo de contraseña está vacío, actualizamos SIN modificar la contraseña actual
    $sentencia = $pdo->prepare("UPDATE trabajadores 
        SET 
            ciTrabajador = :ciTrabajador,
            NomTrabajadores = :NomTrabajadores,
            usuarioTrabajador = :usuarioTrabajador,
            id_rol = :id_rol, 
            TelefTrabaj = :TelefTrabaj,
            fh_actualizacion = :fh_actualizacion 
        WHERE idTrabajadores = :id_usuario");
}

// Parámetros comunes para ambas consultas
$sentencia->bindParam(':ciTrabajador', $ciTrabajador);
$sentencia->bindParam(':NomTrabajadores', $NomTrabajadores);
$sentencia->bindParam(':usuarioTrabajador', $usuarioTrabajador);
$sentencia->bindParam(':id_rol', $id_rol);
$sentencia->bindParam(':TelefTrabaj', $TelefTrabaj);
$sentencia->bindParam(':fh_actualizacion', $fechaHora);
$sentencia->bindParam(':id_usuario', $id_usuario);

$sentencia->execute();

$_SESSION['mensaje'] = "Se actualizó al usuario de la manera correcta";
$_SESSION['icono'] = "success";

header('Location: ' . $URL . 'trabajadores/');
exit();
?>