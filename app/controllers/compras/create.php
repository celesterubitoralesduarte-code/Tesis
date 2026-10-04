<?php
include('../../config.php');

// Capturar parámetros enviados por AJAX ($.get)
$idProductos               = $_GET['idProductos'];
$idProveedores             = $_GET['idProveedores'];
$nro_compra                 = $_GET['nro_compra'];
$fecha_compra              = $_GET['fecha_compra'];
$comprobante               = $_GET['comprobante'];
$idTrabajadores            = $_GET['idTrabajadores'];
$precio_compra_controlador = $_GET['precio_compra_controlador']; 
$cantidad_compra           = $_GET['cantidad_compra'];
$stock_total               = $_GET['stock_total'];

$fyh_creacion = date('Y-m-d H:i:s');

// Verificar sesión antes de iniciarla
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pdo->beginTransaction();
// 1. Insertar la compra
$sentencia = $pdo->prepare("INSERT INTO tb_compras
    (idProductos, idProveedores, nro_compra, fecha_compra, comprobante, idTrabajadores, precio_compra, cantidad, fyh_creacion)
    VALUES 
    (:idProductos, :idProveedores, :nro_compra, :fecha_compra, :comprobante, :idTrabajadores, :precio_compra, :cantidad_compra, :fyh_creacion)");

$sentencia->bindParam('idProductos', $idProductos);
$sentencia->bindParam('idProveedores', $idProveedores);
$sentencia->bindParam('nro_compra', $nro_compra);
$sentencia->bindParam('fecha_compra', $fecha_compra);
$sentencia->bindParam('comprobante', $comprobante);
$sentencia->bindParam('idTrabajadores', $idTrabajadores);
$sentencia->bindParam('precio_compra', $precio_compra_controlador);
$sentencia->bindParam('cantidad_compra', $cantidad_compra);
$sentencia->bindParam('fyh_creacion', $fyh_creacion);

if($sentencia->execute()){
    // 2. Actualizar el stock en la tabla de productos
    $sentencia_stock = $pdo->prepare("UPDATE productos SET stockProductos = :stockProductos WHERE idProductos = :idProductos");
    $sentencia_stock->bindParam('stockProductos', $stock_total);
    $sentencia_stock->bindParam('idProductos', $idProductos);
    $sentencia_stock->execute();

    $pdo->commit();

    $_SESSION['mensaje'] = "Se registro la compra de la manera correcta";
    $_SESSION['icono'] = "success";
    ?>
    <script>
        window.location.href = "<?php echo $URL; ?>/compras/";
    </script>
    <?php
}else{
    $pdo->rollBack();

    $_SESSION['mensaje'] = "Error no se pudo registrar en la base de datos";
    $_SESSION['icono'] = "error";
    ?>
    <script>
        window.location.href = "<?php echo $URL; ?>/compras/create.php";
    </script>
    <?php
}