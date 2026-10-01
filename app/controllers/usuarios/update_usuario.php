<?php
$id_usuario_get = $_GET['id'] ?? null; 

if ($id_usuario_get === null) {
    echo "No se recibió el ID del usuario.";
    exit;
}

// Se agrega us.id_rol a la consulta SELECT
$sql_usuarios = "SELECT us.idTrabajadores as idTrabajadores, 
                        us.NomTrabajadores as NomTrabajadores, 
                        us.TelefTrabaj as TelefTrabaj, 
                        us.ciTrabajador as ciTrabajador, 
                        us.usuarioTrabajador as usuarioTrabajador, 
                        us.id_rol as id_rol, 
                        rol.rol_name as rol_name 
                 FROM trabajadores as us 
                 INNER JOIN tb_roles as rol ON us.id_rol = rol.id_rol
                 WHERE us.idTrabajadores = :id";

$squery_usuarios = $pdo->prepare($sql_usuarios);
$squery_usuarios->bindValue(':id', $id_usuario_get, PDO::PARAM_INT);
$squery_usuarios->execute();

$usuarios_datos = $squery_usuarios->fetchAll(PDO::FETCH_ASSOC);

// Inicializar variable por seguridad
$id_rol = null;

foreach ($usuarios_datos as $usuarios_dato){
    $NomTrabajadores = $usuarios_dato['NomTrabajadores'];
    $usuarioTrabajador = $usuarios_dato['usuarioTrabajador'];
    $rol_name = $usuarios_dato['rol_name'];
    $TelefTrabaj = $usuarios_dato['TelefTrabaj'];
    $ciTrabajador = $usuarios_dato['ciTrabajador'];
    $id_rol = $usuarios_dato['id_rol']; // Asignación del id_rol
}