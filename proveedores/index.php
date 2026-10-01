<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');

// Corrección de la ruta
include_once __DIR__ . '/../app/controllers/proveedores/listado_de_proveedores.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Listado de Proveedores
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create">
                            <i class="fa fa-plus"></i> Agregar Nuevo
                        </button>
                    </h1>
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
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Proveedores Registrados</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" style="display: block;">
                            <table id="example1" class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Nro</th>
                                        <th>Nombre del Proveedor</th>
                                        <th>Celular</th>
                                        <th>Teléfono</th>
                                        <th>Empresa</th>
                                        <th>Email</th>
                                        <th>Ruc</th>
                                        <th>Dirección</th>
                                        <th>Acciones</th>
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
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-update<?php echo $idProveedores; ?>">
                                                        <i class="fa fa-pencil-alt"></i> Editar
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete<?php echo $idProveedores; ?>">
                                                        <i class="fa fa-trash"></i> Borrar
                                                    </button>
                                                </div>

                                                <!-- Modal para actualizar proveedor -->
                                                <div class="modal fade" id="modal-update<?php echo $idProveedores; ?>">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="background-color: #1d36b6; color: white">
                                                                <h4 class="modal-title">Actualización del Proveedor</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="">Nombre del Proveedor <b>*</b></label>
                                                                            <input type="text" id="nombre_proveedor_update<?php echo $idProveedores; ?>" value="<?php echo $nombre_proveedor; ?>" class="form-control">
                                                                            <small style="display: none; color: red;" id="lbl_nombre_update<?php echo $idProveedores; ?>">* Este campo es requerido</small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="">Celular <b>*</b></label>
                                                                            <input type="text" id="celular_update<?php echo $idProveedores; ?>" value="<?php echo $proveedores_dato['celular']; ?>" class="form-control">
                                                                            <small style="display: none; color: red;" id="lbl_celular_update<?php echo $idProveedores; ?>">* Este campo es requerido</small>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="">Teléfono</label>
                                                                            <input type="text" id="telefono_update<?php echo $idProveedores; ?>" value="<?php echo $proveedores_dato['telefono']; ?>" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="">Empresa <b>*</b></label>
                                                                            <input type="text" id="empresa_update<?php echo $idProveedores; ?>" value="<?php echo $proveedores_dato['empresa']; ?>" class="form-control">
                                                                            <small style="display: none; color: red;" id="lbl_empresa_update<?php echo $idProveedores; ?>">* Este campo es requerido</small>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="">Email</label>
                                                                            <input type="text" id="email_update<?php echo $idProveedores; ?>" value="<?php echo $proveedores_dato['email']; ?>" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="">Ruc</label>
                                                                            <input type="text" id="rucProveedores_update<?php echo $idProveedores; ?>" value="<?php echo $proveedores_dato['rucProveedores']; ?>" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="">Dirección <b>*</b></label>
                                                                            <input type="text" id="direccion_update<?php echo $idProveedores; ?>" value="<?php echo $proveedores_dato['direccion']; ?>" class="form-control">
                                                                            <small style="display: none; color: red;" id="lbl_direccion_update<?php echo $idProveedores; ?>">* Este campo es requerido</small>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer justify-content-between">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                                <button type="button" class="btn btn-success btn-actualizar-proveedor" data-id="<?php echo $idProveedores; ?>">Actualizar</button>
                                                            </div>
                                                            <div id="respuesta_update<?php echo $idProveedores; ?>"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Modal para eliminar proveedor -->
                                                <div class="modal fade" id="modal-delete<?php echo $idProveedores; ?>">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="background-color: #ca0a0b; color: white">
                                                                <h4 class="modal-title">¿Estas seguro de Eliminar al Proveedor?</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="">Nombre del Proveedor</label>
                                                                            <input type="text" value="<?php echo $nombre_proveedor; ?>" class="form-control" disabled>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="">Celular</label>
                                                                            <input type="text" value="<?php echo $proveedores_dato['celular']; ?>" class="form-control" disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="">Teléfono</label>
                                                                            <input type="text" value="<?php echo $proveedores_dato['telefono']; ?>" class="form-control" disabled>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="">Empresa</label>
                                                                            <input type="text" value="<?php echo $proveedores_dato['empresa']; ?>" class="form-control" disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="">Email</label>
                                                                            <input type="text" value="<?php echo $proveedores_dato['email']; ?>" class="form-control" disabled>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="">Ruc</label>
                                                                            <input type="text" value="<?php echo $proveedores_dato['rucProveedores']; ?>" class="form-control" disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="">Dirección</label>
                                                                            <input type="text" value="<?php echo $proveedores_dato['direccion']; ?>" class="form-control" disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer justify-content-between">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                                <button type="button" class="btn btn-danger btn-delete-proveedor" data-id="<?php echo $idProveedores; ?>">Eliminar</button>
                                                            </div>
                                                            <div id="respuesta_delete<?php echo $idProveedores;?>"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>

<script>
    $(function () {
        $("#example1").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Proveedores",
                "infoEmpty": "Mostrando 0 a 0 de 0 Proveedores",
                "infoFiltered": "(Filtrado de _MAX_ total Proveedores)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Proveedores",
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
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>

<!-- Modal para registrar proveedores -->
<div class="modal fade" id="modal-create">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1d36b6; color: white">
                <h4 class="modal-title">Creación de un nuevo Proveedor</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Nombre del Proveedor <b>*</b></label>
                            <input type="text" id="nombre_proveedor" class="form-control">
                            <small style="display: none; color: red;" id="lbl_nombre">* Este campo es requerido</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Celular <b>*</b></label>
                            <input type="text" id="celular" class="form-control">
                            <small style="display: none; color: red;" id="lbl_celular">* Este campo es requerido</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Teléfono</label>
                            <input type="text" id="telefono" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Nombre de la Empresa <b>*</b></label>
                            <input type="text" id="empresa" class="form-control">
                            <small style="display: none; color: red;" id="lbl_empresa">* Este campo es requerido</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" id="email" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Ruc</label>
                            <input type="text" id="rucProveedores" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Dirección <b>*</b></label>
                            <textarea id="direccion" cols="30" rows="3" class="form-control"></textarea>
                            <small style="display: none; color: red;" id="lbl_direccion">* Este campo es requerido</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btn_create">Guardar Proveedor</button>
            </div>
            <div id="respuesta"></div>
        </div>
    </div>
</div>

<script>
    // Script para Registrar Nuevo Proveedor
    $('#btn_create').click(function () {
        var nombre_proveedor = $('#nombre_proveedor').val();
        var celular = $('#celular').val();
        var telefono = $('#telefono').val();
        var empresa = $('#empresa').val();
        var email = $('#email').val();
        var rucProveedores = $('#rucProveedores').val();
        var direccion = $('#direccion').val();

        $('#lbl_nombre, #lbl_celular, #lbl_empresa, #lbl_direccion').css('display', 'none');

        var valido = true;

        if (nombre_proveedor == "") { $('#lbl_nombre').css('display', 'block'); $('#nombre_proveedor').focus(); valido = false; }
        if (celular == "") { $('#lbl_celular').css('display', 'block'); valido = false; }
        if (empresa == "") { $('#lbl_empresa').css('display', 'block'); valido = false; }
        if (direccion == "") { $('#lbl_direccion').css('display', 'block'); valido = false; }

        if (valido) {
            var url = "../app/controllers/proveedores/create.php";
            $.get(url, {
                nombre_proveedor: nombre_proveedor,
                celular: celular,
                telefono: telefono,
                empresa: empresa,
                email: email,
                rucProveedores: rucProveedores,
                direccion: direccion
            }, function (datos) {
                $('#respuesta').html(datos);
            });
        }
    });

    // Script global para Actualizar Proveedor
    $(document).on('click', '.btn-actualizar-proveedor', function () {
        var idProveedores = $(this).data('id');

        var nombre_proveedor = $('#nombre_proveedor_update' + idProveedores).val();
        var celular = $('#celular_update' + idProveedores).val();
        var telefono = $('#telefono_update' + idProveedores).val();
        var empresa = $('#empresa_update' + idProveedores).val();
        var email = $('#email_update' + idProveedores).val();
        var rucProveedores = $('#rucProveedores_update' + idProveedores).val();
        var direccion = $('#direccion_update' + idProveedores).val();

        $('#lbl_nombre_update' + idProveedores + ', #lbl_celular_update' + idProveedores + ', #lbl_empresa_update' + idProveedores + ', #lbl_direccion_update' + idProveedores).css('display', 'none');

        var valido = true;

        if (nombre_proveedor == "") { $('#lbl_nombre_update' + idProveedores).css('display', 'block'); $('#nombre_proveedor_update' + idProveedores).focus(); valido = false; }
        if (celular == "") { $('#lbl_celular_update' + idProveedores).css('display', 'block'); valido = false; }
        if (empresa == "") { $('#lbl_empresa_update' + idProveedores).css('display', 'block'); valido = false; }
        if (direccion == "") { $('#lbl_direccion_update' + idProveedores).css('display', 'block'); valido = false; }

        if (valido) {
            var url = "../app/controllers/proveedores/update.php";
            $.get(url, {
                idProveedores: idProveedores,
                nombre_proveedor: nombre_proveedor,
                celular: celular,
                telefono: telefono,
                empresa: empresa,
                email: email,
                rucProveedores: rucProveedores,
                direccion: direccion
            }, function (datos) {
                $('#respuesta_update' + idProveedores).html(datos);
            });
        }
    });

    // Script global para Eliminar Proveedor
    $(document).on('click', '.btn-delete-proveedor', function () {
        var idProveedores = $(this).data('id');
     
        var url2 = "../app/controllers/proveedores/delete.php";
        $.get(url2, {idProveedores: idProveedores}, function (datos) {
            $('#respuesta_delete' + idProveedores).html(datos);
        });
    });
</script>