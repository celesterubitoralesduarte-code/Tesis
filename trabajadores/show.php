<?php
include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');

include('../app/controllers/usuarios/show_usuario.php');
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0">Datos Registrados</h1>
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
           <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title"><font dir="auto" style="vertical-align: inherit;"><font dir="auto" style="vertical-align: inherit;"> Datos del Usuario</font></font></h3>

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
                        
                          <div class="form-group">
                           <label for="">CI</label>
                           <input type="text" name="ciTrabajador" class="form-control" value="<?php echo $ciTrabajador ?? '';?>" disabled>
                          </div>
                          <div class="form-group">
                           <label for="">Nombres</label>
                           <input type="text" name="NomTrabajadores" class="form-control" value="<?php echo $NomTrabajadores ?? ''; ?>" disabled> </div>
                           <div class="form-group">
                           <label for="">Usuario</label>
                           <input type="text" name="usuarioTrabajador" class="form-control" value="<?php echo $usuarioTrabajador ?? '';?>" disabled>
                          </div>
                            <div class="form-group">
                           <label for="">Rol del Usuario</label>
                           <input type="text" name="" class="form-control" value="<?php echo $rol_name ?? '';?>" disabled>
                          </div>
                           <div class="form-group">
                           <label for="">Teléfono</label>
                           <input type="tel" name="TelefTrabaj" class="form-control" value="<?php echo $TelefTrabaj ?? '';?>" disabled>
                          </div>
                        
                          <hr>
                          <div class="form-group">
                            <a href="index.php" class= "btn btn-secondary">Volver</a>
                           
                          </div>
                       
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