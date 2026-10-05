<?php
// Probamos una consulta con LEFT JOIN asegurando las llaves comunes
$sql_ventas = "SELECT 
                v.*, 
                c.id_cliente, 
                c.nombre_cliente, 
                c.ruc_ci_cliente, 
                c.celular_cliente, 
                c.email_cliente 
               FROM ventas AS v 
               LEFT JOIN clientes AS c ON v.id_cliente = c.id_cliente 
               ORDER BY v.id_ventas ASC";

$query_ventas = $pdo->prepare($sql_ventas);
$query_ventas->execute();
$ventas_datos = $query_ventas->fetchAll(PDO::FETCH_ASSOC);