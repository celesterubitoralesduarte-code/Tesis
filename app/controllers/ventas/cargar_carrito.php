<?php
include('../../config.php');

$id_ventas = $_GET['id_ventas'] ?? 0;
$contador = 0;
$total_cantidad = 0;
$grand_total = 0;

$query = $pdo->prepare("SELECT c.id_carrito, c.cantidad, p.nomProductos, p.precioVenta, p.unidadMedida 
                        FROM tb_carrito as c 
                        INNER JOIN productos as p ON c.idProductos = p.idProductos 
                        WHERE c.id_ventas = :id_ventas");
$query->execute([':id_ventas' => $id_ventas]);
$items = $query->fetchAll(PDO::FETCH_ASSOC);

if (count($items) > 0) {
    foreach ($items as $item) {
        $contador++;
        $peso = (float)$item['cantidad'];
        $precio = (float)$item['precioVenta'];
        $unidad = strtoupper(trim($item['unidadMedida'] ?? ''));
        
        if ($precio > 0 && $precio < 1000) {
            $precio = $precio * 1000;
        }

        $subtotal = $peso * $precio;

        $total_cantidad += $peso;
        $grand_total += $subtotal;

        // Detecta si es por unidad o paquete; de lo contrario, aplica 3 decimales (peso)
        if (strpos($unidad, 'UNI') !== false || strpos($unidad, 'UND') !== false || strpos($unidad, 'PAQ') !== false) {
            $cantidad_formateada = (floor($peso) == $peso) ? number_format($peso, 0) : number_format($peso, 2, '.', '');
        } else {
            // Fuerza siempre 3 decimales para cortes por peso (1.250 Kg)
            $cantidad_formateada = number_format($peso, 3, '.', '');
        }
        ?>
        <tr>
            <td><center><?= $contador; ?></center></td>
            <td><?= htmlspecialchars($item['nomProductos']); ?></td>
            <td><center><?= $cantidad_formateada; ?></center></td>
            <td><center>Gs. <?= number_format($precio, 0, ',', '.'); ?></center></td>
            <td><center>Gs. <?= number_format($subtotal, 0, ',', '.'); ?></center></td>
            <td>
                <center>
                    <button class="btn btn-danger btn-sm" onclick="borrarCarrito(<?= $item['id_carrito']; ?>)">
                        <i class="fa fa-trash"></i> Borrar
                    </button>
                </center>
            </td>
        </tr>
        <?php
    }
}
?>

<!-- FILA DE TOTALES -->
<tr style="background-color: #e7e7e7; font-weight: bold;">
    <td colspan="2" style="text-align: right; vertical-align: middle;">Total</td>
    <td style="text-align: center; background-color: #ffffff; vertical-align: middle;">
        <?= number_format($total_cantidad, (floor($total_cantidad) == $total_cantidad ? 0 : 3), '.', ''); ?>
    </td>
    <!-- Celda de Precio Unitario limpia en el Total -->
    <td style="background-color: #ffffff;"></td> 
    <td style="text-align: center; background-color: #ffff00; font-size: 1.1em; vertical-align: middle;">
        Gs. <?= number_format($grand_total, 0, ',', '.'); ?>
    </td>
    <td style="background-color: #e7e7e7;"></td>
</tr>

<script>
    // Formatear el monto a cancelar con separador de miles de Guaraníes
    var grand_total = <?= $grand_total; ?>;
    var grand_total_formateado = new Intl.NumberFormat('de-DE').format(grand_total);
    
    $('#monto_a_cancelar').val(grand_total_formateado);
    $('#monto_a_cancelar_num').val(grand_total); // Guardamos el número sin puntos en un input oculto para cálculos

    // Recalcular el vuelto si ya había algo escrito en "Total pagado"
    calcularCambio();
</script>