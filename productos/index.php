<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');
include_once __DIR__ . '/../app/controllers/productos/listado_de_productos.php';
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
            <h1 class="m-0">Listado de Productos</h1>
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
                    <h3 class="card-title">Productos Registrados</h3>

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
                         <th><center>Código</center></th>                        
                         <th><center>Nombre</center></th>
                         <th><center>Stock</center></th>
                         <th><center>Stock Minimo</center></th>
                         <th><center>Precio Compra</center></th>
                         <th><center>Precio Venta</center></th>
                         <th><center>Fecha Ingreso</center></th>
                         <th><center>Usuario</center></th>
                         <th><center>Unidad de Medida</center></th>
                         <th><center>Acciones</center></th>
                      </tr>
                  </thead>
                    <tbody>
                        <?php  
                        $contador = 0;
                        foreach ($productos_datos as $productos_datos){ 
                            $idProductos = $productos_datos['idProductos'];

                            // Corrección automática por código para montos menores a 1000 (ej: 72 -> 72000)
                            $precioCompra = $productos_datos['precioCompra'];
                            if ($precioCompra > 0 && $precioCompra < 1000) {
                                $precioCompra = $precioCompra * 1000;
                            }

                            $precioVenta = $productos_datos['precioVenta'];
                            if ($precioVenta > 0 && $precioVenta < 1000) {
                                $precioVenta = $precioVenta * 1000;
                            }
                        ?>
                          
                         <tr>
                            <td><center><?php echo $contador = $contador + 1; ?></center></td>
                            <td><?php echo $productos_datos['codigo'];?></td>
                            <td><?php echo $productos_datos['nomProductos'];?></td>
                            
                          <!-- Columna Stock -->
<td>
    <?php 
    if ($productos_datos['unidadMedida'] == 'Unidades (Und)') {
        echo number_format((float)$productos_datos['stockProductos'], 0, ',', '.');
    } else {
        // Muestra enteros sin decimales sobrantes (.000) o decimales reales si existen
        echo number_format((float)$productos_datos['stockProductos'], (floor($productos_datos['stockProductos']) == $productos_datos['stockProductos'] ? 0 : 3), ',', '.');
    }
    ?>
</td>

<!-- Columna Stock Mínimo -->
<td>
    <?php 
    if ($productos_datos['unidadMedida'] == 'Unidades (Und)') {
        echo number_format((float)$productos_datos['stockMinimo'], 0, ',', '.');
    } else {
        echo number_format((float)$productos_datos['stockMinimo'], (floor($productos_datos['stockMinimo']) == $productos_datos['stockMinimo'] ? 0 : 3), ',', '.');
    }
    ?>
</td>

                            <!-- Precios en Guaraníes Paraguayos (Gs. 72.000, Gs. 85.000, etc.) -->
                            <td><?php echo "Gs. " . number_format($precioCompra, 0, ',', '.'); ?></td>
                            <td><?php echo "Gs. " . number_format($precioVenta, 0, ',', '.'); ?></td>
                            
                            <!-- Fecha de Ingreso sin Hora -->
                            <td><?php echo date('Y-m-d', strtotime($productos_datos['fecha_ingreso'])); ?></td>
                            
                            <td><?php echo $productos_datos['usuarioTrabajador'];?></td>
                            <td><?php echo $productos_datos['unidadMedida'];?></td>
                            <td>
                                 <center>
                          <div class="btn-group">
                            <a href="show.php?id=<?php echo $idProductos?? ''; ?>" type="button" class="btn btn-info btn-sm"><font dir="auto" style="vertical-align: inherit;"><font dir="auto" style="vertical-align: inherit;"><i class="fa fa-eye" ></i>Ver</font></font></a>
                            <a href="update.php?id=<?php echo $idProductos?? ''; ?>" type="button" class="btn btn-success btn-sm"><font dir="auto" style="vertical-align: inherit;"><font dir="auto" style="vertical-align: inherit;"><i class="fa fa-pencil-alt"></i>Editar</font></font></a>
                            <a href="delete.php?id=<?php echo $idProductos?? ''; ?>" type="button" class="btn btn-danger btn-sm"><font dir="auto" style="vertical-align: inherit;"><font dir="auto" style="vertical-align: inherit;"><i class="fa fa-trash"></i>Borrar</font></font></a>
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

<?php include('../layout/parte2.php');?>

<script>
$(function () {
    $("#example1").DataTable({
        "pageLength": 5,
        "language": {
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Productos",
            "infoEmpty": "Mostrando 0 a 0 de 0 Productos",
            "infoFiltered": "(Filtrado de _MAX_ total Productos)",
            "infoPostFix": "",
            "thousands": ".",
            "lengthMenu": "Mostrar _MENU_ Productos",
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