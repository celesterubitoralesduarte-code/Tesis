<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');
include_once __DIR__ . '/../app/controllers/productos/cargar_producto.php';

// Función para dar formato de 5 dígitos con ceros a la izquierda
function ceros(int $numero){
    return str_pad($numero, 5, "0", STR_PAD_LEFT);
}

// Extraemos el número de código más alto registrado actualmente (ej: de 'P-00034' extrae 34)
$sql_max_codigo = "SELECT MAX(CAST(SUBSTRING(codigo, 3) AS UNSIGNED)) AS max_codigo 
                   FROM productos 
                   WHERE codigo LIKE 'P-%'";
$query_max_codigo = $pdo->prepare($sql_max_codigo);
$query_max_codigo->execute();
$row_max_codigo = $query_max_codigo->fetch(PDO::FETCH_ASSOC);

// Si no hay productos o max_codigo es null, empieza en 1; de lo contrario suma +1 al código más alto
$siguiente_numero = ($row_max_codigo['max_codigo'] ?? 0) + 1;
$nuevo_codigo = "P-" . ceros($siguiente_numero);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0">Actualizar Producto</h1>
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
           <div class="card card-success">
                  <div class="card-header">
                    <h3 class="card-title">Ingrese los Datos con Cuidado</h3>

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
                        <form action="../app/controllers/productos/update.php" method="post">
                            <input type="hidden" name="idProductos" value="<?php echo $idProductos_get; ?>">
                          
                         <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Código:</label>
                                    <input type="text" class="form-control" value="<?php echo $codigo; ?>" disabled>
                                    <input type="hidden" name="codigo" value="<?php echo $codigo; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="">Nombre del Producto:</label>
                                    <input type="text" name="nomProductos" value="<?php echo $nomProductos; ?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Usuario</label>
                                    <input type="text" class="form-control" value="<?php echo $usuarioTrabajador ?? ''; ?>" disabled>
                                    <input type="hidden" name="idTrabajadores" value="<?php echo $idTrabajadores ?? ''; ?>">
                                </div>
                            </div>
                         </div>
<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            <label for="">Stock:</label>
          <input type="number" step="any" name="stockProductos" value="<?php echo (float)$stockProductos; ?>" class="form-control" required>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="">Stock Minimo:</label>
            <input type="number" step="any" name="stockMinimo" value="<?php echo (float)$stockMinimo; ?>" class="form-control" required>
        </div>
    </div>
   <div class="col-md-2">
    <div class="form-group">
        <label for="">Precio Compra:</label>
        <input type="text" name="precioCompra" value="<?php echo number_format($precioCompra, 0, '', '.'); ?>" class="form-control formato-precio" required>
    </div>
</div>
    <div class="col-md-2">
    <div class="form-group">
        <label for="">Precio Venta:</label>
        <input type="text" name="precioVenta" value="<?php echo number_format($precioVenta, 0, '', '.'); ?>" class="form-control formato-precio" required>
    </div>
</div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="">Fecha Ingreso:</label>
            <!-- date('Y-m-d', strtotime(...)) recorta la hora para que el navegador pueda leer la fecha -->
            <input type="date" name="fecha_ingreso" class="form-control" value="<?php echo date('Y-m-d', strtotime($fecha_ingreso)); ?>" required>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="">Unidad de Medida:</label>
            <select name="unidadMedida" class="form-control" required>
                <option value="Kilogramos (Kg)" <?php if ($unidadMedida == "Kilogramos (Kg)" || $unidadMedida == "Kg") echo 'selected'; ?>>Kilogramos (Kg)</option>
                <option value="Gramos (g)" <?php if ($unidadMedida == "Gramos (g)" || $unidadMedida == "g") echo 'selected'; ?>>Gramos (g)</option>
                <option value="Unidades (Und)" <?php if ($unidadMedida == "Unidades (Und)" || $unidadMedida == "Und") echo 'selected'; ?>>Unidades (Und)</option>
            </select>
        </div>
    </div>
</div>
                         </div>

                          <div class="form-group mt-3">
                            <a href="index.php" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-success">Actualizar Producto</button>
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