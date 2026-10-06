<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');

// Asegúrate de que este archivo contenga el ORDER BY v.id_ventas DESC
include_once __DIR__ . '/../app/controllers/ventas/listado_de_ventas.php';
include_once __DIR__ . '/../app/controllers/ventas/listado_de_ventas_realizadas.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Listado de Ventas Realizadas</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Ventas Registradas</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th><center>Nro</center></th>
                                        <th><center>Fecha</center></th>
                                        <th><center>Nro de Venta</center></th>
                                        <th><center>Productos</center></th>
                                        <th><center>Cliente</center></th>
                                        <th><center>Total de Venta</center></th>
                                        <th><center>Acciones</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $contador = 0;
                                    if (isset($ventas_datos) && is_array($ventas_datos)) {
                                        foreach ($ventas_datos as $venta) {
                                            $id_ventas = $venta['id_ventas'];
                                            $nro_venta = isset($venta['nro_venta']) && $venta['nro_venta'] != 0 ? $venta['nro_venta'] : $id_ventas;
                                            $nombre_cliente = !empty($venta['nombre_cliente']) ? $venta['nombre_cliente'] : 'Sin Cliente';
                                            $fecha_creacion = date('d/m/Y', strtotime($venta['fyh_creacion']));

                                            // Cálculo del total real de la venta
                                            $sql_calc = "SELECT dt.cantidad, p.precioVenta 
                                                       FROM tb_detalle_ventas AS dt 
                                                       INNER JOIN productos AS p ON dt.idProductos = p.idProductos 
                                                       WHERE dt.id_ventas = :id_ventas";
                                            $query_calc = $pdo->prepare($sql_calc);
                                            $query_calc->execute([':id_ventas' => $id_ventas]);
                                            $detalles_calc = $query_calc->fetchAll(PDO::FETCH_ASSOC);

                                            $total_real_venta = 0;
                                            foreach ($detalles_calc as $det) {
                                                $precio_u = isset($det['precioVenta']) ? $det['precioVenta'] : 0;
                                                $total_real_venta += ($det['cantidad'] * $precio_u);
                                            }
                                    ?>
                                        <tr>
                                            <td><center><?php echo ++$contador; ?></center></td>
                                            <td><center><?php echo $fecha_creacion; ?></center></td>
                                            <td><center><?php echo $nro_venta; ?></center></td>
                                            <td>
                                                <center>
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-productos<?php echo $id_ventas; ?>">
                                                        <i class="fa fa-shopping-basket"></i> Productos
                                                    </button>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-cliente<?php echo $id_ventas; ?>">
                                                        <i class="fa fa-user"></i> <?php echo $nombre_cliente; ?>
                                                    </button>
                                                </center>
                                            </td>
                                            <td><center><?php echo "Gs. " . number_format($total_real_venta, 0, ',', '.'); ?></center></td>
                                            <td>
                                                <center>
                                                    <div class="btn-group">
                                                        <a href="show.php?id=<?php echo $id_ventas; ?>" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Ver</a>
                                                        
                                                        <form action="../app/controllers/ventas/delete.php" method="post" onclick="preguntar(event, this)" style="display:inline;">
                                                            <input type="text" name="id_ventas" value="<?php echo $id_ventas; ?>" hidden>
                                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Borrar</button>
                                                        </form>

                                                       
                                                    </div>
                                                </center>
                                            </td>
                                        </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODALES DE PRODUCTOS -->
<?php
if (isset($ventas_datos) && is_array($ventas_datos)) {
    foreach ($ventas_datos as $venta) {
        $id_ventas = $venta['id_ventas'];
        $nro_venta = isset($venta['nro_venta']) && $venta['nro_venta'] != 0 ? $venta['nro_venta'] : $id_ventas;
?>
<div class="modal fade" id="modal-productos<?php echo $id_ventas; ?>">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1d36b6; color: white">
                <h4 class="modal-title">Productos de la Venta Nro: <?php echo $nro_venta; ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nro</th>
                            <th>Nombre del Producto</th>
                            <th>Cantidad / Peso</th>
                            <th>Precio Unitario</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_detalles = "SELECT dt.*, p.nomProductos, p.precioVenta 
                                       FROM tb_detalle_ventas AS dt 
                                       INNER JOIN productos AS p ON dt.idProductos = p.idProductos 
                                       WHERE dt.id_ventas = :id_ventas";
                        $query_detalles = $pdo->prepare($sql_detalles);
                        $query_detalles->execute([':id_ventas' => $id_ventas]);
                        $detalles_datos = $query_detalles->fetchAll(PDO::FETCH_ASSOC);

                        $cont_det = 0;
                        $suma_total_venta = 0;
                        foreach ($detalles_datos as $detalle) {
                            $precio_unitario = isset($detalle['precioVenta']) ? $detalle['precioVenta'] : 0;
                            $subtotal = $detalle['cantidad'] * $precio_unitario;
                            $suma_total_venta += $subtotal;
                        ?>
                            <tr>
                                <td><?php echo ++$cont_det; ?></td>
                                <td><?php echo $detalle['nomProductos']; ?></td>
                                <td><?php echo $detalle['cantidad']; ?></td>
                                <td><?php echo "Gs. " . number_format($precio_unitario, 0, ',', '.'); ?></td>
                                <td><?php echo "Gs. " . number_format($subtotal, 0, ',', '.'); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <h4 class="text-right mt-3"><b>Total General: </b> <?php echo "Gs. " . number_format($suma_total_venta, 0, ',', '.'); ?></h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<?php
    }
}
?>
<!-- FIN DE MODALES DE PRODUCTOS -->

<!-- MODALES DE CLIENTES -->
<?php
if (isset($ventas_datos) && is_array($ventas_datos)) {
    foreach ($ventas_datos as $venta) {
        $id_ventas = $venta['id_ventas'];
        $nro_venta = isset($venta['nro_venta']) && $venta['nro_venta'] != 0 ? $venta['nro_venta'] : $id_ventas;
        
        $nombre_cliente  = !empty($venta['nombre_cliente']) ? $venta['nombre_cliente'] : 'Sin Cliente';
        $ruc_ci_cliente  = !empty($venta['ruc_ci_cliente']) ? $venta['ruc_ci_cliente'] : 'S/N';
        $celular_cliente = !empty($venta['celular_cliente']) ? $venta['celular_cliente'] : 'No registrado';
        $email_cliente   = !empty($venta['email_cliente']) ? $venta['email_cliente'] : 'No registrado';
?>
<div class="modal fade" id="modal-cliente<?php echo $id_ventas; ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #17a2b8; color: white">
                <h4 class="modal-title"><i class="fa fa-user"></i> Datos del Cliente (Venta Nro: <?php echo $nro_venta; ?>)</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nombre del Cliente:</label>
                    <input type="text" class="form-control" value="<?php echo $nombre_cliente; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>RUC / CI:</label>
                    <input type="text" class="form-control" value="<?php echo $ruc_ci_cliente; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Celular:</label>
                    <input type="text" class="form-control" value="<?php echo $celular_cliente; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Correo Electrónico:</label>
                    <input type="text" class="form-control" value="<?php echo $email_cliente; ?>" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<?php
    }
}
?>
<!-- FIN DE MODALES DE CLIENTES -->

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>

<script>
    $(function () {
        $("#example1").DataTable({

        "pageLength":10 ,

        "language": {
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Ventas",
            "infoEmpty": "Mostrando 0 a 0 de 0 Ventas",
            "infoFiltered": "(Filtrado de _MAX_ total Ventas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Ventas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",

            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },

        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,

        buttons: [{
            extend: 'collection',
            text: 'Reportes',
            orientation: 'landscape',
            buttons: [{
                text: 'Copiar',
                extend: 'copy',
            },{
                extend: 'pdf',
            },{
                extend: 'csv',
            },{
                extend: 'excel',
            },{
                text: 'Imprimir',
                extend: 'print',
            }]
        },{
            extend: 'colvis',
            text: 'Visor de Columnas',
            collectionLayout: 'fixed three-column',
        }

        ],

    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

});
    
    function preguntar(event, form) {
        event.preventDefault();
        Swal.fire({
            title: '¿Desea eliminar esta venta?',
            text: "¡Esta acción no se puede deshacer!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>