<?php
include('../../config.php');

// Capturar parámetros enviados por AJAX ($.get)
$id_compra                 = $_GET['id_compra'];
$idProductos               = $_GET['idProductos'];
$idProveedores             = $_GET['idProveedores'];
$nro_compra                 = $_GET['nro_compra'];
$fecha_compra              = $_GET['fecha_compra'];
$comprobante               = $_GET['comprobante'];
$idTrabajadores            = $_GET['idTrabajadores'];
$precio_compra_controlador = $_GET['precio_compra_controlador']; 
$cantidad_compra           = $_GET['cantidad_compra'];
$stock_total               = $_GET['stock_total'];

$fyh_actualizacion = date('Y-m-d H:i:s');

// Verificar sesión antes de iniciarla
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pdo->beginTransaction();

$sentencia = $pdo->prepare("UPDATE tb_compras
SET idProductos=:idProductos,
    nro_compra=:nro_compra,
    fecha_compra=:fecha_compra,
    idProveedores=:idProveedores,
    comprobante=:comprobante,
    idTrabajadores=:idTrabajadores,
    precio_compra=:precio_compra,
    cantidad=:cantidad,
    fyh_actualizacion=:fyh_actualizacion
WHERE id_compra=:id_compra");

$sentencia->bindParam(':idProductos', $idProductos);
$sentencia->bindParam(':nro_compra', $nro_compra);
$sentencia->bindParam(':fecha_compra', $fecha_compra);
$sentencia->bindParam(':idProveedores', $idProveedores);
$sentencia->bindParam(':comprobante', $comprobante);
$sentencia->bindParam(':idTrabajadores', $idTrabajadores);
$sentencia->bindParam(':precio_compra', $precio_compra_controlador);
$sentencia->bindParam(':cantidad', $cantidad_compra); // <--- Corregido: :cantidad
$sentencia->bindParam(':fyh_actualizacion', $fyh_actualizacion); // <--- Corregido: $fyh_actualizacion
$sentencia->bindParam(':id_compra', $id_compra);

if($sentencia->execute()){
    // 2. Actualizar el stock en la tabla de productos
    $sentencia_stock = $pdo->prepare("UPDATE productos SET stockProductos = :stockProductos WHERE idProductos = :idProductos");
    $sentencia_stock->bindParam(':stockProductos', $stock_total);
    $sentencia_stock->bindParam(':idProductos', $idProductos);
    $sentencia_stock->execute();

    $pdo->commit();

    $_SESSION['mensaje'] = "Se actualizó la compra de manera correcta";
    $_SESSION['icono'] = "success";
    ?>
    <script>
        window.location.href = "<?php echo $URL; ?>/compras/";
    </script>
    <?php
}else{
    $pdo->rollBack();

    $_SESSION['mensaje'] = "Error no se pudo actualizar en la base de datos";
    $_SESSION['icono'] = "error";
    ?>
    <script>
        window.location.href = "<?php echo $URL; ?>/compras";
    </script>
    <?php
}