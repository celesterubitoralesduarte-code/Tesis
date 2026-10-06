<?php
include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');
include __DIR__ . '/../app/controllers/roles/listado_roles.php';
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0">Registro de un Nuevo Usuario</h1>
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
                        <form action="../app/controllers/usuarios/create.php" method="post" autocomplete="off">
                          <div class="form-group">
                           <label for="">CI</label>
                           <input type="number" name="ciTrabajador" class="form-control" placeholder= "Ingrese el número de cedula" required>
                          </div>
                          <div class="form-group">
                           <label for="">Nombres</label>
                           <input type="text" name="NomTrabajadores" class="form-control" placeholder= "Escriba el nombre del nuevo usuario" required>
                          </div>
                           <div class="form-group">
                           <label for="">Usuario</label>
                           <input type="text" name="usuarioTrabajador" class="form-control" placeholder= "Ingrese el usuario" autocomplete="off" required>
                          </div>

                           <div>
                           <div class="form-group">
                           <label for="">Rol del Usuario</label>
                           <select name="id_rol" id="id_rol" class="form-control">
                          
                            <?php
                            foreach ($roles_datos as $roles_dato){?>
                              <option value="<?php echo $roles_dato['id_rol']; ?>">
                                <?php echo $roles_dato['rol_name']; ?>
                             </option>
                              <?php
                            }
                            ?>
                          </select>
                          </div>

                          <div class="form-group">
                          <label for="">Contraseña</label>
                          <input type="text" name="pasworTrabaj" class="form-control" placeholder="" autocomplete="new-password" required>
                          </div>

                         <div class="form-group">
                           <label for="">Repita la Contraseña</label>
                           <input type="text" name="pasworTrabaj_repeat" class="form-control" placeholder="" autocomplete="new-password" required>
                         </div>
                           <div class="form-group">
                           <label for="">Teléfono</label>
                           <input type="tel" name="TelefTrabaj" class="form-control" placeholder= "Ingrese el número de telefono">
                          </div>
                          <hr>
                          <div class="form-group">
                            <a href="index.php" class= "btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary" >Guardar</button>
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