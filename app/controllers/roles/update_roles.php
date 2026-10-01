<?php
$id_rol_get = $_GET['id'] ?? null; 


if ($id_rol_get === null) {
  
}

 $sql_roles = "SELECT * FROM tb_roles WHERE id_rol = '$id_rol_get'";
  $squery_roles=$pdo->prepare($sql_roles);
  $squery_roles->execute();

  $roles_datos= $squery_roles->fetchAll(PDO::FETCH_ASSOC);
  foreach ($roles_datos as $roles_dato){
   $rol_name = $roles_dato['rol_name'];
   
  
}
