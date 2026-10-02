<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');
include_once __DIR__ . '/../app/controllers/productos/listado_de_productos.php';
include_once __DIR__ . '/../app/controllers/proveedores/listado_de_proveedores.php';

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
            <h1 class="m-0">Registro de una Nueva Compra</h1>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          
          <!-- COLUMNA IZQUIERDA (DATOS DEL PRODUCTO) -->
          <div class="col-md-9">
             <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Ingrese los Datos con Cuidado</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse" aria-label="Contraer tarjeta">
                        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                      </button>
                    </div>
                  </div>
                  
                  <div class="card-body">                  
                        <div style="display: flex; align-items: center;">
                           <h5 class="mb-0">Datos del Producto</h5>
                           <div style="width: 20px;"></div>
                           <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-buscar_producto">
                              <i class="fa fa-search"></i> Buscar Producto
                           </button>  
                          
                          <!-- Modal para visualizar datos de los productos -->
                          <div class="modal fade" id="modal-buscar_producto">
                              <div class="modal-dialog modal-xl">
                                  <div class="modal-content">
                                      <div class="modal-header" style="background-color: #1d36b6; color: white">
                                          <h4 class="modal-title">Busqueda del Producto</h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                      </div>
                                      <div class="modal-body">
                                          <div class="card-body" style="box-sizing: border-box; display: block;">                    
                                              <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th><center>Nro</center></th>
                                                    <th><center>Seleccionar</center></th>
                                                    <th><center>Código</center></th>                        
                                                    <th><center>Nombre</center></th>
                                                    <th><center>Stock</center></th>
                                                    <th><center>Stock Minimo</center></th>
                                                    <th><center>Precio Compra</center></th>
                                                    <th><center>Precio Venta</center></th>
                                                    <th><center>Fecha Ingreso</center></th>
                                                    <th><center>Usuario</center></th>
                                                    <th><center>Unidad de Medida</center></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                  <?php  
                                                  $contador = 0;
                                                  if (isset($productos_datos) && is_array($productos_datos)) {
                                                      foreach ($productos_datos as $producto){ 
                                                          $idProductos = $producto['idProductos']; 
                                                          $precioCompra = $producto['precioCompra'];
                                                          if ($precioCompra > 0 && $precioCompra < 1000) {
                                                              $precioCompra = $precioCompra * 1000;
                                                          }

                                                          $precioVenta = $producto['precioVenta'];
                                                          if ($precioVenta > 0 && $precioVenta < 1000) {
                                                              $precioVenta = $precioVenta * 1000;
                                                          }
                                                  ?>
                                                    <tr>
                                                      <td><center><?php echo $contador = $contador + 1; ?></center></td>
                                                      <td>
                                                        <button type="button" class="btn btn-info btn-seleccionar" 
                                                                data-codigo="<?php echo $producto['codigo'];?>"
                                                                data-nombre="<?php echo $producto['nomProductos'];?>"
                                                                data-usuario="<?php echo $producto['usuarioTrabajador'];?>"
                                                                data-stock="<?php echo $producto['stockProductos'];?>"
                                                                data-stockmin="<?php echo $producto['stockMinimo'];?>"
                                                                data-preciocompra="<?php echo $precioCompra;?>"
                                                                data-precioventa="<?php echo $precioVenta;?>"
                                                                data-fecha="<?php echo date('Y-m-d', strtotime($producto['fecha_ingreso']));?>"
                                                                data-unidad="<?php echo $producto['unidadMedida'];?>">
                                                          Seleccionar
                                                        </button>
                                                      </td>
                                                      <td><?php echo $producto['codigo'];?></td>
                                                      <td><?php echo $producto['nomProductos'];?></td>
                                                      <td>
                                                        <?php 
                                                           if ($producto['unidadMedida'] == 'Unidades (Und)') {
                                                               echo number_format((float)$producto['stockProductos'], 0, ',', '.');
                                                            } else {
                                                               echo number_format((float)$producto['stockProductos'], (floor($producto['stockProductos']) == $producto['stockProductos'] ? 0 : 3), ',', '.');
                                                            }
                                                         ?>
                                                      </td>
                                                      <td>
                                                          <?php 
                                                             if ($producto['unidadMedida'] == 'Unidades (Und)') {
                                                                echo number_format((float)$producto['stockMinimo'], 0, ',', '.');
                                                               } else {
                                                                echo number_format((float)$producto['stockMinimo'], (floor($producto['stockMinimo']) == $producto['stockMinimo'] ? 0 : 3), ',', '.');
                                                              }
                                                           ?>
                                                      </td>
                                                      <td><?php echo "Gs. " . number_format($precioCompra, 0, ',', '.'); ?></td>
                                                      <td><?php echo "Gs. " . number_format($precioVenta, 0, ',', '.'); ?></td>
                                                      <td><?php echo date('Y-m-d', strtotime($producto['fecha_ingreso'])); ?></td>
                                                      <td><?php echo $producto['usuarioTrabajador'];?></td>
                                                      <td><?php echo $producto['unidadMedida'];?></td>
                                                    </tr>
                                                  <?php
                                                      }
                                                  }
                                                  ?>
                                                </tbody>
                                              </table>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                        </div>

                        <hr>

                        <!-- CAMPOS DEL PRODUCTO -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Código:</label>
                                    <input type="text" class="form-control" id="codigo" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Nombre del Producto:</label>
                                    <input type="text" class="form-control" id="nombre_producto" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Usuario Registrador:</label>
                                    <input type="text" class="form-control" id="usuario_producto" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Stock Actual:</label>
                                    <input type="text" class="form-control" id="stock_actual" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Stock Mínimo:</label>
                                    <input type="text" class="form-control" id="stock_minimo" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Precio Compra:</label>
                                    <input type="text" class="form-control" id="precio_compra" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Precio Venta:</label>
                                    <input type="text" class="form-control" id="precio_venta" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Fecha Ingreso:</label>
                                    <input type="date" name="fecha_ingreso" class="form-control" id="fecha_ingreso" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Unidad de Medida:</label>
                                    <input type="text" class="form-control" id="unidad_medida" disabled>
                                </div>
                            </div>
                        </div>
                        <!--PROVEEDOR-->
                        <hr>
                        <div style="display: flex; align-items: center;">
                           <h5 class="mb-0">Datos del Proveedor</h5>
                           <div style="width: 20px;"></div>
                           <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-buscar_proveedor">
                              <i class="fa fa-search"></i> Buscar Proveedor
                           </button>  
                          
                          <!-- Modal para visualizar datos de los productos -->
                          <div class="modal fade" id="modal-buscar_proveedor">
                              <div class="modal-dialog modal-xl">
                                  <div class="modal-content">
                                      <div class="modal-header" style="background-color: #1d36b6; color: white">
                                          <h4 class="modal-title">Busqueda del Proveedor</h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                      </div>
                                      <div class="modal-body">
                                          <div class="card-body" style="box-sizing: border-box; display: block;">                    
                                             <table id="example2" class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Nro</th>
                                        <th>Seleccionar</th>
                                        <th>Nombre del Proveedor</th>
                                        <th>Celular</th>
                                        <th>Teléfono</th>
                                        <th>Empresa</th>
                                        <th>Email</th>
                                        <th>Ruc</th>
                                        <th>Dirección</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $contador = 0;
                                    foreach ($proveedores_datos as $proveedores_dato) {
                                        $idProveedores = $proveedores_dato['idProveedores'];
                                        $nombre_proveedor = $proveedores_dato['nombre_proveedor'];
                                    ?>
                                        <tr>
                                            <td><center><?php echo $contador = $contador + 1; ?></center></td>
                                            <td>
                                              <button class="btn btn-info" id="btn_seleccionar_proveedores<?php echo $idProveedores;?>">
                                                Seleccionar
                                              </button>
                                            </td>
                                            <td><?php echo $nombre_proveedor; ?></td>
                                            <td>
                                                <a href="http://wa.me/595<?php echo $proveedores_dato['celular']; ?>" target="_blank" class="btn btn-success">
                                                    <i class="fa fa-phone"></i>
                                                    <?php echo $proveedores_dato['celular']; ?>
                                                </a>
                                            </td>
                                            <td><?php echo $proveedores_dato['telefono']; ?></td>
                                            <td><?php echo $proveedores_dato['empresa']; ?></td>
                                            <td><?php echo $proveedores_dato['email']; ?></td>
                                            <td><?php echo $proveedores_dato['rucProveedores']; ?></td>
                                            <td><?php echo $proveedores_dato['direccion']; ?></td>
                                            <td>
   

                                               

                                                
                                                            
                                                           
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                                          </div>
                                      </div>
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
                    <h3 class="card-title">Datos de la Compra</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Número de la Compra</label>
                        <input type="text" class="form-control" style="text-align: center; font-weight: bold;">
                    </div>
                    <div class="form-group">
                        <label for="">Fecha de la Compra</label>
                        <input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    
                </div>
             </div>
          </div>

        </div>
      </div>
    </div>
</div>

<?php include('../layout/parte2.php');?>
<?php include('../layout/mensajes.php');?>

<script>
    $(function () {
        // 1. Inicializar Tabla de Productos
        var table1 = $("#example1").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Productos",
                "infoEmpty": "Mostrando 0 a 0 de 0 Productos",
                "infoFiltered": "(Filtrado de _MAX_ total Productos)",
                "thousands": ".",
                "lengthMenu": "Mostrar _MENU_ Productos",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscador:",
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
            "searching": true, // Asegura que el buscador esté habilitado
            "paging": true      // Asegura que la paginación esté habilitada
        });

        // 2. Inicializar Tabla de Proveedores (#example2)
        var table2 = $("#example2").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Proveedores",
                "infoEmpty": "Mostrando 0 a 0 de 0 Proveedores",
                "infoFiltered": "(Filtrado de _MAX_ total Proveedores)",
                "thousands": ".",
                "lengthMenu": "Mostrar _MENU_ Proveedores",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscador:",
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
            "searching": true,
            "paging": true
        });

        // Evento de selección para Productos
        $('#example1').on('click', '.btn-seleccionar', function () {
            var codigo = $(this).data('codigo');
            var nombre = $(this).data('nombre');
            var usuario = $(this).data('usuario');
            var stock = $(this).data('stock');
            var stockmin = $(this).data('stockmin');
            var preciocompra = $(this).data('preciocompra');
            var precioventa = $(this).data('precioventa');
            var fecha = $(this).data('fecha');
            var unidad = $(this).data('unidad');

            $('#codigo').val(codigo);
            $('#nombre_producto').val(nombre);
            $('#usuario_producto').val(usuario);
            $('#stock_actual').val(stock);
            $('#stock_minimo').val(stockmin);
            $('#precio_compra').val(Number(preciocompra).toLocaleString('es-ES', { minimumFractionDigits: 0, maximumFractionDigits: 0 }));
            $('#precio_venta').val(Number(precioventa).toLocaleString('es-ES', { minimumFractionDigits: 0, maximumFractionDigits: 0 }));
            $('#fecha_ingreso').val(fecha);
            $('#unidad_medida').val(unidad);

            $('#modal-buscar_producto').modal('hide');
        });

        // Forzar ajuste de columnas y buscador al desplegar modales
        $('#modal-buscar_producto').on('shown.bs.modal', function () {
            table1.columns.adjust().responsive.recalc();
        });

        $('#modal-buscar_proveedor').on('shown.bs.modal', function () {
            table2.columns.adjust().responsive.recalc();
        });
    });
</script>