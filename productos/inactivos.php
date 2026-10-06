<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');
// Incluimos el controlador específico para inactivos
include_once __DIR__ . '/../app/controllers/productos/listado_de_productos_inactivos.php';
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
            <h1 class="m-0">Productos Inactivos</h1>
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
             <div class="card card-outline card-warning">
                  <div class="card-header">
                    <h3 class="card-title">Productos Desactivados Registrados</h3>

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
                   <table id="example1" class="table table-bordered table-striped table-sm">
    <thead>
        <tr>
            <th><center>Nro</center></th>
            <th><center>Código</center></th>                        
            <th><center>Nombre</center></th>
            <th><center>Stock</center></th>
            <th><center>Stock<br>Mínimo</center></th>
            <th><center>Precio<br>Compra</center></th>
            <th><center>Precio<br>Venta</center></th>
            <th><center>Fecha<br>Ingreso</center></th>
            <th><center>Usuario</center></th>
            <th><center>Unidad de<br>Medida</center></th>
            <th><center>Acciones</center></th>
        </tr>
    </thead>
    <tbody>
        <?php  
        $contador = 0;
        foreach ($productos_datos as $productos_dato) { 
            $idProductos = $productos_dato['idProductos'];
            $precioCompra = (float)$productos_dato['precioCompra'];
            $precioVenta = (float)$productos_dato['precioVenta'];

            $stock_actual = (float)$productos_dato['stockProductos'];
            $stock_minimo = (float)$productos_dato['stockMinimo'];

            $unidad = ($productos_dato['unidadMedida'] == 'Unidades (Und)') ? 'Und' : 'Kg';

            $estilo_stock = ($stock_actual <= $stock_minimo) 
                ? 'style="background-color: #ee868b; white-space: nowrap;"' 
                : 'style="white-space: nowrap;"';
        ?>
            <tr>
                <td><center><?php echo $contador = $contador + 1; ?></center></td>
                <td><?php echo $productos_dato['codigo']; ?></td>
                <td><?php echo $productos_dato['nomProductos']; ?></td>
                
                <td <?php echo $estilo_stock; ?>>
                    <?php echo $stock_actual . ' ' . $unidad; ?>
                </td>

                <td style="white-space: nowrap;">
                    <?php echo $stock_minimo . ' ' . $unidad; ?>
                </td>

                <td style="white-space: nowrap;">
                    <?php echo "Gs. " . number_format($precioCompra, 0, ',', '.'); ?>
                </td>
                <td style="white-space: nowrap;">
                    <?php echo "Gs. " . number_format($precioVenta, 0, ',', '.'); ?>
                </td>
                
                <td style="white-space: nowrap;">
                   <?php 
        echo !empty($productos_dato['fecha_ingreso']) 
            ? date('d/m/Y', strtotime($productos_dato['fecha_ingreso'])) 
            : ''; 
    ?>
                </td>
                
                <td><?php echo $productos_dato['usuarioTrabajador'] ?? $productos_dato['idTrabajadores']; ?></td>
                <td><?php echo $productos_dato['unidadMedida']; ?></td>
                
               <td style="white-space: nowrap;">
    <center>
        <div class="btn-group">
            <a href="show.php?id=<?php echo $idProductos; ?>" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Ver</a>
            <!-- Botón para activar apuntando al controlador de activación -->
            <a href="../app/controllers/productos/activar.php?id=<?php echo $idProductos; ?>" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Activar</a>
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
            "emptyTable": "No hay productos inactivos",
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