<?php
include('../../config.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Acceso no permitido");
}


$idProductos = $_POST['idProductos'] ?? null;

    $sentencia = $pdo->prepare("DELETE FROM productos WHERE idProductos = :idProductos");

    $sentencia->bindParam(':idProductos', $idProductos);

    $sentencia->execute();

   $_SESSION['mensaje'] = "Se elimino el Producto de la manera correcta";
   $_SESSION['icono'] = "success";

header('Location: ../../../productos/');