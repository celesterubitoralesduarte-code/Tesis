<?php

include_once __DIR__ . '/../../config.php';

 
 $sql_usuarios = "SELECT us.idTrabajadores as idTrabajadores, us.NomTrabajadores as NomTrabajadores, us.usuarioTrabajador as usuarioTrabajador, 
                  rol.rol_name as rol_name FROM trabajadores as us INNER JOIN tb_roles as rol ON us.id_rol = rol.id_rol ";
  $squery_usuarios=$pdo->prepare($sql_usuarios);
  $squery_usuarios->execute();

  $usuarios_datos= $squery_usuarios->fetchAll(PDO::FETCH_ASSOC);