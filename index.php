<?php
include('app/config.php');
include('layout/sesion.php');

include('layout/parte1.php');
include('app/controllers/usuarios/listado_usuarios.php');
include('app/controllers/roles/listado_roles.php');
include('app/controllers/productos/listado_de_productos.php');
include('app/controllers/proveedores/listado_de_proveedores.php');
include('app/controllers/compras/listado_de_compras.php');
include('app/controllers/ventas/listado_de_ventas.php');
include('app/controllers/clientes/listado_de_clientes.php');
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0">BIENVENIDO AL SISTEMA WEB - <?php echo $rol_sesion;?></h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
      
      Contenido del Sistema

      <br><br>

     <div class="row">

  

    <!-- Caja 3 -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
              <?php
              $contador_de_usuarios = 0;
              foreach($usuarios_datos as $usuarios_dato){
            $contador_de_usuarios = $contador_de_usuarios + 1;
              }
              ?>
                <h3><?php echo $contador_de_usuarios;?></h3>
                <p>Usuarios Registrados</p>
            </div>

            <a href="trabajadores/create.php">
              <div class="icon">
                <i class="fas fa-user-plus"></i>
            </div>
            </a>

            <a href="trabajadores" class="small-box-footer">
                Más detalle <i class="fas fa-arrow-circle-right"></i>
                <a href="trabajadores">
            </a>
        </div>
    </div>


    
     <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
              <?php
              $contador_de_roles = 0;
              foreach($roles_datos as $roles_dato){
            $contador_de_roles = $contador_de_roles + 1;
              }
              ?>
                <h3><?php echo $contador_de_roles;?></h3>
                <p>Roles Registrados</p>
            </div>

            <a href="roles/create.php">
              <div class="icon">
                <i class="fas fa-address-card"></i>
            </div>
            </a>

            <a href="roles" class="small-box-footer">
                Más detalle <i class="fas fa-arrow-circle-right"></i>
                <a href="trabajadores">
            </a>
        </div>
    </div>


    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
              <?php
              $contador_de_productos = 0;
              foreach($productos_datos as $productos_dato){
            $contador_de_productos = $contador_de_productos + 1;
              }
              ?>
                <h3><?php echo $contador_de_productos;?></h3>
                <p>Productos Registrados</p>
            </div>

            <a href="productos/create.php">
              <div class="icon">
                <i class="fas fa-list"></i>
            </div>
            </a>

            <a href="productos" class="small-box-footer">
                Más detalle <i class="fas fa-arrow-circle-right"></i>
                <a href="productos">
            </a>
        </div>
    </div>


   <div class="col-lg-3 col-6">
    <div class="small-box bg-dark"> <!-- O la clase de color que uses para proveedores -->
        <div class="inner">
            <?php
            $contador_de_proveedores = 0;
            foreach($proveedores_datos as $proveedores_dato){
                $contador_de_proveedores = $contador_de_proveedores + 1;
            }
            ?>
            <h3><?php echo $contador_de_proveedores;?></h3>
            <p>Proveedores Registrados</p>
        </div>

        <a href="proveedores">
            <div class="icon">
                <i class="fas fa-car"></i>
            </div>
        </a>

        <a href="proveedores" class="small-box-footer">
            Más detalle <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>


<div class="col-lg-3 col-6">
    <div class="small-box bg-danger"> 
        <div class="inner">
          <?php
              $contador_de_compras = 0;
              foreach($compras_datos as $compras_dato){
            $contador_de_compras = $contador_de_compras + 1;
              }
              ?>
                <h3><?php echo $contador_de_compras;?></h3>
                <p>Compras Registradas</p>
            </div>

        <a href="compras/create.php">
            <div class="icon">
                <i class="fas fa-cart-plus"></i>
            </div>
        </a>

        <a href="compras" class="small-box-footer">
            Más detalle <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>



<div class="col-lg-3 col-6">
    <div class="small-box bg-success"> 
        <div class="inner">
          <?php
              $contador_de_ventas = 0;
              foreach($ventas_datos as $ventas_dato){
            $contador_de_ventas = $contador_de_ventas + 1;
              }
              ?>
                <h3><?php echo $contador_de_ventas;?></h3>
                <p>Ventas Registradas</p>
            </div>

        <a href="ventas/create.php">
            <div class="icon">
                <i class="fas fa-shopping-basket"></i>
            </div>
        </a>

        <a href="ventas" class="small-box-footer">
            Más detalle <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>

<div class="col-lg-3 col-6">
    <div class="small-box bg-warning"> 
        <div class="inner">
          <?php
              $contador_de_clientes = 0;
              foreach($clientes_datos as $clientes_dato){
            $contador_de_clientes = $contador_de_clientes + 1;
              }
              ?>
                <h3><?php echo $contador_de_clientes;?></h3>
                <p>Clientes Registrados</p>
            </div>

        <a href="clientes/create.php">
            <div class="icon">
                <i class="fas fa-user-friends"></i>
            </div>
        </a>

        <a href="clientes" class="small-box-footer">
            Más detalle <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>


    


</div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



<?php include('layout/parte2.php');?>





  
