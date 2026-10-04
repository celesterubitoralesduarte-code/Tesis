<?php
include('../../config.php');

$id_compra = $_GET['id_compra'];
$idProductos = $_GET['idProductos'];
$cantidad_compra = $_GET['cantidad_compra'];
$stock_actual = $_GET['stock_actual'];

//echo $id_compra." - ".$idProductos." - ".$cantidad_compra." - ".$stock_actual;

$pdo->beginTransaction();

$sentencia = $pdo->prepare("DELETE FROM tb_compras WHERE id_compra = :id_compra");

$sentencia->bindParam(':id_compra', $id_compra);

if($sentencia->execute()){
    // 2. Actualizar el stock en la tabla de productos
    $stock = $stock_actual - $cantidad_compra;
    $sentencia_stock = $pdo->prepare("UPDATE productos SET stockProductos = :stockProductos WHERE idProductos = :idProductos");
    $sentencia_stock->bindParam(':stockProductos', $stock);
    $sentencia_stock->bindParam(':idProductos', $idProductos);
    $sentencia_stock->execute();

    $pdo->commit();

    $_SESSION['mensaje'] = "Se Elimino la compra de manera correcta";
    $_SESSION['icono'] = "success";
    ?>
    <script>
        window.location.href = "<?php echo $URL; ?>/compras/";
    </script>
    <?php
}else{
    $pdo->rollBack();

    $_SESSION['mensaje'] = "Error no se pudo eliminar en la base de datos";
    $_SESSION['icono'] = "error";
    ?>
    <script>
        window.location.href = "<?php echo $URL; ?>/compras";
    </script>
    <?php
}
