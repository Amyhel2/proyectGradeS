<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 $routes->get('/', 'Login::index');
 $routes->post('auth', 'Login::auth');
 $routes->get('logout', 'Login::logout');
 
//Ruta para la eliminacion logica
 $routes->post('users/(:num)/soft-delete', 'Users::softDelete/$1');
//Rutas de validacion o verificacion
 $routes->get('activate-user/(:any)', 'Users::activateUser/$1');
 $routes->get('password-request', 'Users::linkRequestForm');
 $routes->post('password-email', 'Users::sendResetLinkEmail');
 $routes->get('password-reset/(:any)', 'Users::resetForm/$1');
 $routes->post('password/reset', 'Users::resetPassword');
 
//Rutas protegidas
 $routes->group('/', ['filter'=>'auth'], function($routes){

     $routes->get('start', 'Dashboard::index');
     
     $routes->resource('users', ['placeholder'=>'(:num)', 'except'=>'show']);

     $routes->resource('criminals', ['placeholder'=>'(:num)', 'except'=>'show']);
     
 });
 