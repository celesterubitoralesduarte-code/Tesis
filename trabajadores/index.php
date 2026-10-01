<?php
include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');


include_once __DIR__ . '/../app/controllers/usuarios/listado_usuarios.php';
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
            <h1 class="m-0">Listado de Usuarios</h1>
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
                    <h3 class="card-title">Usuarios Registrados<font dir="auto" style="vertical-align: inherit;"><font dir="auto" style="vertical-align: inherit;"></font></font></h3>

                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse" aria-label="Contraer tarjeta">
                        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                      </button>
                    </div>
                    <!-- /.card-tools -->
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body" style="box-sizing: border-box; display: block;"><font dir="auto" style="vertical-align: inherit;"><font dir="auto" style="vertical-align: inherit;">
                   
                       <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                         <th>Nro</th>                
                         <th>Nombres</th>
                         <th>Usuario</th>
                         <th>Rol del Usuario</th>
                         <th>Acciones</th>
                      </tr>
                  </thead>
                 
                   <tbody>
                        <?php  
                        $contador = 0;
                        foreach ($usuarios_datos as $usuarios_datos){
                          $id_Trabajadores = $usuarios_datos['idTrabajadores']?>
                        <tr>
                          <td><center><?php echo $contador = $contador + 1;?></center></td>
                          
                          <td><?php echo $usuarios_datos['NomTrabajadores'];?></td>
                         <td><?php echo $usuarios_datos['usuarioTrabajador'];?></td>
                         <td><center><?php echo $usuarios_datos['rol_name'];?></center></td>
                         <td>
                         <center>
                          <div class="btn-group">
                            <a href="show.php?id=<?php echo $id_Trabajadores; ?>" type="button" class="btn btn-info"><font dir="auto" style="vertical-align: inherit;"><font dir="auto" style="vertical-align: inherit;"><i class="fa fa-eye" ></i>Ver</font></font></a>
                            <a href="update.php?id=<?php echo $id_Trabajadores; ?>" type="button" class="btn btn-success"><font dir="auto" style="vertical-align: inherit;"><font dir="auto" style="vertical-align: inherit;"><i class="fa fa-pencil-alt"></i>Editar</font></font></a>
                            <a href="delete.php?id=<?php echo $id_Trabajadores; ?>" type="button" class="btn btn-danger"><font dir="auto" style="vertical-align: inherit;"><font dir="auto" style="vertical-align: inherit;"><i class="fa fa-trash"></i>Borrar</font></font></a>
                          </div>
                         </center>

                         </td>
                        </tr>
                       <?php
                        }
                        ?>
                     </tbody>
                  <tfoot>
                 <tr>
                          <th>Nro</th>
                          <th>Nombres</th>
                          <th>Usuario</th>
                          <th>Rol del Usuario</th>
                          <th>Acciones</th>
                      </tr>
                  </tfoot>
                </table>
                <table id="example1" class="table table-bordered table-striped">
                  </font></font></div>
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
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Usuarios",
            "infoEmpty": "Mostrando 0 a 0 de 0 Usuarios",
            "infoFiltered": "(Filtrado de _MAX_ total Usuarios)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Usuarios",
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
            Text: 'Reportes',
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