<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');

// Inicializamos las variables por defecto para evitar errores si no llega el ID
$nro_venta = '';
$fecha_venta = '';
$nombre_cliente = '';
$ruc_ci_cliente = '';
$celular_cliente = '';
$email_cliente = '';
$detalles_productos = [];

// Incluimos el controlador usando la ruta absoluta basada en __DIR__
include_once __DIR__ . '/../app/controllers/ventas/show_ventas.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Detalles de la Venta Nro: <?php echo $nro_venta ?? ''; ?></h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            
            <!-- TARJETA SUPERIOR: DATOS DEL CLIENTE Y VENTA (Horizontal y Compacta) -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-user"></i> Datos del Cliente y Venta</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label style="font-size: 13px; margin-bottom: 2px;">Cliente:</label>
                                    <input type="text" class="form-control form-control-sm" value="<?php echo $nombre_cliente ?? ''; ?>" readonly>
                                </div>
                                <div class="col-md-2">
                                    <label style="font-size: 13px; margin-bottom: 2px;">RUC / CI:</label>
                                    <input type="text" class="form-control form-control-sm" value="<?php echo $ruc_ci_cliente ?? ''; ?>" readonly>
                                </div>
                                <div class="col-md-2">
                                    <label style="font-size: 13px; margin-bottom: 2px;">Celular:</label>
                                    <input type="text" class="form-control form-control-sm" value="<?php echo $celular_cliente ?? ''; ?>" readonly>
                                </div>
                                <div class="col-md-2">
                                    <label style="font-size: 13px; margin-bottom: 2px;">Correo:</label>
                                    <input type="text" class="form-control form-control-sm" value="<?php echo $email_cliente ?? ''; ?>" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label style="font-size: 13px; margin-bottom: 2px;">Fecha y Hora:</label>
                                    <input type="text" class="form-control form-control-sm" value="<?php echo $fecha_venta ?? ''; ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TARJETA INFERIOR: PRODUCTOS COMPRADOS (Ancho completo) -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-shopping-basket"></i> Productos Comprados</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;"><center>Nro</center></th>
                                        <th>Nombre del Producto</th>
                                        <th style="width: 150px;"><center>Cantidad / Peso</center></th>
                                        <th style="width: 180px;"><center>Precio Unitario</center></th>
                                        <th style="width: 180px;"><center>Subtotal</center></th>
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
                                            <td><center><?php echo ++$contador; ?></center></td>
                                            <td><?php echo $det['nomProductos']; ?></td>
                                            <td><center><?php echo $cantidad; ?></center></td>
                                            <td><center><?php echo "Gs. " . number_format($precio_u, 0, ',', '.'); ?></center></td>
                                            <td><center><?php echo "Gs. " . number_format($subtotal, 0, ',', '.'); ?></center></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="index.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Volver al Listado</a>
                                </div>
                                <div class="col-md-6 text-right">
                                    <h3><b>Total Pagado: </b> <span class="text-success"><?php echo "Gs. " . number_format($total_general, 0, ',', '.'); ?></span></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>