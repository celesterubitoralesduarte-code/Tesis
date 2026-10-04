<?php
define ('SERVIDOR','localhost');
define ('PUERTO','3307');
define ('USUARIO','root');
define ('PASWORD','');
define ('BD','pdv_tesis');
$servidor = "mysql:host=" . SERVIDOR .";port=". PUERTO. ";dbname=".BD . ";charset=utf8";   
try{
$pdo = new PDO($servidor, USUARIO, PASWORD);
//echo "La conexión a la base de datos ha sido exitosa";
} catch (PDOException $e){
//print_r($e);
echo "ERROR AL CONECTARSE A LA BASE DE DATOS";
}
$URL = "http://localhost/pdv_tesis/";
$fechaHora = date('Y-m-d H:i:s');


  session_start();
 if(isset( $_SESSION['mensaje'])){   
    $respuesta= $_SESSION['mensaje'];
    unset($_SESSION['mensaje']); ?>
  <script>
    window.onload = function (){   
   Swal.fire({
  position: "top-end",
  icon: "<?php echo $_SESSION['icono'] ?? 'success'; ?>",
  title: '<?php echo $respuesta; ?>',
  showConfirmButton: false,
  timer: 2500
});
}
  </script>
<?php
 }
 function formatearStock($cantidad, $unidad_medida = '') {
    // Convertimos el valor a número float
    $num = (float)$cantidad;
    $u = strtolower(trim($unidad_medida));
    
    // Si el número no tiene decimales reales (ej: 50.00 o 11.00), lo dejamos como entero sin decimales
    if ($num == floor($num)) {
        $valor = number_format($num, 0, ',', '.');
    } else {
        // Si tiene decimales reales (ej: 1.500 kg), mostramos hasta 3 decimales limpiando ceros a la derecha
        $valor = number_format($num, 3, ',', '.');
        $valor = rtrim(rtrim($valor, '0'), ',');
    }

    // Identificamos la unidad para abreviarla
    if (strpos($u, 'kilo') !== false || strpos($u, 'kg') !== false) {
        return $valor . ' Kg';
    } elseif (strpos($u, 'gramo') !== false || strpos($u, 'g') !== false) {
        return $valor . ' g';
    } elseif (strpos($u, 'unidad') !== false || strpos($u, 'und') !== false) {
        return $valor . ' Und';
    } else {
        return $valor . ' ' . trim($unidad_medida);
    }
}
  ?>
