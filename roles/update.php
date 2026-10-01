<?php
include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');

include('../app/controllers/roles/update_roles.php');
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0">Edición del Rol</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
      
      <div class="row">
        <div class="col-md-6">
           <div class="card card-success">
                  <div class="card-header">
                    <h3 class="card-title"><font dir="auto" style="vertical-align: inherit;"><font dir="auto" style="vertical-align: inherit;">Ingrese los Datos con Cuidado</font></font></h3>

                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse" aria-label="Contraer tarjeta">
                        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                      </button>
                    </div>
                    <!-- /.card-tools -->
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body"><font dir="auto" style="display: block;">
                    <div class="row">
                      <div class="col-md-12">
                        <form action="../app/controllers/roles/update.php" method="post">
                          
                          <div class="form-group">
                            <input type="text" name="id_rol" value="<?php echo $id_rol_get ??''; ?>" hidden>
                           <label for="">Nombre del Rol</label>
                           <input type="text" name="rol_name" class="form-control" placeholder= "Escriba el rol..." value="<?php echo $rol_name ??'' ;?>" required>
                          </div>
                          
                          <div class="form-group">
                            <a href="index.php" class= "btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-success" >Actualizar</button>
                          </div>
                        </form>
                      </div>
                    </div>
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
<?php include('../layout/mensajes.php');?>