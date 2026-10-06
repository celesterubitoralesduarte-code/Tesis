<?php
include('../../config.php');

// Recibimos el ID de la venta que se envió por la URL
$id_ventas = $_GET['id'] ?? $_GET['id_ventas'] ?? 0;

if (empty($id_ventas)) {
    echo "No se especificó la venta a imprimir.";
    exit;
}

// 1. Consultar los datos de la venta y del cliente
$sql_ventas = "SELECT v.*, c.nombre_cliente, c.ruc_ci_cliente, c.celular_cliente 
              FROM ventas v 
              INNER JOIN clientes c ON v.id_cliente = c.id_cliente 
              WHERE v.id_ventas = :id_ventas";
$query_ventas = $pdo->prepare($sql_ventas);
$query_ventas->execute([':id_ventas' => $id_ventas]);
$ventas = $query_ventas->fetch(PDO::FETCH_ASSOC);

if (!$ventas) {
    echo "La venta no existe.";
    exit;
}

// 2. Consultar los productos (detalles) de esta venta
$sql_detalle = "SELECT dt.*, p.nomProductos, p.precioVenta 
                FROM tb_detalle_ventas dt 
                INNER JOIN productos p ON dt.idProductos = p.idProductos 
                WHERE dt.id_ventas = :id_ventas";
$query_detalle = $pdo->prepare($sql_detalle);
$query_detalle->execute([':id_ventas' => $id_ventas]);
$detalles = $query_detalle->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
   
    <style>
        /* Estilos optimizados para impresoras térmicas (ancho aprox 80mm) */
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            width: 280px;
            margin: 0 auto;
            color: #000;
            background: #fff;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .linea { border-bottom: 1px dashed #000; margin: 5px 0; }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }
        th, td {
            padding: 3px 0;
            text-align: left;
        }
        th { border-bottom: 1px solid #000; }
        .totales {
            margin-top: 5px;
            font-size: 12px;
        }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print();">

    <!-- Cabecera del Ticket -->
    <div class="text-center">
        <h3 style="margin: 0;">CARNICERIA LOS HERMANOS</h3>
        <p style="margin: 2px 0;">RUC: 12345678-9</p>
        <p style="margin: 2px 0;">Tel: 0900 123 456</p>
    </div>

    <div class="linea"></div>

    <p style="margin: 2px 0;"><strong>Ticket N°:</strong> <?php echo str_pad($ventas['id_ventas'], 6, "0", STR_PAD_LEFT); ?></p>
    <p style="margin: 2px 0;"><strong>Fecha:</strong> <?php echo $ventas['fyh_creacion']; ?></p>
    <p style="margin: 2px 0;"><strong>Cliente:</strong> <?php echo $ventas['nombre_cliente']; ?></p>
    <p style="margin: 2px 0;"><strong>RUC/CI:</strong> <?php echo $ventas['ruc_ci_cliente']; ?></p>

    <div class="linea"></div>

    <!-- Detalle de Productos -->
    <table>
        <thead>
            <tr>
                <th>Artículo / Cant / P.Unit</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $subtotal_general = 0;
            foreach ($detalles as $det) { 
                $subtotal = $det['cantidad'] * $det['precioVenta'];
                $subtotal_general += $subtotal;
            ?>
            <tr>
                <td colspan="2" class="bold"><?php echo $det['nomProductos']; ?></td>
            </tr>
            <tr>
                <td>
                    <?php 
                        // Formatea la cantidad si es peso o unidad entera de forma limpia
                        $cantidad_formateada = (floor($det['cantidad']) == $det['cantidad']) ? number_format($det['cantidad'], 0) : number_format($det['cantidad'], 3, ',', '.');
                        echo "  " . $cantidad_formateada . " Kg x " . number_format($det['precioVenta'], 0, ',', '.'); 
                    ?>
                </td>
                <td class="text-right"><?php echo number_format($subtotal, 0, ',', '.'); ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="linea"></div>

    <!-- Totales -->
    <div class="totales">
        <table style="font-size: 12px;">
            <tr>
                <td class="bold">TOTAL A PAGAR:</td>
                <td class="text-right bold"><?php echo number_format($ventas['total_pagado'], 0, ',', '.'); ?> Gs.</td>
            </tr>
        </table>
    </div>

    <div class="linea"></div>

    <div class="text-center" style="margin-top: 10px;">
        <p style="margin: 2px 0;">¡Gracias por su compra!</p>
        <p style="margin: 2px 0; font-size: 10px;">Software de Gestión</p>
    </div>

    <div class="text-center no-print" style="margin-top: 15px;">
        <button onclick="window.print();" style="padding: 5px 10px; cursor: pointer;">Imprimir de nuevo</button>
        <button onclick="window.close();" style="padding: 5px 10px; cursor: pointer;">Cerrar</button>
    </div>

</body>
</html>