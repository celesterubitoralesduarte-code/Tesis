<?php

 $id_usuario_get = $_GET['id'];

 $sql_usuarios = "SELECT us.idTrabajadores as idTrabajadores, us.NomTrabajadores as NomTrabajadores, 
                  us.TelefTrabaj as TelefTrabaj, us.ciTrabajador as ciTrabajador, us.usuarioTrabajador as usuarioTrabajador, 
                  rol.rol_name as rol_name FROM trabajadores as us INNER JOIN tb_roles as rol ON us.id_rol = rol.id_rol
                  WHERE idTrabajadores = '$id_usuario_get'";
  $squery_usuarios=$pdo->prepare($sql_usuarios);
  $squery_usuarios->execute();

  $usuarios_datos= $squery_usuarios->fetchAll(PDO::FETCH_ASSOC);
  foreach ($usuarios_datos as $usuarios_dato){
   $NomTrabajadores = $usuarios_dato['NomTrabajadores'];
   $usuarioTrabajador = $usuarios_dato['usuarioTrabajador'];
   $TelefTrabaj = $usuarios_dato['TelefTrabaj'];
   $ciTrabajador = $usuarios_dato['ciTrabajador'];
   $rol_name = $usuarios_dato['rol_name'];
  }
