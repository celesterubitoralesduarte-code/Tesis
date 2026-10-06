<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');
include_once __DIR__ . '/../app/controllers/ventas/listado_de_ventas.php';
include_once __DIR__ . '/../app/controllers/productos/listado_de_productos.php';
include_once __DIR__ . '/../app/controllers/clientes/listado_de_clientes.php';

// Función para dar formato de 5 dígitos con ceros a la izquierda
function ceros(int $numero){
    return str_pad($numero, 5, "0", STR_PAD_LEFT);
}

// Esto se queda porque es para los productos
$sql_max_codigo = "SELECT MAX(CAST(SUBSTRING(codigo, 3) AS UNSIGNED)) AS max_codigo 
                    FROM productos 
                    WHERE codigo LIKE 'P-%'";
$query_max_codigo = $pdo->prepare($sql_max_codigo);
$query_max_codigo->execute();
$row_max_codigo = $query_max_codigo->fetch(PDO::FETCH_ASSOC);

$siguiente_numero = ($row_max_codigo['max_codigo'] ?? 0) + 1;
$nuevo_codigo = "P-" . ceros($siguiente_numero);


// --- AQUÍ USAMOS id_ventas PARA OBTENER EL CORRELATIVO REAL ---
$sql_max_venta = "SELECT MAX(id_ventas) AS max_nro FROM ventas"; 
$query_max_venta = $pdo->prepare($sql_max_venta);
$query_max_venta->execute();
$row_max_venta = $query_max_venta->fetch(PDO::FETCH_ASSOC);

$nro_venta_actual = ($row_max_venta['max_nro'] ?? 0) + 1;
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0">Ventas - Nueva Factura</h1>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        
  <div class="row">
        
       <!-- ================= COLUMNA IZQUIERDA: BUSCAR PRODUCTOS ================= -->
<div class="col-md-6">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title"><i class="fa fa-search"></i> 1. Buscar Productos</h3>
        </div>
        <div class="card-body">
            
            <!-- CONTENEDOR CON SCROLL VERTICAL -->
            <div style="max-height: 420px; overflow-y: auto; overflow-x: hidden;" class="border rounded p-1 mb-2">
                <table id="example1" class="table table-bordered table-striped table-sm mb-0" style="width:100%; cursor: pointer;">
                    <thead style="position: sticky; top: 0; background: white; z-index: 1;">
                        <tr>
                            <th><center>Código</center></th>
                            <th><center>Nombre</center></th>
                            <th><center>Stock</center></th>
                            <th><center>Precio Venta</center></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php  
                    if (isset($productos_datos) && is_array($productos_datos)) {
                        foreach ($productos_datos as $producto){ 
                            $idProductos = $producto['idProductos']; 
                            $stockProductos = $producto['stockProductos'];
                            $stockMinimo = $producto['stockMinimo'];
                            
                            $precioVenta = $producto['precioVenta'];
                            if ($precioVenta > 0 && $precioVenta < 1000) {
                                $precioVenta = $precioVenta * 1000;
                            }

                           $clase_alerta = "";
if (floatval($stockProductos) <= floatval($stockMinimo)) {
    $clase_alerta = "table-danger";
}
                    ?>
                        <tr class="fila-producto <?php echo $clase_alerta; ?>" 
                            data-id="<?php echo $producto['idProductos']; ?>"
                            data-codigo="<?php echo $producto['codigo'];?>"
                            data-nombre="<?php echo $producto['nomProductos'];?>"
                            data-stock="<?php echo $stockProductos;?>"
                            data-precioventa="<?php echo $precioVenta;?>"
                            data-precioventa-formateado="<?php echo number_format($precioVenta, 0, ',', '.');?>"
                            data-unidad="<?php echo $producto['unidadMedida'];?>">
                            <td><?php echo $producto['codigo'];?></td>
                            <td><?php echo $producto['nomProductos'];?></td>
                            <td><?php echo function_exists('formatearStock') ? formatearStock($stockProductos, $producto['unidadMedida']) : $stockProductos; ?></td>
                            <td><?php echo "Gs. " . number_format($precioVenta, 0, ',', '.'); ?></td>
                        </tr>
                    <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>

            <hr class="my-2">
            
            <!-- CAMPOS HORIZONTALES ABAJO -->
            <div class="bg-light p-3 border rounded">
                <input type="text" id="idProductos" hidden>
                
                <div class="row">
                    <!-- Producto Seleccionado -->
                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label class="small mb-1">Producto:</label>
                            <input type="text" id="producto" class="form-control form-control-sm" disabled placeholder="Seleccione de la tabla">
                        </div>
                    </div>
                    <!-- Cantidad / Peso -->
                    <div class="col-md-3">
                        <div class="form-group mb-2">
                            <label class="small mb-1">Cant/Peso:</label>
                            <input type="number" step="0.001" id="cantidad" class="form-control form-control-sm" value="">
                        </div>
                    </div>
                    <!-- Precio Unitario -->
                    <div class="col-md-3">
                        <div class="form-group mb-2">
                            <label class="small mb-1">P. Unit:</label>
                            <input type="text" id="precioVenta" class="form-control form-control-sm" disabled>
                        </div>
                    </div>
                    <!-- Botón Añadir -->
                    <div class="col-md-2 d-flex align-items-end">
                        <div class="form-group mb-2 w-100">
                            <button type="button" id="btn_registrar_carrito" class="btn btn-success btn-sm btn-block" title="Añadir al Carrito">
                                <i class="fa fa-cart-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

        <!-- ================= COLUMNA DERECHA: CLIENTE + CARRITO EN UN SOLO BLOQUE ================= -->
          <div class="col-md-6">
              
              <div class="card card-outline card-primary mb-3">
                  <div class="card-header py-2 bg-light">
                      <h3 class="card-title" style="font-size: 1.1rem; font-weight: bold;">
                          <i class="fa fa-cash-register"></i> Registrar Venta Nro: 
                          <input type="text" id="nro_venta" style="text-align: center; width: 45px; border:none; background:transparent; font-weight: bold;" value="<?php echo $nro_venta_actual; ?>" disabled>
                      </h3>
                  </div>
                  
                  <div class="card-body">
                      
                      <!-- 1. DATOS DEL CLIENTE INTEGRADOS -->
                      <div class="border rounded p-2 mb-3 bg-white">
                          <div class="d-flex justify-content-between align-items-center mb-2">
                              <span class="font-weight-bold text-secondary" style="font-size: 0.9rem;">
                                  <i class="fa fa-user-check"></i> Datos del cliente
                              </span>
                              <button type="button" class="btn btn-outline-primary btn-xs" data-toggle="modal" data-target="#modal-buscar_cliente" title="Buscar Cliente">
                                  <i class="fa fa-search"></i> Buscar / Cambiar Cliente
                              </button>
                          </div>
                          
                          <div class="row">
                              <div class="col-md-6">
                                  <input type="text" id="id_cliente" hidden>
                                  <div class="form-group mb-0">
                                      <label class="small text-muted mb-0">Cliente</label>
                                      <input type="text" id="nombre_cliente" class="form-control form-control-sm bg-light" value="Consumidor Final" disabled>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group mb-0">
                                      <label class="small text-muted mb-0">RUC / CI</label>
                                      <input type="text" id="ruc_ci_cliente" class="form-control form-control-sm bg-light" disabled>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <!-- 2. TABLA DEL CARRITO (PRODUCTOS SELECCIONADOS) -->
                      <div class="form-group mb-1">
                          <label class="small text-muted font-weight-bold">
                              <i class="fa fa-shopping-bag"></i> Productos Seleccionados
                          </label>
                      </div>
                      
                      <div class="table-responsive">
                          <table class="table table-bordered table-sm table-hover table-striped mb-0">
                              <thead>
                                  <tr>
                                      <th style="background-color: #e7e7e7; text-align: center">Nro</th>
                                      <th style="background-color: #e7e7e7; text-align: center">Nombre</th>
                                      <th style="background-color: #e7e7e7; text-align: center">Cant/Peso</th>
                                      <th style="background-color: #e7e7e7; text-align: center">P. Unit</th>
                                      <th style="background-color: #e7e7e7; text-align: center">SubTotal</th>
                                      <th style="background-color: #e7e7e7; text-align: center">Acción</th>
                                  </tr>
                              </thead>
                              <tbody id="tabla_carrito_body">
                                  <!-- AJAX cargará los productos aquí automáticamente -->
                              </tbody>
                          </table>
                      </div>
                      <br>
                     <div class="card-body py-2">
                        <!-- Monto a Cobrar horizontal -->
                        <div class="row align-items-center mb-2">
                            <div class="col-md-5">
                                <label class="font-weight-bold mb-0" style="font-size: 1.1em;">Monto a Cobrar:</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" id="monto_a_cancelar" class="form-control" style="text-align: center; background-color: #ffff00; font-weight: bold; font-size: 1.4em;" value="0" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label class="small">Total pagado</label>
                                    <input type="text" class="form-control form-control-sm" id="total_pagado" placeholder="0" autocomplete="off">
                                    <input type="hidden" id="monto_a_cancelar_num" value="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label class="small">Cambio / Vuelto</label>
                                    <input type="text" id="cambio" class="form-control form-control-sm text-center font-weight-bold text-success" readonly>
                                </div>
                                
                                <!-- Menú desplegable visible permanentemente -->
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <label class="small text-muted"></label>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-secondary btn-block dropdown-toggle font-weight-bold btn-sm" data-toggle="dropdown" aria-expanded="false" style="background-color: #6c757d; border-color: #6c757d;">
                                            <i class="fa fa-print"></i> Imprimir última venta
                                        </button>
                                        <div class="dropdown-menu w-100 text-center shadow">
                                            <a class="dropdown-item py-2 font-weight-bold" href="#" id="link_imprimir_ticket" target="_blank">
                                                <i class="fa fa-file-text-o"></i> Imprimir Ticket
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item py-2 font-weight-bold" href="#" id="link_imprimir_factura" target="_blank">
                                                <i class="fa fa-file-pdf-o"></i> Imprimir Factura
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                       <div class="d-flex justify-content-between align-items-center mt-3">
                            <button type="button" id="btn_cancelar_venta" class="btn btn-danger">
                                <i class="fa fa-times"></i> Cancelar
                            </button>     
                            <button type="button" id="btn_guardar_venta" class="btn btn-primary">
                                Realizar Venta
                            </button>
                        </div>
                    </div>
              </div>
          </div>
        </div> <!-- /.row -->
      </div> <!-- /.container-fluid -->
    </div> <!-- /.content -->
</div> <!-- /.content-wrapper -->

<!-- ================= MODAL BÚSQUEDA DE CLIENTE ================= -->
<div class="modal fade" id="modal-buscar_cliente">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title">Búsqueda del cliente</h4>
                <div class="card-tools">
                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-agregar_cliente">
                        <i class="fa fa-user-plus"></i> Agregar nuevo cliente
                    </button>
                    <button type="button" class="close text-white ml-2" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <div class="table-responsive">    
                    <table id="example2" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th><center>Nro</center></th>
                                <th><center>Seleccionar</center></th>
                                <th><center>Nombre</center></th>      
                                <th><center>RUC/CI</center></th>
                                <th><center>Celular</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  
                            $contador_c = 0;
                            if (isset($clientes_datos) && is_array($clientes_datos)) {
                                foreach ($clientes_datos as $cliente){ 
                            ?>
                                <tr>
                                    <td><center><?php echo ++$contador_c; ?></center></td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm btn-seleccionar_cliente" 
                                            data-id="<?php echo $cliente['id_cliente']; ?>"
                                            data-nombre_cliente="<?php echo $cliente['nombre_cliente'];?>"
                                            data-ruc_ci_cliente="<?php echo $cliente['ruc_ci_cliente'];?>"
                                            data-celular_cliente="<?php echo $cliente['celular_cliente'];?>"
                                            data-email_cliente="<?php echo $cliente['email_cliente'];?>">
                                            Seleccionar
                                        </button>
                                    </td>
                                    <td><?php echo $cliente['nombre_cliente'];?></td>
                                    <td><?php echo $cliente['ruc_ci_cliente'];?></td>
                                    <td><?php echo $cliente['celular_cliente'];?></td>
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

<!-- ================= MODAL REGISTRAR NUEVO CLIENTE ================= -->
<div class="modal fade" id="modal-agregar_cliente">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h4 class="modal-title">Nuevo cliente</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nombre del cliente</label>
                    <input type="text" id="nombre_cliente_modal" class="form-control" placeholder="Ingrese nombre completo" autocomplete="off">
                </div>
                <div class="form-group">
                    <label>RUC / CI del cliente</label>
                    <input type="text" id="ruc_cliente_modal" class="form-control" placeholder="Ingrese RUC o C.I." autocomplete="off">
                </div>
                <div class="form-group">
                    <label>Celular del cliente</label>
                    <input type="text" id="celular_cliente_modal" class="form-control" placeholder="Ingrese número de celular" autocomplete="off">
                </div>
                <div class="form-group">
                    <label>Correo del cliente</label>
                    <input type="email" id="correo_cliente_modal" class="form-control" placeholder="Ingrese correo electrónico" autocomplete="off">
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btn_create_cliente" class="btn btn-warning text-white">Guardar cliente</button>
            </div>
        </div>
    </div>
</div>
</div>

<?php include('../layout/parte2.php');?>
<?php include('../layout/mensajes.php');?>


<script>
    $(function () {
        $("#example1").DataTable({
            "pageLength": 10,
            "responsive": true,
            "autoWidth": false,
            "lengthChange": true,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Ventas",
                "infoEmpty": "Mostrando 0 a 0 de 0 Ventas",
                "infoFiltered": "(Filtrado de _MAX_ total Ventas)",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Ventas",
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
         
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });

    $(function () {
        $("#example2").DataTable({
            "pageLength": 10,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Usuarios",
                "infoEmpty": "Mostrando 0 a 0 de 0 Usuarios",
                "infoFiltered": "(Filtrado de _MAX_ total Usuarios)",
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
        }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
    });

    $(document).ready(function() {
        cargarTablaCarrito();
        // Por defecto al cargar, los enlaces de impresión apuntan a la venta actual o vacía
        var id_ventas = $('#nro_venta').val();
        $('#link_imprimir_ticket').attr('href', '../app/controllers/ventas/imprimir_ticket.php?id=' + id_ventas);
        $('#link_imprimir_factura').attr('href', 'imprimir_factura.php?id=' + id_ventas);
    });

    function cargarTablaCarrito() {
        var id_ventas = $('#nro_venta').val();
        $.ajax({
            url: '../app/controllers/ventas/cargar_carrito.php?id_ventas=' + id_ventas,
            type: 'GET',
            success: function(html) {
                $('#tabla_carrito_body').html(html);
            }
        });
    }

    $('#example1').on('click', 'tr.fila-producto', function () {
        $('#example1 tr').removeClass('table-info');
        $(this).addClass('table-info');

        $('#idProductos').val($(this).data('id'));
        $('#producto').val($(this).data('nombre'));
        $('#precioVenta').val("Gs. " + $(this).data('precioventa-formateado'));
        $('#cantidad').val('');
        $('#cantidad').focus();
    });

    $('#btn_registrar_carrito').click(function () {
        var id_ventas = $('#nro_venta').val();
        var idProductos = $('#idProductos').val();
        var cantidad = $('#cantidad').val();

        if (idProductos == "") {
            alert("Debe seleccionar un producto del lado izquierdo.");
        } else if (cantidad == "" || parseFloat(cantidad) <= 0) {
            alert("Debe ingresar una cantidad o peso válido.");
            $('#cantidad').focus();
        } else {
            $.ajax({
                url: '../app/controllers/ventas/registrar_carrito.php',
                type: 'POST',
                data: {
                    id_ventas: id_ventas,
                    idProductos: idProductos,
                    cantidad: cantidad
                },
                success: function(respuesta) {
                    if (respuesta.trim() == "success") {
                        cargarTablaCarrito();
                        $('#idProductos').val('');
                        $('#producto').val('');
                        $('#cantidad').val('');
                        $('#precioVenta').val('');
                        $('#example1 tr').removeClass('table-info');
                    } else {
                        alert("Error al registrar en el carrito: " + respuesta);
                    }
                }
            });
        }
    });

    function borrarCarrito(id_carrito) {
        $.ajax({
            url: '../app/controllers/ventas/borrar_carrito.php',
            type: 'POST',
            data: { id_carrito: id_carrito },
            success: function(respuesta) {
                if (respuesta.trim() == "success") {
                    cargarTablaCarrito();
                } else {
                    alert("Error al intentar eliminar el producto del carrito.");
                }
            }
        });
    }

    $('#example2').on('click', '.btn-seleccionar_cliente', function () {
        $('#id_cliente').val($(this).data('id'));
        $('#nombre_cliente').val($(this).data('nombre_cliente'));
        $('#ruc_ci_cliente').val($(this).data('ruc_ci_cliente'));
        $('#celular_cliente').val($(this).data('celular_cliente'));
        $('#email_cliente').val($(this).data('email_cliente'));
        $('#modal-buscar_cliente').modal('hide');
    });

    function calcularCambio() {  
       var monto_cancelar = Math.round(parseFloat($('#monto_a_cancelar_num').val()) || 0);
        var total_pagado_raw = $('#total_pagado').val().replace(/\./g, '');
        var total_pagado = parseFloat(total_pagado_raw) || 0;

        if (total_pagado >= monto_cancelar && monto_cancelar > 0) {
            var cambio = total_pagado - monto_cancelar;
            $('#cambio').val(new Intl.NumberFormat('de-DE').format(cambio));
        } else {
            $('#cambio').val('');
        }
    }

    $('#total_pagado').on('keyup change input', function() {
        var valor = $(this).val().replace(/\D/g, "");
        if (valor !== "") {
            $(this).val(new Intl.NumberFormat('de-DE').format(valor));
        }
        calcularCambio();
    });

    $('#btn_guardar_venta').click(function() {
        var id_ventas = $('#nro_venta').val();
        var id_cliente = $('#id_cliente').val(); 
       var monto_cancelar = Math.round(parseFloat($('#monto_a_cancelar_num').val()) || 0);
        var total_pagado_raw = $('#total_pagado').val().replace(/\./g, '');
        var total_pagado = parseFloat(total_pagado_raw) || 0;

        if (monto_cancelar <= 0) {
            alert("No se puede guardar la venta: Debe seleccionar al menos un producto en el carrito.");
            return;
        }

        if ($('#total_pagado').val().trim() === "" || total_pagado <= 0) {
            alert("No se puede guardar la venta: Debe ingresar el monto en 'Total pagado'.");
            return;
        }

        if (total_pagado < monto_cancelar) {
            alert("No se puede guardar la venta: El dinero ingresado es menor al monto a cobrar.");
            return;
        }

        $.ajax({
            url: '../app/controllers/ventas/registrar_venta.php',
            type: 'POST',
            data: {
                id_ventas: id_ventas,
                id_cliente: id_cliente,
                total_pagado: total_pagado
            },
           success: function(respuesta) {
    if (respuesta.trim().startsWith("success")) {
        var partes = respuesta.trim().split("-");
        var idVentaGenerada = partes.length > 1 ? partes[1] : id_ventas;

        // 1. Asignamos los enlaces para el botón de "Imprimir última venta"
        $('#link_imprimir_ticket').attr('href', '../app/controllers/ventas/imprimir_ticket.php?id=' + idVentaGenerada);
        $('#link_imprimir_factura').attr('href', 'imprimir_factura.php?id=' + idVentaGenerada);
        $('#link_imprimir_ticket, #link_imprimir_factura').attr('target', '_blank');

        alert("¡Venta registrada con éxito!");

        // 2. LIMPIAR Y VACIAR LA VENTA ACTUAL EN PANTALLA:
        
        // Recargar la tabla del carrito (ahora aparecerá vacía porque el backend ya la borró)
        cargarTablaCarrito();

        // Limpiar campos de montos y totales
        $('#total_pagado').val('');
        $('#cambio').val('');
        $('#monto_a_cancelar').val('0');
        $('#monto_a_cancelar_num').val('0');

        // Restaurar el cliente a "Consumidor Final" (o limpiar el ID según manejes tu formulario)
        $('#id_cliente').val('1'); // O pon tu ID por defecto para consumidor ocasional
        $('#nombre_cliente').val('Consumidor Final');
        $('#ruc_ci_cliente').val('');

        // 3. OPCIONAL (Recomendado): Recargar la página limpia pero después de unos segundos, 
        // o generar un nuevo ID temporal para que el siguiente ticket no repita el número. 
        // La forma más limpia si quieres mantener el menú desplegable activo sin congelar la sesión 
        // es hacer un pequeño retraso o simplemente recargar la página pero pasando el ID generado en la URL:
        // window.location.href = 'create.php?id_venta_nueva=true'; // (O recargar normal si prefieres)

    } else if (respuesta.trim() == "carrito_vacio") {
        alert("El carrito no tiene productos.");
    } else if (respuesta.trim() == "stock_insuficiente") {
        alert("No hay suficiente stock para uno o más productos del carrito.");
    } else {
        alert("Ocurrió un error al registrar la venta: " + respuesta);
    }
}
        });
    });

 $('#btn_create_cliente').click(function () {
        var nombre_cliente  = $('#nombre_cliente_modal').val().trim();
        var ruc_ci_cliente  = $('#ruc_cliente_modal').val().trim();
        var celular_cliente = $('#celular_cliente_modal').val().trim();
        var email_cliente   = $('#correo_cliente_modal').val().trim();

        if (nombre_cliente === "") {
            alert("Por favor ingrese el nombre del cliente.");
            $('#nombre_cliente_modal').focus();
            return;
        }

        if (ruc_ci_cliente === "") {
            alert("Por favor ingrese el RUC o C.I. del cliente.");
            $('#ruc_cliente_modal').focus();
            return;
        }

        $.ajax({
            url: '../app/controllers/clientes/guardar_cliente.php',
            type: 'POST',
            data: {
                nombre_cliente: nombre_cliente,
                ruc_ci_cliente: ruc_ci_cliente,
                celular_cliente: celular_cliente,
                email_cliente: email_cliente
            },
            dataType: 'json',
            success: function (response) {
                if (response.status == "success") {
                    alert("Cliente guardado con éxito.");
                    $('#modal-agregar_cliente').modal('hide');
                    
                    // 1. Asignar los valores a los inputs principales de la venta
                    $('#id_cliente').val(response.id_cliente);
                    $('#nombre_cliente').val(response.nombre_cliente);
                    $('#ruc_ci_cliente').val(response.ruc_ci_cliente);

                    // 2. Limpiar los campos del modal de agregar cliente
                    $('#nombre_cliente_modal').val('');
                    $('#ruc_cliente_modal').val('');
                    $('#celular_cliente_modal').val('');
                    $('#correo_cliente_modal').val('');

                    // 3. RECUPERAR / ACTUALIZAR LA TABLA DEL MODAL DE BÚSQUEDA AL INSTANTE
                    // Destruimos la instancia actual de DataTable para evitar errores de memoria o columnas
                    if ($.fn.DataTable.isDataTable('#example2')) {
                        $('#example2').DataTable().destroy();
                    }

                    // Hacemos una petición para obtener de nuevo la lista actualizada de clientes y reinsertarla en el HTML
                    $.ajax({
                        url: window.location.href, // O la ruta de tu vista actual de ventas
                        type: 'GET',
                        success: function(htmlRespuesta) {
                            // Extraemos únicamente la tabla o la sección actualizada del DOM devuelto
                            var nuevaTablaBody = $(htmlRespuesta).find('#example2 tbody').html();
                            if (nuevaTablaBody) {
                                $('#example2 tbody').html(nuevaTablaBody);
                            }
                            
                            // Volvemos a inicializar DataTables en `#example2` con su configuración normal
                            $("#example2").DataTable({
                                "pageLength": 10,
                                "language": {
                                    "emptyTable": "No hay información",
                                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Usuarios",
                                    "infoEmpty": "Mostrando 0 a 0 de 0 Usuarios",
                                    "infoFiltered": "(Filtrado de _MAX_ total Usuarios)",
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
                                "autoWidth": false
                            });
                        }
                    });

                } else {
                    alert("Error al guardar el cliente: " + (response.message || ""));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Ocurrió un error en la petición AJAX: " + textStatus);
            }
        });
    });
    $('#btn_cancelar_venta').click(function() {
        var id_ventas = $('#nro_venta').val();
        
        if (confirm("¿Estás seguro de que deseas cancelar y vaciar el carrito?")) {
            $.ajax({
                url: '../app/controllers/ventas/vaciar_carrito.php',
                type: 'POST',
                data: { id_ventas: id_ventas },
                success: function(respuesta) {
                    if (respuesta.trim() == "success") {
                        cargarTablaCarrito();
                        
                        $('#id_cliente').val('');
                        $('#nombre_cliente').val('Consumidor Final');
                        $('#ruc_ci_cliente').val('');
                        $('#total_pagado').val('');
                        $('#cambio').val('');
                        $('#monto_a_cancelar').val('0');
                        $('#monto_a_cancelar_num').val('0');
                    } else {
                        alert("No se pudo vaciar el carrito.");
                    }
                }
            });
        }
    });
</script>