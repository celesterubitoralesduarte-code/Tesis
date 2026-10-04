<?php
include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');

include_once __DIR__ . '/../app/controllers/clientes/listado_de_clientes.php';
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
            <h1 class="m-0">Listado de Clientes</h1>
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
                    <h3 class="card-title">Clientes Registrados</h3>

                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                    </div>
                    <!-- /.card-tools -->
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                      <table id="example1" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                             <th>Nro</th>                
                             <th>Nombre del Cliente</th>
                             <th>RUC/CI del Cliente</th>
                             <th>Celular</th>
                             <th>Correo Electronico</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php  
                            $contador = 0;
                            foreach ($clientes_datos as $clientes_dato){
                              $id_cliente = $clientes_dato['id_cliente'];?>
                            <tr>
                              <td><center><?php echo $contador = $contador + 1;?></center></td>
                              <td><?php echo $clientes_dato['nombre_cliente'];?></td>
                              <td><?php echo $clientes_dato['ruc_ci_cliente'];?></td>
                              <td><center><?php echo $clientes_dato['celular_cliente'];?></center></td>
                              <td><center><?php echo $clientes_dato['email_cliente'];?></center></td>
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
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Clientes",
            "infoEmpty": "Mostrando 0 a 0 de 0 Clientes",
            "infoFiltered": "(Filtrado de _MAX_ total Clientes)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Clientes",
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
        }],
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
});
</script>