
<?php

include('../../config.php');

$usuarioTrabajador = $_POST['usuarioTrabajador'] ?? '';
$pasworTrabaj = $_POST['pasworTrabaj'] ?? '';

$sql = "SELECT * FROM trabajadores 
        WHERE usuarioTrabajador = :usuarioTrabajador";

$query = $pdo->prepare($sql);
$query->bindParam(':usuarioTrabajador', $usuarioTrabajador);
$query->execute();

$trabajador = $query->fetch(PDO::FETCH_ASSOC);

$acceso_correcto = false;

if ($trabajador) {

    $contraseña_guardada = $trabajador['pasworTrabaj'];

    // Si la contraseña está en texto normal
    if ($pasworTrabaj === $contraseña_guardada) {
        $acceso_correcto = true;
    }

    // Si la contraseña está encriptada con password_hash()
    elseif (password_verify($pasworTrabaj, $contraseña_guardada)) {
        $acceso_correcto = true;
    }
}

if (!$acceso_correcto) {

    session_start();

    $_SESSION['mensaje'] = "ERROR: Datos Incorrectos";

    header('Location: ' . $URL . 'login/index.php');
    exit();

} else {

    session_start();

    $_SESSION['sesion usuarioTrabajador'] = $usuarioTrabajador;

    header('Location: ' . $URL . 'index.php');
    exit();
}

