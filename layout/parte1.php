<?php 
include_once __DIR__ . '/sesion.php';
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Carniceria los Hermanos</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo $URL; ?>public/templeates/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $URL; ?>public/templeates/AdminLTE-3.2.0/dist/css/adminlte.min.css">

      <!--Libreria SweetAler2-->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo $URL; ?>public/templeates/AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo $URL; ?>public/templeates/AdminLTE-3.2.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo $URL; ?>public/templeates/AdminLTE-3.2.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">





  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link"
          data-widget="pushmenu"
          href="#"
          role="button">
         <i class="fas fa-bars"></i>
       </a>
      </li>

      <li class="nav-item">
        <a href="#" class="nav-link">SISTEMA DE COMPRA Y VENTAS</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item"> 
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
           
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo $URL;?>" class="brand-link">
      <img src="<?php echo $URL;?>/public/imagens/logoCarniceria.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light" style="font-size:14px;">Carniceria los Hermanos</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo $URL;?>/public/imagens/" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $NomTrabajadores;?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
           <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Usuarios
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $URL;?>trabajadores" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Listado de Usuarios</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>trabajadores/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Creacion de Usuarios</p>
                </a>
              </li>
            </ul>
          </li>
          
          
          
          
          <li class="nav-item">
            <a href="#" class="nav-link active">
             <i class="nav-icon fas fa-address-card"></i>
              <p>
                Roles
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $URL;?>roles" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Listado de Roles</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>roles/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Creacion de Rol</p>
                </a>
             </li>
            </ul>
          </li>


         <li class="nav-item">
            <a href="#" class="nav-link active">
             <i class="nav-icon fas fa-list"></i>
              <p>
                Productos
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $URL;?>productos" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Listado de Productos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>productos/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Creacion de Productos</p>
                </a>
             </li>
            </ul>
          </li>


          <li class="nav-item">
            <a href="#" class="nav-link active">
             <i class="nav-icon fas fa-cart-plus"></i>
              <p>
                Compras
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $URL;?>compras" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Listado de Compras</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>compras/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Creacion de Compras</p>
                </a>
             </li>
            </ul>
          </li>


            <li class="nav-item">
            <a href="#" class="nav-link active">
             <i class="nav-icon fas fa-car"></i>
              <p>
                Proveedores
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $URL;?>proveedores" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Listado de Proveedores</p>
                </a>
              </li>
            </ul>
          </li>



             <li class="nav-item">
            <a href="#" class="nav-link active">
             <i class="nav-icon fas fa-shopping-basket"></i>
              <p>
                Ventas
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $URL;?>ventas" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Listado de Ventas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>ventas/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Realizar Venta</p>
                </a>
             </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link active">
             <i class="nav-icon fas fa-user-friends"></i>
              <p>
                Clientes
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $URL;?>clientes" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Listado de Clientes</p>
                </a>
              </li>
              <li class="nav-item">
               
             </li>
            </ul>
          </li>


          <li class="nav-item">
            <a href="<?php echo $URL;?>app/controllers/login/cerrar_sesion.php" class="nav-link" style="background-color:crimson" >
              <i class="nav-icon fas fa-door-closed"></i>
              <p>
                Cerrar Sesion
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>