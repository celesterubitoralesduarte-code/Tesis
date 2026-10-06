<?php
include('../app/config.php');
include('../layout/sesion.php');

// Inicializamos la variable vacía para que el editor y PHP sepan que existe
$detalles_productos = [];
$nro_venta = '';
$nombre_cliente = '';
$ruc_ci_cliente = '';
$fecha_venta = '';

if (isset($_GET['id'])) {
    $id_venta_get = $_GET['id'];

    // 1. Consultar los datos de la venta y del cliente
    $sql_venta = "SELECT 
                    v.*, 
                    c.nombre_cliente, 
                    c.ruc_ci_cliente, 
                    c.celular_cliente, 
                    c.email_cliente 
                  FROM ventas AS v 
                  LEFT JOIN clientes AS c ON v.id_cliente = c.id_cliente 
                  WHERE v.id_ventas = :id_ventas";
    
    $query_venta = $pdo->prepare($sql_venta);
    $query_venta->execute([':id_ventas' => $id_venta_get]);
    $venta_datos = $query_venta->fetch(PDO::FETCH_ASSOC);

    if (!$venta_datos) {
        header('Location: ' . $URL . '/ventas/index.php');
        exit();
    }

    $nro_venta = !empty($venta_datos['nro_venta']) && $venta_datos['nro_venta'] != 0 ? $venta_datos['nro_venta'] : $venta_datos['id_ventas'];
    $nombre_cliente = !empty($venta_datos['nombre_cliente']) ? $venta_datos['nombre_cliente'] : 'Cliente Ocasional / S/N';
    $ruc_ci_cliente = !empty($venta_datos['ruc_ci_cliente']) ? $venta_datos['ruc_ci_cliente'] : 'S/N';
    $fecha_venta = date('d/m/Y', strtotime($venta_datos['fyh_creacion']));

    // 2. Consultar los productos comprados en esta venta
    $sql_detalles = "SELECT dt.cantidad, p.nomProductos, p.precioVenta 
                     FROM tb_detalle_ventas AS dt 
                     INNER JOIN productos AS p ON dt.idProductos = p.idProductos 
                     WHERE dt.id_ventas = :id_ventas";
    $query_detalles = $pdo->prepare($sql_detalles);
    $query_detalles->execute([':id_ventas' => $id_venta_get]);
    $detalles_productos = $query_detalles->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Imprimir Factura Nro <?php echo $nro_venta; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .factura-container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 30px;
            background: #fff;
        }
        .header-table, .info-table, .detalle-table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table td {
            vertical-align: top;
        }
        .logo {
            width: 90px;
            height: auto;
        }
        .empresa-info {
            font-size: 11px;
            line-height: 1.4;
            margin-top: 5px;
        }
        .factura-info {
            text-align: right;
            font-size: 12px;
            line-height: 1.5;
        }
        .titulo-factura {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin: 20px 0;
            letter-spacing: 2px;
        }
        .info-cliente {
            border: 1px solid #333;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 12px;
            line-height: 1.6;
        }
        .detalle-table th, .detalle-table td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }
        .detalle-table th {
            background-color: #f2f2f2;
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .footer-factura {
            margin-top: 30px;
            text-align: center;
            font-size: 11px;
            line-height: 1.5;
        }
        @media print {
            body {
                padding: 0;
            }
            .factura-container {
                border: none;
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body onload="window.print()">

<div class="factura-container">
    
    <!-- ENCABEZADO CON LOGO Y DATOS FISCALES -->
    <table class="header-table">
        <tr>
            <td width="30%">
               
                <img src="<?php echo $URL; ?>/public/imagens/logoCarniceria.jpg" alt="Logo Carnicería" class="logo">
                <div class="empresa-info">
                    <b>CARNICERIA LOS HERMANOS</b><br>
                    Dirección de tu Negocio<br>
                    Teléfono: 0900-000000<br>
                    CAAGUAZU - PARAGUAY
                </div>
            </td>
            <td width="40%"></td>
            <td width="30%" class="factura-info">
                <b>RUC:</b> 80000000-0<br>
                <b>Nro Factura:</b> 001-001-<?php echo str_pad($nro_venta, 6, "0", STR_PAD_LEFT); ?><br>
                <b>Timbrado Nro:</b> 12345678<br>
                <div style="margin-top: 10px; font-size: 14px; font-weight: bold;">ORIGINAL</div>
            </td>
        </tr>
    </table>

    <div class="titulo-factura">FACTURA</div>

    <!-- DATOS DEL CLIENTE -->
    <div class="info-cliente">
        <table width="100%">
            <tr>
                <td><b>Fecha:</b> <?php echo $fecha_venta; ?></td>
                <td><b>RUC / CI:</b> <?php echo $ruc_ci_cliente; ?></td>
            </tr>
            <tr>
                <td colspan="2" style="padding-top: 5px;"><b>Señor(es):</b> <?php echo $nombre_cliente; ?></td>
            </tr>
        </table>
    </div>

    <!-- TABLA DE DETALLE DE PRODUCTOS -->
    <table class="detalle-table">
        <thead>
            <tr>
                <th width="8%">Nro</th>
                <th>Producto</th>
                <th width="12%">Cantidad</th>
                <th width="20%">Precio Unitario</th>
                <th width="20%">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $contador = 0;
            $total_general = 0;
            foreach ($detalles_productos as $det) {
                $precio_u = $det['precioVenta'];
                $cantidad = $det['cantidad'];
                $subtotal = $cantidad * $precio_u;
                $total_general += $subtotal;
            ?>
            <tr>
                <td class="text-center"><?php echo ++$contador; ?></td>
                <td><?php echo $det['nomProductos']; ?></td>
                <td class="text-center"><?php echo $cantidad; ?></td>
                <td class="text-right">Gs. <?php echo number_format($precio_u, 0, ',', '.'); ?></td>
                <td class="text-right">Gs. <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
            </tr>
            <?php } ?>
            <tr>
                <td colspan="4" class="text-right"><b>Total</b></td>
                <td class="text-right"><b>Gs. <?php echo number_format($total_general, 0, ',', '.'); ?></b></td>
            </tr>
        </tbody>
    </table>

    <!-- MONTO TOTAL DESTACADO -->
    <div style="text-align: right; margin-top: 15px; font-size: 15px;">
        <b>Monto Total: Gs. <?php echo number_format($total_general, 0, ',', '.'); ?></b>
    </div>

    <!-- PIE DE FACTURA -->
    <div class="footer-factura">
        ------------------------------------------------------------------------------------------------------------------<br>
        <b>USUARIO:</b> <?php echo isset($email_session) ? $email_session : 'Administrador'; ?><br><br>
        <i>"ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAÍS, EL USO ILÍCITO DE ÉSTA SERÁ SANCIONADO DE ACUERDO A LA LEY"</i><br><br>
        <b>¡GRACIAS POR SU PREFERENCIA!</b>
    </div>

</div>

<div class="text-center no-print" style="margin-top: 20px;">
    <a href="index.php" class="btn btn-secondary" style="padding: 10px 20px; background: #6c757d; color: #fff; text-decoration: none; border-radius: 4px;">Volver al Listado</a>
</div>

</body>
</html>