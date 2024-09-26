<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('register', 'Dashboard::registro');

 $routes->get('/', 'Login::index');
 $routes->post('auth', 'Login::auth');
 $routes->get('logout', 'Login::logout');
 $routes->post('change-password', 'Login::updatePassword'); // Cambiar la contraseña
 $routes->get('password-change', 'Login::changePassword');



//Ruta para la eliminacion logica usuarios
 $routes->post('users/(:num)/soft-delete', 'Users::softDelete/$1');

 //Ruta para la eliminacion logica criminales
 $routes->post('criminals/(:num)/soft-delete', 'Criminals::softDelete/$1');

//Rutas de validacion o verificacion
 $routes->get('activate-user/(:any)', 'Users::activateUser/$1');
 $routes->get('password-request', 'Users::linkRequestForm');
 $routes->post('password-email', 'Users::sendResetLinkEmail');
 $routes->get('password-reset/(:any)', 'Users::resetForm/$1');
 $routes->post('password/reset', 'Users::resetPassword');
 


//Rutas protegidas
 $routes->group('/', ['filter'=>'auth'], function($routes){

    $routes->resource('users', ['placeholder'=>'(:num)', 'except'=>'show']);

    $routes->get('start', 'Dashboard::index');

    $routes->get('detections', 'Detections::index');

    $routes->get('notifications', 'Notifications::index');

    $routes->get('reporte-usuarios-pdf', 'Users::generarReportePDF');
    
    $routes->resource('criminals', ['placeholder'=>'(:num)', 'except'=>'show']);

    $routes->get('head', 'Dashboard::header'); 
     
 });
 // Ruta para ver el detalle de una notificación y marcarla como leída
$routes->get('dashboard/detalleNotificacion/(:num)', 'Dashboard::detalleNotificacion/$1');
 $routes->get('reports/detalleCriminal/(:num)', 'Reports::detalleCriminal/$1');

 $routes->get('reportes', 'Reports::index');

 $routes->post('camara/upload', 'CamaraController::upload');

 

 $routes->post('api/notify-criminal', 'Notifications::recibir');

 $routes->post('detectar/almacenarDeteccion/(:any)', 'Detections::almacenarDeteccion/$1');


