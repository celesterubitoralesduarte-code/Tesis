<!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2026 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="<?php echo $URL; ?>public/templeates/AdminLTE-3.2.0/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo $URL; ?>public/templeates/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $URL; ?>public/templeates/AdminLTE-3.2.0/dist/js/adminlte.min.js"></script>

<!-- DataTables  & Plugins -->
<script src="<?php echo $URL; ?>public/templeates/AdminLTE-3.2.0/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo $URL; ?>public/templeates/AdminLTE-3.2.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo $URL; ?>public/templeates/AdminLTE-3.2.0/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo $URL; ?>public/templeates/AdminLTE-3.2.0/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo $URL; ?>public/templeates/AdminLTE-3.2.0/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo $URL; ?>public/templeates/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo $URL; ?>public/templeates/AdminLTE-3.2.0/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo $URL; ?>public/templeates/AdminLTE-3.2.0/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo $URL; ?>public/templeates/AdminLTE-3.2.0/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo $URL; ?>public/templeates/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo $URL; ?>public/templeates/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo $URL; ?>public/templeates/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- SCRIPT DE FORMATO DE MILES EN TIEMPO REAL -->
<script>
function formatearMiles(input) {
    let valor = input.value.replace(/\D/g, ""); // Remueve cualquier caracter que no sea número
    if (valor !== "") {
        input.value = new Intl.NumberFormat('de-DE').format(valor); // Formato con puntos: 10.000.000
    } else {
        input.value = "";
    }
}

$(document).ready(function () {
    // Escucha automáticamente a cualquier input con la clase 'formato-precio'
    $(document).on('input', '.formato-precio', function () {
        formatearMiles(this);
    });
});
</script>

</body>
</html>