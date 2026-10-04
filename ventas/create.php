<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');
include_once __DIR__ . '/../app/controllers/ventas/listado_de_ventas.php';
include_once __DIR__ . '/../app/controllers/productos/listado_de_productos.php';


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
            <h1 class="m-0">Ventas</h1>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
        <div class="col-md-12">
             <!-- COLUMNA DERECHA (DATOS DE LA COMPRA) -->
              <div class="card card-outline card-primary">
                  <div class="card-header">
                   <?php
$contador_de_ventas = 0;
foreach ($ventas_datos as $ventas_dato) {
    $contador_de_ventas = $contador_de_ventas + 1;
}
?>
                     <h3 class="card-title"><i class="fa fa-shopping-bag"></i> Venta Nro
                         <input type="text" style="text-align: center" value="<?php echo $contador_de_ventas + 1; ?>" disabled></h3>
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
data-precioventa-formateado="<?php echo number_format($precioVenta, 0, ',', '.');?>"
        data-fecha="<?php echo date('d/m/Y', strtotime($producto['fecha_ingreso']));?>"
        data-unidad="<?php echo $producto['unidadMedida'];?>">
    Seleccionar
</button>
                                                      </td>
                                                      <td><?php echo $producto['codigo'];?></td>
                                                    <td><?php echo $producto['nomProductos'];?></td>
<td>
    <?php echo formatearStock($producto['stockProductos'], $producto['unidadMedida']); ?>
</td>
<td>
    <?php echo formatearStock($producto['stockMinimo'], $producto['unidadMedida']); ?>
</td>
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
            <label for="">Cantidad</label>
            <input type="text" id="cantidad" class="form-control">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Precio Unitario</label>
            <input type="text" id="precioVenta" class="form-control " disabled>
        </div>
    </div>
    <div class="col-md-3">
    <div class="form-group">
        <label for="">&nbsp;</label> <!-- Espacio para alinear con las etiquetas de los otros inputs -->
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
<div class="table-responsive">
    <table class="table table-bordered table-sm table-hover table-striped">
        <thead>
            <tr>
                <th style="background-color: #e7e7e7;text-align: center">Nro</th>
                <th style="background-color: #e7e7e7;text-align: center">Nombre</th>
                <th style="background-color: #e7e7e7;text-align: center">Cantidad</th>
                <th style="background-color: #e7e7e7;text-align: center">Precio Unitario</th>
                <th style="background-color: #e7e7e7;text-align: center">Precio SubTotal</th>
                <th style="background-color: #e7e7e7;text-align: center">Acción</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th colspan="2" style="background-color: #e7e7e7;text-align: right">Total</th>
                <th><center>4</center></th>
                <th><center>10</center></th>
                <th><center>20</center></th>
            </tr>
        </tbody>
    </table>
</div>
                  </div>
             
        </div>
          </div>

        </div>

        <div class="row">
    <div class="col-md-12">
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
                asdf
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
    });

    // Evento A: Al hacer clic en el botón "Seleccionar" de un producto
    $('#example1').on('click', '.btn-seleccionar', function () {
        var idProductos = $(this).data('id');
        $('#idProductos').val(idProductos);

        var producto = $(this).data('nombre');
        $('#producto').val(producto);

        var precioFormateado = $(this).data('precioventa-formateado'); 
        $('#precioVenta').val(precioFormateado);

        $('#cantidad').focus();
        // $('#modal-buscar_producto').modal('hide');
    });

    // Evento B: Al hacer clic en el botón "Registrar" (DEBE ESTAR AFUERA)
    $('#btn_registrar_carrito').click(function () {
        var id_venta = '<?php echo $contador_de_ventas + 1; ?>';
        var idProductos = $('#idProductos').val();
        var cantidad = $('#cantidad').val();

        if (idProductos == "") {
            alert("Debe seleccionar un producto antes de registrar.");
        } else if (cantidad == "" || cantidad <= 0) {
            alert("Debe ingresar una cantidad válida.");
            $('#cantidad').focus();
        } else {
            alert("Venta Nro: " + id_venta + " - Producto ID: " + idProductos + " - Cantidad: " + cantidad);
        }
    });
</script>