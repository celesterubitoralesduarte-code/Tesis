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

// Extraemos el número de código más alto registrado actualmente
$sql_max_codigo = "SELECT MAX(CAST(SUBSTRING(codigo, 3) AS UNSIGNED)) AS max_codigo 
                   FROM productos 
                   WHERE codigo LIKE 'P-'";
$query_max_codigo = $pdo->prepare($sql_max_codigo);
$query_max_codigo->execute();
$row_max_codigo = $query_max_codigo->fetch(PDO::FETCH_ASSOC);

$siguiente_numero = ($row_max_codigo['max_codigo'] ?? 0) + 1;
$nuevo_codigo = "P-" . ceros($siguiente_numero);

$contador_de_ventas = count($ventas_datos ?? []);
$nro_venta_actual = $contador_de_ventas + 1;
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0">Ventas</h1>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        
        <!-- FILA SUPERIOR: CARRITO (ANCHO COMPLETO - col-md-12) -->
        <div class="row">
          <div class="col-md-12">
              <div class="card card-outline card-primary">
                  <div class="card-header">
                     <h3 class="card-title"><i class="fa fa-shopping-bag"></i> Venta Nro
                         <input type="text" id="nro_venta" style="text-align: center" value="<?php echo $nro_venta_actual; ?>" disabled>
                     </h3>
                      <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse">
                              <i class="fas fa-minus"></i>
                          </button>
                      </div>    
                  </div> 
                  
                  <div class="card-body">
                      <b>Carrito </b>
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-buscar_producto">
                          <i class="fa fa-search"></i> Buscar Producto
                      </button>  
                           
                      <!-- Modal Búsqueda del Producto -->
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
                                                  <td><center><?php echo ++$contador; ?></center></td>
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
                                                    data-precioventa-formateado="<?php echo number_format($precioVenta, 0, ',', '.');?>"
                                                    data-fecha="<?php echo date('d/m/Y', strtotime($producto['fecha_ingreso']));?>"
                                                    data-unidad="<?php echo $producto['unidadMedida'];?>">
                                                    Seleccionar
                                                    </button>
                                                  </td>
                                                  <td><?php echo $producto['codigo'];?></td>
                                                  <td><?php echo $producto['nomProductos'];?></td>
                                                  <td><?php echo formatearStock($producto['stockProductos'], $producto['unidadMedida']); ?></td>
                                                  <td><?php echo formatearStock($producto['stockMinimo'], $producto['unidadMedida']); ?></td>
                                                  <td><?php echo "Gs. " . number_format($precioCompra, 0, ',', '.'); ?></td>
                                                  <td><?php echo "Gs. " . number_format($precioVenta, 0, ',', '.'); ?></td>
                                                  <td><?php echo date('d/m/Y', strtotime($producto['fecha_ingreso']));?></td>
                                                  <td><?php echo $producto['usuarioTrabajador'];?></td>
                                                  <td><?php echo $producto['unidadMedida'];?></td>
                                                </tr>
                                              <?php
                                                  }
                                              }
                                              ?>
                                            </tbody>
                                          </table>
                                          <div class="row">
                                              <div class="col-md-3">
                                                  <div class="form-group">
                                                      <input type="text" id="idProductos" hidden>
                                                      <label for="">Producto</label>
                                                      <input type="text" id="producto" class="form-control" disabled>
                                                  </div>
                                              </div>
                                              <div class="col-md-3">
                                                  <div class="form-group">
                                                      <label for="">Cantidad / Peso (Kg)</label>
                                                      <input type="number" step="0.001" id="cantidad" class="form-control">
                                                  </div>
                                              </div>
                                              <div class="col-md-3">
                                                  <div class="form-group">
                                                      <label for="">Precio Unitario</label>
                                                      <input type="text" id="precioVenta" class="form-control" disabled>
                                                  </div>
                                              </div>
                                              <div class="col-md-3">
                                                  <div class="form-group">
                                                      <label for="">&nbsp;</label>
                                                      <button type="button" id="btn_registrar_carrito" class="btn btn-primary btn-block">Registrar</button>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      
                      <br><br>
                      <!-- TABLA DEL CARRITO -->
                      <div class="table-responsive">
                          <table class="table table-bordered table-sm table-hover table-striped">
                              <thead>
                                  <tr>
                                      <th style="background-color: #e7e7e7;text-align: center">Nro</th>
                                      <th style="background-color: #e7e7e7;text-align: center">Nombre</th>
                                      <th style="background-color: #e7e7e7;text-align: center">Cantidad/Peso</th>
                                      <th style="background-color: #e7e7e7;text-align: center">Precio Unitario</th>
                                      <th style="background-color: #e7e7e7;text-align: center">Precio SubTotal</th>
                                      <th style="background-color: #e7e7e7;text-align: center">Acción</th>
                                  </tr>
                              </thead>
                              <tbody id="tabla_carrito_body">
                                  <!-- AJAX cargará los productos aquí -->
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
        </div> <!-- /.row -->

        <!-- FILA INFERIOR: DATOS DEL CLIENTE (IZQUIERDA) Y REGISTRAR VENTA (DERECHA) -->
        <div class="row">
          <!-- DATOS DEL CLIENTE (col-md-9) -->
          <div class="col-md-9">
              <div class="card card-outline card-primary">
                  <div class="card-header">
                      <h3 class="card-title"><i class="fa fa-user-check"></i> Datos del cliente</h3>
                      <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse">
                              <i class="fas fa-minus"></i>
                          </button>
                      </div>
                  </div>

                  <div class="card-body">
                      <b>Clientes </b>
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-buscar_cliente">
                          <i class="fa fa-search"></i> Buscar Cliente
                      </button>  
                      
                      <!-- Modal Búsqueda del Cliente -->
                      <div class="modal fade" id="modal-buscar_cliente">
                          <div class="modal-dialog modal-xl">
                              <div class="modal-content">
                                  <div class="modal-header" style="background-color: #1d36b6; color: white">
                                      <h4 class="modal-title">Búsqueda del cliente</h4>
                                      <button type="button" class="btn btn-warning btn-sm ml-3" data-toggle="modal" data-target="#modal-agregar_cliente">
                                          <i class="fa fa-user-plus"></i> Agregar nuevo cliente
                                      </button>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body">
                                      <div class="table-responsive">    
                                          <table id="example2" class="table table-bordered table-striped" style="width:100%">
                                              <thead>
                                                  <tr>
                                                      <th><center>Nro</center></th>
                                                      <th><center>Seleccionar</center></th>
                                                      <th><center>Nombre del cliente</center></th>        
                                                      <th><center>RUC/CI</center></th>
                                                      <th><center>Celular</center></th>
                                                      <th><center>Correo</center></th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                                  <?php  
                                                  $contador = 0;
                                                  if (isset($clientes_datos) && is_array($clientes_datos)) {
                                                      foreach ($clientes_datos as $cliente){ 
                                                          $id_cliente = $cliente['id_cliente']; 
                                                  ?>
                                                      <tr>
                                                          <td><center><?php echo ++$contador; ?></center></td>
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
                                                          <td><?php echo $cliente['email_cliente'];?></td>
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

                      <div class="row mt-3">
                          <div class="col-md-3">
                              <div class="form-group">
                                  <input type="text" id="id_cliente" hidden>
                                  <label for="">Cliente</label>
                                  <input type="text" id="nombre_cliente" class="form-control" disabled>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <label for="">RUC / CI</label>
                                  <input type="text" id="ruc_ci_cliente" class="form-control" disabled>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <label for="">Celular</label>
                                  <input type="text" id="celular_cliente" class="form-control" disabled>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <label for="">Correo</label>
                                  <input type="text" id="email_cliente" class="form-control" disabled>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <!-- REGISTRAR VENTA (col-md-3) AL LADO DE CLIENTES -->
          <div class="col-md-3">
              <div class="card card-outline card-primary">
                  <div class="card-header">
                      <h3 class="card-title"><i class="fa fa-shopping-cart"></i> Registrar venta</h3>
                      <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse">
                              <i class="fas fa-minus"></i>
                          </button>
                      </div>
                  </div>

                  <div class="card-body">
                      <div class="form-group">
                          <label for="">Monto a Cobrar</label>
                          <input type="text" id="monto_a_cancelar" class="form-control" style="text-align: center; background-color: #ffff00; font-weight: bold; font-size: 1.2em;" value="0" readonly>
                      </div>

                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="">Total pagado</label>
                              <input type="text" class="form-control" id="total_pagado" placeholder="0" autocomplete="off">
                              <input type="hidden" id="monto_a_cancelar_num" value="0">
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="">Cambio</label>
                                  <input type="text" id="cambio" class="form-control" style="text-align: center;" readonly>
                              </div>
                          </div>
                      </div>

                      <hr>
                      <button type="button" id="btn_guardar_venta" class="btn btn-primary btn-block">Guardar venta</button>
                  </div>
              </div>
          </div>
        </div> <!-- /.row -->

      </div> <!-- /.container-fluid -->
    </div> <!-- /.content -->
</div> <!-- /.content-wrapper -->

<!-- MODAL REGISTRAR NUEVO CLIENTE -->
<div class="modal fade" id="modal-agregar_cliente">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #e0a800; color: white">
                <h4 class="modal-title">Nuevo cliente</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="../app/controllers/clientes/create.php" method="POST" autocomplete="off">>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombre_cliente">Nombre del cliente</label>
                        <input type="text" name="nombre_cliente" class="form-control" placeholder="Ingrese nombre completo" required>
                    </div>
                    <div class="form-group">
                        <label for="ruc_ci_cliente">RUC/CI del cliente</label>
                        <input type="text" name="ruc_ci_cliente" class="form-control" placeholder="Ingrese NIT o CI" required>
                    </div>
                    <div class="form-group">
                        <label for="celular_cliente">Celular del cliente</label>
                        <input type="text" name="celular_cliente" class="form-control" placeholder="Ingrese número de celular">
                    </div>
                    <div class="form-group">
                        <label for="email_cliente">Correo del cliente</label>
                        <input type="email" name="email_cliente" class="form-control" placeholder="Ingrese correo electrónico">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning btn-block" style="background-color: #ffc107; border-color: #ffc107;">Guardar cliente</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('../layout/parte2.php');?>
<?php include('../layout/mensajes.php');?>

<script>
    $(function () {
        $("#example1").DataTable({ "pageLength": 5, "responsive": true, "autoWidth": false });
        $("#example2").DataTable({ "pageLength": 5, "responsive": true, "autoWidth": false });

        cargarTablaCarrito();
    });

    function cargarTablaCarrito() {
        var id_venta = $('#nro_venta').val();
        $.ajax({
            url: '../app/controllers/ventas/cargar_carrito.php?id_venta=' + id_venta,
            type: 'GET',
            success: function(html) {
                $('#tabla_carrito_body').html(html);
            }
        });
    }

    $('#example1').on('click', '.btn-seleccionar', function () {
        $('#idProductos').val($(this).data('id'));
        $('#producto').val($(this).data('nombre'));
        $('#precioVenta').val($(this).data('precioventa-formateado'));
        $('#cantidad').focus();
    });

   $('#btn_registrar_carrito').click(function () {
    var id_ventas = $('#nro_venta').val(); // Toma el valor del campo <input id="nro_venta">
    var idProductos = $('#idProductos').val();
    var cantidad = $('#cantidad').val();

    if (idProductos == "") {
        alert("Debe seleccionar un producto.");
    } else if (cantidad == "" || parseFloat(cantidad) <= 0) {
        alert("Debe ingresar un peso/cantidad válido.");
        $('#cantidad').focus();
    } else {
        $.ajax({
            url: '../app/controllers/ventas/registrar_carrito.php',
            type: 'POST',
            data: {
                id_ventas: id_ventas, // Se envía con el nombre 'id_ventas'
                idProductos: idProductos,
                cantidad: cantidad
            },
            success: function(respuesta) {
                if (respuesta.trim() == "success") {
                    cargarTablaCarrito();
                    $('#modal-buscar_producto').modal('hide');
                    $('#idProductos').val('');
                    $('#producto').val('');
                    $('#cantidad').val('');
                    $('#precioVenta').val('');
                } else {
                    alert("Error al registrar en el carrito: " + respuesta);
                }
            }
        });
    }
});

    function borrarCarrito(id_carrito) {
        if (confirm("¿Desea eliminar este producto del carrito?")) {
            $.ajax({
                url: '../app/controllers/ventas/borrar_carrito.php',
                type: 'POST',
                data: { id_carrito: id_carrito },
                success: function(respuesta) {
                    if (respuesta.trim() == "success") {
                        cargarTablaCarrito();
                    } else {
                        alert("Error al eliminar el producto.");
                    }
                }
            });
        }
    }

    $('#example2').on('click', '.btn-seleccionar_cliente', function () {
        $('#id_cliente').val($(this).data('id'));
        $('#nombre_cliente').val($(this).data('nombre_cliente'));
        $('#ruc_ci_cliente').val($(this).data('ruc_ci_cliente'));
        $('#celular_cliente').val($(this).data('celular_cliente'));
        $('#email_cliente').val($(this).data('email_cliente'));
        $('#modal-buscar_cliente').modal('hide');
    });

    $(document).on('show.bs.modal', '.modal', function () {
        var zIndex = 1040 + (10 * $('.modal:visible').length);
        $(this).css('z-index', zIndex);
        setTimeout(function() {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
        }, 0);
    });

    $('#total_pagado').keyup(function () {
        var total_cancelar = $('#monto_a_cancelar').val();
        var total_pagado = $(this).val();

        if (total_pagado != "") {
            var cambio = parseFloat(total_pagado) - parseFloat(total_cancelar);
            $('#cambio').val(cambio >= 0 ? cambio : 0);
        } else {
            $('#cambio').val("");
        }
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

    // Función para calcular el cambio / vuelto
function calcularCambio() {
    var monto_cancelar = parseFloat($('#monto_a_cancelar_num').val()) || 0;
    
    // Eliminamos los puntos que el usuario pueda escribir en el input
    var total_pagado_raw = $('#total_pagado').val().replace(/\./g, '');
    var total_pagado = parseFloat(total_pagado_raw) || 0;

    if (total_pagado >= monto_cancelar && monto_cancelar > 0) {
        var cambio = total_pagado - monto_cancelar;
        // Muestra el vuelto formateado con puntos (ej: 27.000)
        $('#cambio').val(new Intl.NumberFormat('de-DE').format(cambio));
    } else {
        // Si el dinero ingresado es menor o está vacío, se queda completamente vacío
        $('#cambio').val('');
    }
}

// Evento al escribir en el campo "Total pagado"
$('#total_pagado').on('keyup change input', function() {
    // Formatear dinámicamente lo que digita el cajero con puntos de miles
    var valor = $(this).val().replace(/\D/g, "");
    if (valor !== "") {
        $(this).val(new Intl.NumberFormat('de-DE').format(valor));
    }
    calcularCambio();
});
function borrarCarrito(id_carrito) {
    $.ajax({
        url: '../app/controllers/ventas/borrar_carrito.php',
        type: 'POST',
        data: { id_carrito: id_carrito },
        success: function(respuesta) {
            if (respuesta.trim() == "success") {
                cargarTablaCarrito(); // Vuelve a cargar la tabla y actualiza los totales
            } else {
                alert("Error al intentar eliminar el producto del carrito.");
            }
        }
    });
}
$('#btn_guardar_venta').click(function() {
    var id_ventas = $('#nro_venta').val(); // Número de venta
    var id_cliente = $('#id_cliente').val(); // ID del cliente (puede ir vacío)
    var total_pagado_raw = $('#total_pagado').val().replace(/\./g, ''); // Quitamos puntos
    var monto_cancelar = parseFloat($('#monto_a_cancelar_num').val()) || 0;
    var total_pagado = parseFloat(total_pagado_raw) || 0;

    // 1. Validar que haya productos en el carrito
    if (monto_cancelar <= 0) {
        alert("El carrito está vacío. Agregue productos antes de registrar la venta.");
        return;
    }

    // 2. Validar que el dinero entregado sea suficiente
    if (total_pagado < monto_cancelar) {
        alert("El total pagado debe ser mayor o igual al monto a cancelar.");
        return;
    }

    // 3. Enviar datos por AJAX al controlador
    $.ajax({
        url: '../app/controllers/ventas/registrar_venta.php',
        type: 'POST',
        data: {
            id_ventas: id_ventas,
            id_cliente: id_cliente,
            total_pagado: total_pagado
        },
        success: function(respuesta) {
            if (respuesta.trim() == "success") {
                alert("¡Venta registrada con éxito!");
                location.reload(); // Recarga la página para iniciar la siguiente venta
            } else if (respuesta.trim() == "carrito_vacio") {
                alert("El carrito no tiene productos.");
            } else {
                alert("Ocurrió un error al registrar la venta: " + respuesta);
            }
        }
    });
});
$('#btn_guardar_venta').click(function() {
    var id_ventas = $('#nro_venta').val();
    var id_cliente = $('#id_cliente').val(); // Puede estar vacío
    var monto_cancelar = parseFloat($('#monto_a_cancelar_num').val()) || 0;
    
    // Le quitamos los puntos de miles al campo total_pagado
    var total_pagado_raw = $('#total_pagado').val().replace(/\./g, '');
    var total_pagado = parseFloat(total_pagado_raw) || 0;

    // Validación 1: Verificar que haya productos seleccionados en el carrito
    if (monto_cancelar <= 0) {
        alert("No se puede guardar la venta: Debe seleccionar al menos un producto en el carrito.");
        return;
    }

    // Validación 2: Verificar que se haya ingresado el dinero recibido
    if ($('#total_pagado').val().trim() === "" || total_pagado <= 0) {
        alert("No se puede guardar la venta: Debe ingresar el monto en 'Total pagado'.");
        return;
    }

    // Validación 3: Verificar que la plata alcanzada sea suficiente
    if (total_pagado < monto_cancelar) {
        alert("No se puede guardar la venta: El dinero ingresado en 'Total pagado' es menor al monto a cancelar.");
        return;
    }

    // Si pasó todas las validaciones, enviamos al controlador por AJAX
    $.ajax({
        url: '../app/controllers/ventas/registrar_venta.php',
        type: 'POST',
        data: {
            id_ventas: id_ventas,
            id_cliente: id_cliente,
            total_pagado: total_pagado
        },
        success: function(respuesta) {
            if (respuesta.trim() == "success") {
                alert("¡Venta registrada con éxito!");
                location.reload();
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

    // Validamos únicamente los campos obligatorios
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

    // Enviar por AJAX
    $.ajax({
        url: '../app/controllers/clientes/guardar_cliente_ajax.php',
        type: 'POST',
        data: {
            nombre_cliente: nombre_cliente,
            ruc_ci_cliente: ruc_ci_cliente,
            celular_cliente: celular_cliente, // Puede ir vacío
            email_cliente: email_cliente      // Puede ir vacío
        },
        dataType: 'json',
        success: function (response) {
            if (response.status == "success") {
                alert("Cliente guardado con éxito.");
                $('#modal-agregar-cliente').modal('hide');

                // Asignar el nuevo cliente al selector o campo de la venta
                $('#id_cliente').append(new Option(response.nombre, response.id_cliente, true, true)).trigger('change');

                // Limpiar modal
                $('#nombre_cliente_modal').val('');
                $('#ruc_cliente_modal').val('');
                $('#celular_cliente_modal').val('');
                $('#correo_cliente_modal').val('');
            } else {
                alert("Error al registrar cliente: " + response.message);
            }
        }
    });
});

}

</script>