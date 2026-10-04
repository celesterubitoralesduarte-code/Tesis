<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistema de Ventas</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../public/templeates/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../public/templeates/AdminLTE-3.2.0/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../public/templeates/AdminLTE-3.2.0/dist/css/adminlte.min.css">

  <!--Libreria SweetAler2-->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <?php
  session_start();
 if(isset( $_SESSION['mensaje'])){   
    $respuesta= $_SESSION['mensaje'];
    unset($_SESSION['mensaje']); ?>
  <script>
    window.onload = function (){   
   Swal.fire({
  position: "top-end",
  icon: "error",
  title: '<?php echo $respuesta; ?>',
  showConfirmButton: false,
  timer: 1500
});
}
  </script>
<?php
 }
  ?>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="../public/templeates/AdminLTE-3.2.0/index2.html" class="h1"><b>SISTEMA DE </b>VENTAS</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Ingrese sus Datos</p></p>

      <form action="../app/controllers/login/ingreso.php" method="post" autocomplete="off">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="usuarioTrabajador" placeholder="Usuario">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
   <input type="password" id="input_password" name="pasworTrabaj" class="form-control" placeholder="Contraseña" autocomplete="off" required>
    <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="button" id="toggle_password" style="border-color: #ced4da;">
          <i class="fas fa-eye-slash" id="icono_ojo"></i>
        </button>
    </div>

        </div>
        <div class="row">
          </div>
          <!-- /.col -->
           <hr>
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Iniciar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../public/templeates/AdminLTE-3.2.0/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../public/templeates/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../public/templeates/AdminLTE-3.2.0/dist/js/adminlte.min.js"></script>
</body>
</html>

<script>
 $('#toggle_password').click(function () {
    var tipo_campo = $('#input_password').attr('type');
    
    if (tipo_campo === 'password') {
        // Se muestra el texto y cambiamos al ojo normal para indicar "visible"
        $('#input_password').attr('type', 'text');
        $('#icono_ojo').removeClass('fa-eye-slash').addClass('fa-eye');
    } else {
        // Se oculta el texto con puntos y volvemos al ojo tachado
        $('#input_password').attr('type', 'password');
        $('#icono_ojo').removeClass('fa-eye').addClass('fa-eye-slash');
    }
});

</script>
