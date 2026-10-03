<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');
include_once __DIR__ . '/../app/controllers/compras/listado_de_compras.php';
?>

<?php if (isset($_SESSION['mensaje'])): ?>
<script>
    Swal.fire({
        icon: '<?php echo $_SESSION['icono']; ?>',
        title: '<?php echo $_SESSION['mensaje']; ?>',
        showConfirmButton: false,
        timer: 2500
    });
</script>
<?php
unset($_SESSION['mensaje']);
unset($_SESSION['icono']);
?>
<?php endif; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0">Listado de Compras</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
      
      <div class="row">
        <div class="col-md-12">
             <div class="card card-outline card-success">
                  <div class="card-header">
                    <h3 class="card-title">Compras Registradas</h3>

                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse" aria-label="Contraer tarjeta">
                        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                      </button>
                    </div>
                    <!-- /.card-tools -->
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body" style="box-sizing: border-box; display: block;">
                    
                       <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                         <th><center>Nro</center></th>
                         <th><center>Numero de la Compra</center></th>                        
                         <th><center>Producto</center></th>
                         <th><center>Fecha de Compra</center></th>
                         <th><center>Proveedor</center></th>
                         <th><center>Comprobante</center></th>
                         <th><center>Usuario</center></th>
                         <th><center>Precio Compra</center></th>
                         <th><center>Cantidad</center></th>
                         <th><center>Acciones</center></th>
                      </tr>
                  </thead>
                    <tbody>
                        <?php  
                        $contador = 0;
                        foreach ($compras_datos as $compras_dato){ 
                            $id_compra = $compras_dato['id_compra'];
                            $contador++;
                        ?>                          
                         <tr>
                            <td><?php echo $contador; ?></td>
                            <td><?php echo $compras_dato['nro_compra']; ?></td>
                            <td>
                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-producto<?php echo $id_compra; ?>">
                                    <?php echo $compras_dato['nombre_producto']; ?>
                                </button>
                 <!-- Modal para visualizar datos de los productos -->
<div class="modal fade" id="modal-producto<?php echo $id_compra; ?>">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #07b0d6; color: white">
                <h4 class="modal-title">Datos del Producto</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Código</label>
                            <input type="text" value="<?php echo $compras_dato['codigo']; ?>" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Nombre</label>
                            <input type="text" value="<?php echo $compras_dato['nombre_producto']; ?>" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Stock</label>
                            <input type="text" value="<?php echo (int)$compras_dato['stock']; ?>" class="form-control" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Stock Mínimo</label>
                            <input type="text" value="<?php echo (int)$compras_dato['stock_minimo']; ?>" class="form-control" disabled>
                        </div>
                    </div>
                   <div class="col-md-4">
    <div class="form-group">
        <label for="">Precio Compra</label>
        <input type="text" value="<?php echo "Gs. " . number_format($compras_dato['precio_compra_producto'] * 1000, 0, ',', '.'); ?>" class="form-control" disabled>
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <label for="">Precio Venta</label>
        <input type="text" value="<?php echo "Gs. " . number_format($compras_dato['precio_venta'] * 1000, 0, ',', '.'); ?>" class="form-control" disabled>
    </div>
</div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Unidad de Medida</label>
                            <input type="text" value="<?php echo $compras_dato['unidad_medida']; ?>" class="form-control" disabled>
                        </div>                                                  
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Fecha Ingreso</label>
                            <?php 
                                $fecha_ingreso = date('Y-m-d', strtotime($compras_dato['fecha_ingreso'])); 
                            ?>
                            <input type="text" value="<?php echo $fecha_ingreso; ?>" class="form-control" disabled>
                        </div>                                                    
                    </div>  
                     <div class="col-md-4">
                          <div class="form-group">
                            <label for="">Usuario</label>
                            <input type="text" value="<?php echo $compras_dato['nombre_usuario']; ?>" class="form-control" disabled>
                        </div>                                              
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Modal-->
                            </td>
                            <td><?php echo $compras_dato['fecha_compra']; ?></td>
                            <td>
                                 <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-proveedor<?php echo $id_compra; ?>">
                                    <?php echo $compras_dato['nombre_proveedor']; ?>
                                </button>
                               
                                 <!-- Modal para visualizar datos de los proveedor -->
<div class="modal fade" id="modal-proveedor<?php echo $id_compra; ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #07b0d6; color: white">
                <h4 class="modal-title">Datos del Proveedor</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Nombre del proveedor</label>
                            <input type="text" value="<?php echo $compras_dato['nombre_proveedor'];?>" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                         <div class="form-group">
                            <label for="">Celular del proveedor</label>
                            <a href="https://wa.me/595<?php echo $compras_dato['celular_proveedor'];?>" target="_blank" class="btn btn-success form-control">
                                <i class="fa fa-phone"></i>
                                <?php echo $compras_dato['celular_proveedor'];?>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                         <div class="form-group">
                            <label for="">Teléfono del proveedor</label>
                            <input type="text" value="<?php echo $compras_dato['telefono_proveedor'];?>" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                         <div class="form-group">
                            <label for="">Empresa</label>
                            <input type="text" value="<?php echo $compras_dato['empresa'];?>" class="form-control" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                         <div class="form-group">
                            <label for="">Email del proveedor</label>
                            <input type="text" value="<?php echo $compras_dato['email_proveedor'];?>" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                         <div class="form-group">
                            <label for="">Dirección</label>
                            <input type="text" value="<?php echo $compras_dato['direccion_proveedor'];?>" class="form-control" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Modal-->
                            </td>
                            <td><?php echo $compras_dato['comprobante']; ?></td>
                            <td><?php echo $compras_dato['nombre_usuario']; ?></td>
                            <td><?php echo number_format($compras_dato['precio_compra_producto'], 0, ',', '.'); ?></td>
                            <td><?php echo $compras_dato['cantidad']; ?></td>
                            <td>
                                <center>
                                  <div class="btn-group">
                                    <a href="show.php?id=<?php echo $id_compra; ?>" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Ver</a>
                                    <a href="update.php?id=<?php echo $id_compra; ?>" class="btn btn-success btn-sm"><i class="fa fa-pencil-alt"></i> Editar</a>
                                    <a href="delete.php?id=<?php echo $id_compra; ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Borrar</a>
                                  </div>
                                </center>
                            </td>
                         </tr>

                        <?php
                        }
                        ?>
                     </tbody>
                 
                </table>
                  </div>
                  <!-- /.card-body -->
                </div> 
        </div>
      </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php include('../layout/parte2.php'); ?>

<script>
$(function () {
    $("#example1").DataTable({
        "pageLength": 5,
        "language": {
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Compras",
            "infoEmpty": "Mostrando 0 a 0 de 0 Compras",
            "infoFiltered": "(Filtrado de _MAX_ total Compras)",
            "infoPostFix": "",
            "thousands": ".",
            "lengthMenu": "Mostrar _MENU_ Compras",
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
</script>