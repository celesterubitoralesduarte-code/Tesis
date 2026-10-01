<?php

include_once __DIR__ . '/../../config.php';

 
 $sql_roles = "SELECT * FROM tb_roles";
  $squery_roles=$pdo->prepare($sql_roles);
  $squery_roles->execute();

  $roles_datos= $squery_roles->fetchAll(PDO::FETCH_ASSOC);