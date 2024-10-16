<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Rutas de autenticación
$routes->get('/', 'Login::index');
$routes->post('auth', 'Login::auth');
$routes->get('logout', 'Login::logout');
$routes->get('password-change', 'Login::changePassword');
$routes->post('change-password', 'Login::updatePassword'); // Cambiar la contraseña

// Rutas de gestión de usuarios
$routes->post('users/(:num)/soft-delete', 'Users::softDelete/$1'); // Eliminación lógica de usuario
$routes->post('users/(:num)/reactivate', 'Users::reactivateUser/$1', ['as' => 'users.reactivate']); // Reactivación de usuario
$routes->get('activate-user/(:any)', 'Users::activateUser/$1'); // Activar usuario
$routes->get('password-request', 'Users::linkRequestForm'); // Formulario de solicitud de cambio de contraseña
$routes->post('password-email', 'Users::sendResetLinkEmail'); // Enviar enlace de restablecimiento
$routes->get('password-reset/(:any)', 'Users::resetForm/$1'); // Formulario de restablecimiento de contraseña
$routes->post('password/reset', 'Users::resetPassword'); // Procesar restablecimiento de contraseña

// Rutas de gestión de gafas
$routes->post('gafas/(:num)/soft-delete', 'Gafas::softDelete/$1'); // Eliminación lógica de gafas
$routes->post('gafas/(:num)/habilitar', 'Gafas::habilitar/$1'); // Habilitar gafas
$routes->post('gafas/registrar', 'Gafas::registrar'); // Registrar nuevas gafas

// Rutas de gestión de criminales
$routes->post('criminals/(:num)/soft-delete', 'Criminals::softDelete/$1'); // Eliminación lógica de criminal
$routes->post('criminals/(:num)/habilitar', 'Criminals::habilitar/$1'); // Habilitar criminal
$routes->get('criminals/(:num)/images', 'Criminals::mostrarFotos/$1'); // Ver imágenes de un criminal específico

// Rutas de detección y notificaciones
$routes->get('detections', 'Detections::index'); // Ver todas las detecciones
$routes->post('detectar/almacenarDeteccion/(:any)', 'Detections::almacenarDeteccion/$1'); // Almacenar detección
$routes->get('dashboard/detalleNotificacion/(:num)', 'Dashboard::detalleNotificacion/$1'); // Ver detalle de notificación y marcar como leída
$routes->get('notifications', 'Notifications::index'); // Ver todas las notificaciones
$routes->post('api/notify-criminal', 'Notifications::recibir'); // API para recibir notificación de criminal detectado

// Rutas de reportes
$routes->get('reports/detalleCriminal/(:num)', 'Reports::detalleCriminal/$1'); // Ver detalle de un criminal en el reporte
$routes->get('reportes', 'Reports::index'); // Ver todos los reportes
$routes->get('reporte-usuarios-pdf', 'Users::generarReportePDF'); // Generar reporte PDF de usuarios

$routes->get('reports/generar-reporte-detecciones-por-periodo', 'Reports::generarReporteDeteccionesPorPeriodo');
$routes->get('reports/criminales-detectados', 'Reports::reporteCriminalesDetectados');
$routes->get('reports/actividad-de-oficiales', 'Reports::reporteActividadDeOficiales');
$routes->get('reports/criminales-por-delito', 'Reports::reporteCriminalesPorDelito');
$routes->get('reports/ubicaciones-deteccion', 'Reports::reporteUbicacionesDeteccion');
$routes->get('reports/detecciones-por-dispositivo', 'Reports::reporteDeteccionesPorDispositivo');
$routes->get('reports/criminales-activos-inactivos', 'Reports::reporteCriminalesActivosInactivos');
$routes->get('reports/reincidencias', 'Reports::reporteReincidencias');
$routes->get('reports/criminales-altas-confianzas', 'Reports::reporteCriminalesAltasConfianzas');
$routes->get('reports/avistamientos-por-ubicacion', 'Reports::reporteAvistamientosPorUbicacion');



// Rutas de seguridad y CSRF
$routes->get('get_csrf_token', 'Security::get_csrf_token'); // Obtener token CSRF

// Rutas adicionales
$routes->get('init', 'Dashboard::modales'); // Inicializar vistas
$routes->get('start', 'Dashboard::index'); // Página de inicio
$routes->get('head', 'Dashboard::header'); // Cargar cabecera

// Rutas protegidas con el filtro de autenticación
$routes->group('/', ['filter' => 'auth'], function ($routes) {
    $routes->resource('users', ['placeholder' => '(:num)', 'except' => 'show']); // CRUD de usuarios
    $routes->resource('gafas', ['placeholder' => '(:num)', 'except' => 'show']); // CRUD de gafas
    $routes->resource('criminals', ['placeholder' => '(:num)', 'except' => 'show']); // CRUD de criminales
});
$routes->get('map/showMap/(:segment)/(:segment)', 'Maps::showMap/$1/$2');
$routes->get('detection/(:num)/images', 'Detections::verImagenDetectada/$1'); // 



