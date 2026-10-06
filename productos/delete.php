<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');

include_once __DIR__ . '/../app/controllers/productos/cargar_producto.php';

// Ajuste de precios para el formato en Guaraníes
if (isset($precioCompra) && $precioCompra > 0 && $precioCompra < 1000) {
    $precioCompra = $precioCompra * 1000;
}
if (isset($precioVenta) && $precioVenta > 0 && $precioVenta < 1000) {
    $precioVenta = $precioVenta * 1000;
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0">Datos del Producto: <?php echo $nomProductos; ?> a ser Desactivado</h1>
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
            <div class="card card-warning"> <!-- Cambiamos a warning (amarillo) o danger si prefieres -->
                  <div class="card-header">
                    <h3 class="card-title">¿Está seguro de desactivar este producto?</h3>

                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse" aria-label="Contraer tarjeta">
                        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                    <form action="../app/controllers/productos/delete.php" method="post">
                       <input type="text" name="id_producto" value="<?php echo $idProductos_get ?>" hidden>                         
                          <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Código:</label>
                                    <input type="text" class="form-control" value="<?php echo $codigo; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                               <div class="form-group">
                                    <label for="">Nombre del Producto:</label>
                                    <input type="text" class="form-control" value="<?php echo $nomProductos; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Usuario Registrador:</label>
                                    <input type="text" class="form-control" value="<?php echo $usuarioTrabajador; ?>" disabled>
                                </div>
                            </div>
                          </div>

                          <div class="row mt-2">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Stock Actual:</label>
                                    <input type="text" value="<?php echo (float)$stockProductos; ?>" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Stock Mínimo:</label>
                                    <input type="text" value="<?php echo (float)$stockMinimo; ?>" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                               <div class="form-group">
                                    <label for="">Precio Compra:</label>
                                    <input type="text" class="form-control" value="<?php echo "Gs. " . number_format($precioCompra, 0, ',', '.'); ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                               <div class="form-group">
                                    <label for="">Precio Venta:</label>
                                    <input type="text" class="form-control" value="<?php echo "Gs. " . number_format($precioVenta, 0, ',', '.'); ?>" disabled>
                                </div>
                            </div>
                             <div class="col-md-2">
                               <div class="form-group">
                                    <label for="">Fecha Ingreso:</label>
                                    <input type="text" class="form-control" value="<?php echo $fecha_ingreso; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                   <label for="">Unidad de Medida:</label>
                                   <input type="text" class="form-control" value="<?php echo $unidadMedida; ?>" disabled>
                                </div>
                            </div>
                          </div>

                         
                          <div class="form-group mt-3">
                            <a href="index.php" class="btn btn-secondary">Cancelar</a>
                          <form action="../app/controllers/productos/delete.php" method="post">
   <input type="text" name="id_producto" value="<?php echo $idProductos_get ?>" hidden>                         
   <!-- ... tus campos ... -->
   <button class="btn btn-warning"><i class="fa fa-ban"></i> Desactivar Producto</button>
</form>
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