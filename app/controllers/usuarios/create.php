
<?php

include('../../config.php');


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Acceso no permitido");
}

$ciTrabajador = $_POST['ciTrabajador'] ?? null;
$NomTrabajadores = $_POST['NomTrabajadores'] ?? null;
$usuarioTrabajador = $_POST['usuarioTrabajador'] ?? null;
$id_rol = $_POST['id_rol'] ?? null;
$pasworTrabaj = $_POST['pasworTrabaj'] ?? null;
$pasworTrabaj_repeat = $_POST['pasworTrabaj_repeat'] ?? null;
$TelefTrabaj = $_POST['TelefTrabaj'] ?? null;
$fh_creacion = $_POST['fh_creacion'] ?? null;


// Verificar datos obligatorios
if (!$ciTrabajador || !$NomTrabajadores || !$usuarioTrabajador || !$pasworTrabaj) {

    $_SESSION['mensaje'] = "Faltan datos del formulario";
    $_SESSION['icono'] = "error";

    header('Location: ' . $URL . '/trabajadores/update.php');
    exit();
}


// Verificar que las contraseñas coincidan
if ($pasworTrabaj != $pasworTrabaj_repeat) {

    $_SESSION['mensaje'] = "Las contraseñas no son iguales";
    $_SESSION['icono'] = "error";

    header('Location: ' . $URL . '/trabajadores/update.php');
    exit();
}


// Encriptar contraseña
$pasworTrabaj = password_hash($pasworTrabaj, PASSWORD_DEFAULT);


// Insertar trabajador
$sentencia = $pdo->prepare("INSERT INTO trabajadores
    (ciTrabajador, NomTrabajadores, usuarioTrabajador, id_rol, pasworTrabaj, TelefTrabaj, fh_creacion)
    VALUES
    (:ciTrabajador, :NomTrabajadores, :usuarioTrabajador, :id_rol, :pasworTrabaj, :TelefTrabaj, :fh_creacion)
");


$sentencia->bindParam(':ciTrabajador', $ciTrabajador);
$sentencia->bindParam(':NomTrabajadores', $NomTrabajadores);
$sentencia->bindParam(':usuarioTrabajador', $usuarioTrabajador);
$sentencia->bindParam(':id_rol', $id_rol);
$sentencia->bindParam(':pasworTrabaj', $pasworTrabaj);
$sentencia->bindParam(':TelefTrabaj', $TelefTrabaj);
$sentencia->bindParam(':fh_creacion', $fechaHora);


// Ejecutar
if ($sentencia->execute()) {

    $_SESSION['mensaje'] = "El trabajador se registró correctamente";
    $_SESSION['icono'] = "success";

    header('Location: ' . $URL . '/trabajadores/index.php');
    exit();

} else {

    $_SESSION['mensaje'] = "No se pudo registrar el trabajador";
    $_SESSION['icono'] = "error";

    header('Location: ' . $URL . '/trabajadores/update.php');
    exit();
}

?>

