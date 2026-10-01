<?php
include('../../config.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Acceso no permitido");
}

$id_rol = $_POST['id_rol'] ?? null;
$rol_name = $_POST['rol_name'] ?? null;

   $fechaHora = date('Y-m-d H:i:s');
     $sentencia = $pdo->prepare("UPDATE tb_roles 
        SET 
            rol_name = :rol_name,
            fyh_actualizacion = :fyh_actualizacion 
        WHERE id_rol = :id_rol");
            
     $sentencia->bindParam(':rol_name', $rol_name);
     $sentencia->bindParam(':fyh_actualizacion', $fechaHora);
     $sentencia->bindParam(':id_rol', $id_rol);

    if($sentencia->execute()){

    session_start();
     $_SESSION['mensaje'] = "Se actualizó el rol de la manera correcta";
     $_SESSION['icono'] = "success";

      header('Location: ../../../roles/');
      exit();

    }else{
    $_SESSION['mensaje'] = "No se pudo actualizar a la base de datos";
    $_SESSION['icono'] = "error";

    header('Location: ../../../roles/update.php?id'.$id_rol);
    exit();
    }
   
 
?>

   