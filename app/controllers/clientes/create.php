<?php
include('../../config.php');


session_start();

// 3. Recepción de datos del formulario
$nombre_cliente = $_POST['nombre_cliente'];
$ruc_ci_cliente = $_POST['ruc_ci_cliente'];
$celular_cliente = $_POST['celular_cliente'];
$email_cliente = $_POST['email_cliente'];
$fyh_creacion = date('Y-m-d H:i:s');

// 4. Preparar la consulta SQL según la estructura de tu tabla 'clientes'
$sentencia = $pdo->prepare("INSERT INTO clientes 
            (nombre_cliente, ruc_ci_cliente, celular_cliente, email_cliente, fyh_creacion) 
     VALUES (:nombre_cliente, :ruc_ci_cliente, :celular_cliente, :email_cliente, :fyh_creacion)");

// 5. Asignar los valores (Bind Parameters)
$sentencia->bindParam(':nombre_cliente', $nombre_cliente);
$sentencia->bindParam(':ruc_ci_cliente', $ruc_ci_cliente);
$sentencia->bindParam(':celular_cliente', $celular_cliente);
$sentencia->bindParam(':email_cliente', $email_cliente);
$sentencia->bindParam(':fyh_creacion', $fyh_creacion);

// 6. Ejecutar la consulta y redirigir
if ($sentencia->execute()) {
    $_SESSION['mensaje'] = "Se registró al cliente de manera correcta";
    $_SESSION['icono'] = "success";
    header('Location: ' . $URL . '/ventas/create.php');
} else {
    $_SESSION['mensaje'] = "Error al registrar en la base de datos";
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/ventas/create.php');
}