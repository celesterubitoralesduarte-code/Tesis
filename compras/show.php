<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');
include_once __DIR__ . '/../app/controllers/productos/listado_de_productos.php';
include_once __DIR__ . '/../app/controllers/proveedores/listado_de_proveedores.php';
include_once __DIR__ . '/../app/controllers/compras/listado_de_compras.php';
include_once __DIR__ . '/../app/controllers/compras/cargar_compra.php';

// Función para dar formato de 5 dígitos con ceros a la izquierda
function ceros(int $numero){
    return str_pad($numero, 5, "0", STR_PAD_LEFT);
}

// Extraemos el número de código más alto registrado actualmente
$sql_max_codigo = "SELECT MAX(CAST(SUBSTRING(codigo, 3) AS UNSIGNED)) AS max_codigo 
                   FROM productos 
                   WHERE codigo LIKE 'P-%'";
$query_max_codigo = $pdo->prepare($sql_max_codigo);
$query_max_codigo->execute();
$row_max_codigo = $query_max_codigo->fetch(PDO::FETCH_ASSOC);

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
            <h1 class="m-0">Compra Nro <?php echo $nro_compra?></h1>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          
          <!-- COLUMNA IZQUIERDA (DATOS DEL PRODUCTO Y PROVEEDOR) -->
          <div class="col-md-9">
             <div class="card card-info">
                  <div class="card-header">
                    <h3 class="card-title">Datos de la Compra</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse" aria-label="Contraer tarjeta">
                        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                      </button>
                    </div>
                  </div>
                  
                  <div class="card-body">                  
                        

                        <!-- CAMPOS DEL PRODUCTO -->
                        <div class="row" style="font-size: 12px">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" id="idProductos" class="form-control" hidden>
                                    <label for="">Código:</label>
                                    <input type="text" class="form-control" value="<?php echo $codigo; ?>" id="codigo" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Nombre del Producto:</label>
                                    <input type="text" class="form-control" value="<?php echo $nombre_producto; ?>" id="nombre_producto" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Usuario Registrador:</label>
                                    <input type="text" class="form-control" value="<?php echo $nombre_usuario; ?>" id="usuario_producto" disabled>
                                </div>
                            </div>
                        </div>

                     <div class="row mt-3" style="font-size: 12px">
    <div class="col-md-2">
        <div class="form-group">
            <label for="">Stock Actual:</label>
            <input type="text" class="form-control" value="<?php echo formatearStock($stock, $unidad_medida); ?>" id="stock_actual" style="background-color: #fff819;" disabled>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="">Stock Mínimo:</label>
            <input type="text" class="form-control" value="<?php echo formatearStock($stock_minimo, $unidad_medida); ?>" id="stock_minimo" disabled>
        </div>
    </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Precio Compra:</label>
                                   <input type="text" value="<?php echo $precio_compra_producto; ?>" id="cantidad_compra" style="text-align: center" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Precio Venta:</label>
                                    <input type="text" class="form-control formato-precio" value="<?php echo $precio_venta;?>" id="precio_venta" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Fecha Ingreso:</label>
                                   <input type="text" class="form-control" value="<?php echo $fecha_ingreso;?>" id="fecha_ingreso" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Unidad de Medida:</label>
                                    <input type="text" class="form-control" value="<?php echo $unidad_medida;?>" id="unidad_medida" disabled>
                                </div>
                            </div>
                        </div>

                        <!-- PROVEEDOR -->
                        <hr>
                        <div style="display: flex; align-items: center;">
                           <h5 class="mb-0">Datos del Proveedor</h5>
                
                        </div>

                        <hr>

                      <div class="container-fluid" style="font-size: 12px">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" id="idProveedores" class="form-control" hidden>
                                        <label for="">Nombre del Proveedor</label>
                                        <input type="text"  value="<?php echo $nombre_proveedor;?>" id="nombre_proveedor" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Celular </label>
                                        <input type="text"  value="<?php echo $celular_proveedor;?>" id="celular" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Teléfono</label>
                                        <input type="text"  value="<?php echo $telefono_proveedor;?>" id="telefono" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row">                 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Nombre de la Empresa </label>
                                        <input type="text"  value="<?php echo $empresa;?>" id="empresa" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="email"nombre_proveedor  value="<?php echo $email_proveedor;?>" id="email" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Ruc</label>
                                        <input type="text"  value="<?php echo $ruc_proveedor;?>" id="rucProveedores" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>          

                            <div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Dirección</label>
            <textarea id="direccion" cols="30" rows="3" class="form-control" disabled><?php echo $direccion_proveedor; ?></textarea>
        </div>
    </div>
</div>
                      </div>
                  </div>
             </div>
          </div>

          <!-- COLUMNA DERECHA (DATOS DE LA COMPRA) -->
          <div class="col-md-3">
              <div class="card card-outline card-primary">
                  <div class="card-header">
                      <h3 class="card-title">Detalle de la Compra</h3>
                      <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse">
                              <i class="fas fa-minus"></i>
                          </button>
                      </div>    
                  </div> 
                  
                  <div class="card-body">
                      <div class="row">
                          <div class="col-md-12">   
                              <div class="form-group">
                                  
                                  <label for="">Número de la Compra</label>
                                  <input type="text" class="form-control" value="<?php echo $nro_compra;?>" style="text-align: center; font-weight: bold;" disabled>
                                  <input type="text" value="<?php echo $nro_compra;?>" id="nro_compra" hidden>
                              </div>
                              
                              <div class="form-group">
                                  <label for="">Fecha de la Compra</label>
                                  <input type="date" class="form-control" value="<?php echo $fecha_compra;?>"  id="fecha_compra" value="<?php echo date('Y-m-d'); ?>" disabled>
                              </div>

                              <div class="form-group">
                                  <label for="">Comprobante de la Compra</label>
                                  <input type="text" class="form-control" value="<?php echo $comprobante;?>" id="comprobante" disabled>
                              </div>

                              <div class="form-group">
                                  <label for="">Precio de la Compra</label>
                                <input type="text" value="<?php echo number_format($precio_compra, 0, ',', '.'); ?>" class="form-control formato-precio" id="precio_compra_controlador" disabled>
                              </div>

                             

                              <div class="form-group">
                                  <label for="">Cantidad de la Compra</label>
                                 <input type="text" value="<?php echo formatearStock($cantidad, $unidad_medida); ?>"id="cantidad_compra" style="text-align: center" class="form-control" disabled>

     
          
                              <div class="form-group">
                                  <label for="">Usuario</label>
                                  <input type="text" class="form-control" value="<?php echo $nombre_usuario ?? ''; ?>" disabled>
                              </div>
                          </div>
                      </div>
                        <hr>
                          <div class="col-md-12">
              </div>
              </div>
          </div>

        </div>
      </div>
    </div>
</div>

<?php include('../layout/parte2.php');?>
<?php include('../layout/mensajes.php');?>

