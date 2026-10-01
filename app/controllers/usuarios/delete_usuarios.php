
<?php
include('../../config.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Acceso no permitido");
}

$id_usuario = $_POST['id_usuario'] ?? null;

    $sentencia = $pdo->prepare("DELETE FROM trabajadores WHERE idTrabajadores = :id_usuario");

    $sentencia->bindParam(':id_usuario', $id_usuario);

    $sentencia->execute();

   $_SESSION['mensaje'] = "Se elimino al usuario de la manera correcta";
   $_SESSION['icono'] = "success";

header('Location: ../../../trabajadores/');

