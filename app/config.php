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
  ?>
