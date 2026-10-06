<?php
// =====================================================================
// MIDDLEWARE DE CONTROL DE ACCESO POR ROLES (RBAC)
// Requiere que $rol_sesion ya esté definido (layout/sesion.php)
// =====================================================================

$rutaActual = strtolower(str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? ''));
$rutaActual = preg_replace('#^/pdv_tesis/#', '', $rutaActual);
$rutaActual = trim($rutaActual, '/');
$rolActual  = strtolower(trim($rol_sesion ?? ''));

// ---- Normalización de los roles ------------------------------------
$tipoRol = 'desconocido';
// id_rol = 1 es el rol Administrador (acceso total)
if ((string)($id_rol_sesion ?? '') === '1') {
    $tipoRol = 'admin';
} elseif (strpos($rolActual, 'administr') !== false) {
    $tipoRol = 'admin';
} elseif (strpos($rolActual, 'cajero') !== false) {
    $tipoRol = 'cajero';
} elseif (strpos($rolActual, 'invent') !== false) {
    $tipoRol = 'inventario';
}

// ---- Rutas permitidas por rol --------------------------------------
$rutasCajero = [
    // Ventas: listado (ver/borrar), nueva venta, ver, imprimir factura/ticket
    'ventas/index.php',
    'ventas/create.php',
    'ventas/show.php',
    'ventas/imprimir_factura.php',
    // Clientes: listado y creación
    'clientes/index.php',
    // Controladores de soporte para las pantallas permitidas
    'app/controllers/ventas/listado_de_ventas.php',
    'app/controllers/ventas/listado_de_ventas_realizadas.php',
    'app/controllers/ventas/cargar_carrito.php',
    'app/controllers/ventas/registrar_carrito.php',
    'app/controllers/ventas/borrar_carrito.php',
    'app/controllers/ventas/registrar_venta.php',
    'app/controllers/ventas/vaciar_carrito.php',
    'app/controllers/ventas/imprimir_ticket.php',
    'app/controllers/ventas/delete.php',
    'app/controllers/ventas/show_ventas.php',
    'app/controllers/clientes/listado_de_clientes.php',
    'app/controllers/clientes/guardar_cliente.php',
    'app/controllers/clientes/guardar_cliente_ajax.php',
    'app/controllers/productos/listado_de_productos.php',
    'app/controllers/login/cerrar_sesion.php',
];

$rutasInventario = [
    // Productos: listado (ver/editar/borrar) y creación
    'productos/index.php',
    'productos/create.php',
    'productos/show.php',
    'productos/update.php',
    'productos/delete.php',
    // Compras: listado (ver/editar/borrar) y creación
    'compras/index.php',
    'compras/create.php',
    'compras/show.php',
    'compras/update.php',
    'compras/delete.php',
    // Proveedores: listado (editar/borrar)
    'proveedores/index.php',
    // Controladores de soporte
    'app/controllers/productos/listado_de_productos.php',
    'app/controllers/productos/create.php',
    'app/controllers/productos/update.php',
    'app/controllers/productos/delete.php',
    'app/controllers/productos/cargar_producto.php',
    'app/controllers/proveedores/listado_de_proveedores.php',
    'app/controllers/proveedores/create.php',
    'app/controllers/proveedores/update.php',
    'app/controllers/proveedores/delete.php',
    'app/controllers/compras/listado_de_compras.php',
    'app/controllers/compras/create.php',
    'app/controllers/compras/update.php',
    'app/controllers/compras/delete.php',
    'app/controllers/compras/cargar_compra.php',
    'app/controllers/login/cerrar_sesion.php',
];

// Rutas visibles para todos los roles autenticados
$rutasPublicas = [
    '',
    'index.php',
    'deshboard.php',
];

function rolPermiteRuta($ruta) {
    global $tipoRol, $rutasCajero, $rutasInventario, $rutasPublicas;
    $ruta = trim(strtolower(str_replace('\\', '/', $ruta)), '/');
    if (in_array($ruta, $rutasPublicas, true)) {
        return true;
    }
    if ($tipoRol === 'admin') {
        return true;
    }
    $lista = [];
    if ($tipoRol === 'cajero') {
        $lista = $rutasCajero;
    } elseif ($tipoRol === 'inventario') {
        $lista = $rutasInventario;
    }
    foreach ($lista as $r) {
        if ($ruta === $r || substr($ruta, -strlen('/' . $r)) === '/' . $r) {
            return true;
        }
    }
    return false;
}

// ---- Bloqueo de rutas no autorizadas --------------------------------
if (!rolPermiteRuta($rutaActual)) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // El mensaje se muestra en la página destino; para evitar la pantalla en
    // blanco cuando ya se envió salida (config.php), no dependemos solo de header()
    $destino = $URL . 'index.php';
    if (!headers_sent()) {
        header('Location: ' . $destino);
        exit();
    }
    echo "<!DOCTYPE html><html lang=\"es\"><head><meta charset=\"utf-8\">";
    echo "<meta http-equiv=\"refresh\" content=\"0;url=" . $destino . "\">";
    echo "<title>Acceso denegado</title></head><body style=\"font-family:Arial;text-align:center;padding-top:60px;\">";
    echo "<h3>Acceso denegado: no tiene permisos para ingresar a esta sección.</h3>";
    echo "<p><a href=\"" . $destino . "\">Ir al inicio</a></p>";
    echo "</body></html>";
    exit();
}
