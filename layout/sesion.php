<?php

include_once __DIR__ . '/../app/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica si existe la sesión
if (!isset($_SESSION['sesion usuarioTrabajador'])) {
    header('Location:' . $URL . 'login/index.php');
    exit();
}

$usuario_sesion = $_SESSION['sesion usuarioTrabajador'];

// Inicializar variables por defecto
$idTrabajadores = "";
$NomTrabajadores = "";
$rol_sesion = "";

$sql = "SELECT us.idTrabajadores as idTrabajadores, us.NomTrabajadores as NomTrabajadores, us.usuarioTrabajador as usuarioTrabajador, 
        rol.rol_name as rol_name FROM trabajadores as us INNER JOIN tb_roles as rol ON us.id_rol = rol.id_rol WHERE usuarioTrabajador='$usuario_sesion'";

$squery = $pdo->prepare($sql);
$squery->execute();

$trabajadores = $squery->fetchAll(PDO::FETCH_ASSOC);

foreach ($trabajadores as $trabajador) {
    $idTrabajadores = $trabajador['idTrabajadores'];
    $NomTrabajadores = $trabajador['NomTrabajadores'];
    $rol_sesion = $trabajador['rol_name'];
}