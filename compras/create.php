<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');
include_once __DIR__ . '/../app/controllers/productos/listado_de_productos.php';
include_once __DIR__ . '/../app/controllers/proveedores/listado_de_proveedores.php';
include_once __DIR__ . '/../app/controllers/compras/listado_de_compras.php';

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
          
          <!-- COLUMNA IZQUIERDA (DATOS DEL PRODUCTO Y PROVEEDOR) -->
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
                                          <h4 class="modal-title">Búsqueda del Producto</h4>
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
                                                    <th><center>Stock Mínimo</center></th>
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
        data-id="<?php echo $producto['idProductos']; ?>"
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
                                                            ($producto['unidadMedida'] == 'Unidades (Und)');
                                                          echo number_format((float)$producto['stockProductos'], 0, ',', '');
                                                            
                                                            
                                                         ?>
                                                      </td>
                                                      <td>
                                                          <?php 
                                                            ($producto['unidadMedida'] == 'Unidades (Und)');
                                                          echo number_format((float)$producto['stockMinimo'], 0, ',', '');
                                                            
                                                            
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
                        <div class="row" style="font-size: 12px">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" id="idProductos" class="form-control" hidden>
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

                        <div class="row mt-3" style="font-size: 12px">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Stock Actual:</label>
                                    <input type="text" class="form-control" id="stock_actual" style="background-color: #fff819;" disabled>
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

                        <!-- PROVEEDOR -->
                        <hr>
                        <div style="display: flex; align-items: center;">
                           <h5 class="mb-0">Datos del Proveedor</h5>
                           <div style="width: 20px;"></div>
                           <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-buscar_proveedor">
                              <i class="fa fa-search"></i> Buscar Proveedor
                           </button>  
                          
                          <!-- Modal Proveedores -->
                          <div class="modal fade" id="modal-buscar_proveedor">
                              <div class="modal-dialog modal-xl">
                                  <div class="modal-content">
                                      <div class="modal-header" style="background-color: #1d36b6; color: white">
                                          <h4 class="modal-title">Búsqueda del Proveedor</h4>
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
                                                           <button type="button" class="btn btn-info btn_seleccionar_proveedores"
        data-id="<?php echo $proveedores_dato['idProveedores']; ?>"
        data-nombre="<?php echo $proveedores_dato['nombre_proveedor']; ?>"
        data-celular="<?php echo $proveedores_dato['celular']; ?>"
        data-telefono="<?php echo $proveedores_dato['telefono']; ?>"
        data-empresa="<?php echo $proveedores_dato['empresa']; ?>"
        data-email="<?php echo $proveedores_dato['email']; ?>"
        data-ruc="<?php echo $proveedores_dato['rucProveedores']; ?>"
        data-direccion="<?php echo $proveedores_dato['direccion']; ?>">
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

                        <hr>

                      <div class="container-fluid" style="font-size: 12px">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" id="idProveedores" class="form-control" hidden>
                                        <label for="">Nombre del Proveedor</label>
                                        <input type="text" id="nombre_proveedor" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Celular </label>
                                        <input type="text" id="celular" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Teléfono</label>
                                        <input type="text" id="telefono" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row">                 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Nombre de la Empresa </label>
                                        <input type="text" id="empresa" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="email" id="email" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Ruc</label>
                                        <input type="text" id="rucProveedores" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>          

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Dirección</label>
                                        <textarea id="direccion" cols="30" rows="3" class="form-control" disabled></textarea>
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
                                  <?php
                                  $contador_de_compras = 1;
                                  foreach ($compras_datos as $compras_dato) {
                                      $contador_de_compras = $contador_de_compras + 1;
                                  }
                                  ?>
                                  <label for="">Número de la Compra</label>
                                  <input type="text" class="form-control" value="<?php echo $contador_de_compras;?>" style="text-align: center; font-weight: bold;" disabled>
                                  <input type="text" value="<?php echo $contador_de_compras;?>" id="nro_compra" hidden>
                              </div>
                              
                              <div class="form-group">
                                  <label for="">Fecha de la Compra</label>
                                  <input type="date" class="form-control" id="fecha_compra" value="<?php echo date('Y-m-d'); ?>">
                              </div>

                              <div class="form-group">
                                  <label for="">Comprobante de la Compra</label>
                                  <input type="text" class="form-control" id="comprobante">
                              </div>

                              <div class="form-group">
                                  <label for="">Precio de la Compra</label>
                                  <input type="text" class="form-control" id="precio_compra">
                              </div>

                              <div class="row">
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label for="">Stock actual</label>
                                          <input type="text" style="background-color: #fff819; text-align: center;" id="stock_actual_2" class="form-control" disabled>
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label for="">Stock Total</label>
                                          <input type="text" style="text-align: center;" id="stock_total" class="form-control" disabled>
                                      </div>
                                  </div>
                              </div>

                              <div class="form-group">
                                  <label for="">Cantidad de la Compra</label>
                                  <input type="number" step="any" id="cantidad_compra" style="text-align: center" class="form-control">
                              </div>

                              <div class="form-group">
                                  <label for="">Usuario</label>
                                  <input type="text" class="form-control" value="<?php echo $usuario_sesion ?? ''; ?>" disabled>
                              </div>
                          </div>
                      </div>
                        <hr>
                          <div class="col-md-12">
    <div class="form-group">
        <button class="btn btn-primary btn-block" id="btn_guardar_compra">Guardar compra</button>
    </div>
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
            "searching": true,
            "paging": true
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
    var idProductos = $(this).data('id'); // Obtiene el ID dinámicamente del botón seleccionado
    var codigo = $(this).data('codigo');
    var nombre = $(this).data('nombre');
    var usuario = $(this).data('usuario');
    var stock = parseFloat($(this).data('stock')) || 0;
    var stockmin = parseFloat($(this).data('stockmin')) || 0;
    var preciocompra = $(this).data('preciocompra');
    var precioventa = $(this).data('precioventa');
    var fecha = $(this).data('fecha');
    var unidad = $(this).data('unidad');

    // Asignar el ID al cuadro de texto (input)
    $('#idProductos').val(idProductos); 
    // Si tu input tiene id="idProductos", usa: $('#idProductos').val(id_producto);

    $('#codigo').val(codigo);
    $('#nombre_producto').val(nombre);
    $('#usuario_producto').val(usuario);

    // Asignación con formato limpio
    $('#stock_actual').val(stock);
    $('#stock_actual_2').val(stock);
    $('#stock_minimo').val(stockmin);

    $('#precio_compra').val(Number(preciocompra).toLocaleString('es-ES', { minimumFractionDigits: 0, maximumFractionDigits: 0 }));
    $('#precio_venta').val(Number(precioventa).toLocaleString('es-ES', { minimumFractionDigits: 0, maximumFractionDigits: 0 }));
    $('#fecha_ingreso').val(fecha);
    $('#unidad_medida').val(unidad);

    // Disparar cálculo por si ya había algo tipeado
    calcularStockTotal();

    $('#modal-buscar_producto').modal('hide');
});

        // Seleccionar Proveedor
        $('#example2').on('click', '.btn_seleccionar_proveedores', function () {
            
            var idProveedores    = $(this).data('id');    
            var nombre_proveedor = $(this).data('nombre');
            var celular          = $(this).data('celular');
            var telefono         = $(this).data('telefono');
            var empresa          = $(this).data('empresa');
            var email            = $(this).data('email');
            var rucProveedores   = $(this).data('ruc');
            var direccion        = $(this).data('direccion');

            $('#idProveedores').val(idProveedores);
            $('#nombre_proveedor').val(nombre_proveedor);
            $('#celular').val(celular);
            $('#telefono').val(telefono);
            $('#empresa').val(empresa);
            $('#email').val(email);
            $('#rucProveedores').val(rucProveedores);
            $('#direccion').val(direccion);

            $('#modal-buscar_proveedor').modal('hide');
        });

        // Forzar ajuste de columnas en Modales
        $('#modal-buscar_producto').on('shown.bs.modal', function () {
            table1.columns.adjust().responsive.recalc();
        });

        $('#modal-buscar_proveedor').on('shown.bs.modal', function () {
            table2.columns.adjust().responsive.recalc();
        });

        // Evento para el cálculo dinámico al escribir la cantidad
        $('#cantidad_compra').on('keyup change input', function () {
            calcularStockTotal();
        });

        function calcularStockTotal() {
    var stock_actual_val = parseFloat($('#stock_actual_2').val()) || 0;
    var stock_compra_val = parseFloat($('#cantidad_compra').val()) || 0;

    var total = stock_actual_val + stock_compra_val;

    var unidad = $('#unidad_medida').val();
    if (unidad === 'Unidades (Und)') {
        $('#stock_total').val(total);
    } else {
        // Redondea a 3 decimales para kilos/gramos
        $('#stock_total').val(total);
    }
}
     // 6. Evento de Guardar Compra (AJAX)
        $('#btn_guardar_compra').click(function () {
            var id_producto = $('#idProductos').val();
            var idProveedores = $('#idProveedores').val();
            var nro_compra = $('#nro_compra').val();
            var fecha_compra = $('#fecha_compra').val();
            var comprobante = $('#comprobante').val();
            var idTrabajadores = "<?php echo isset($idTrabajadores) ? $idTrabajadores : ''; ?>";
alert(idTrabajadores);
            var precio_compra = $('#precio_compra').val();
            var cantidad_compra = $('#cantidad_compra').val();
            var stock_total = $('#stock_total').val();

            if (id_producto == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Atención',
                    text: 'Debe seleccionar un producto'
                });
            } else if (cantidad_compra == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Atención',
                    text: 'Debe ingresar la cantidad de la compra'
                });
            } else {
                var url = "../app/controllers/compras/create.php";
                $.get(url, {
                    id_producto: id_producto,
                    idProveedores: idProveedores,
                    nro_compra: nro_compra,
                    fecha_compra: fecha_compra,
                    comprobante: comprobante,
                    precio_compra: precio_compra,
                    cantidad_compra: cantidad_compra,
                    stock_total: stock_total
                }, function (datos) {
                    $('#respuesta_create').html(datos);
                });
            }
        });

    });
    
</script> 
