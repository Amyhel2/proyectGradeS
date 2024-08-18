<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 $routes->get('/', 'Login::index');
 $routes->post('auth', 'Login::auth');
 $routes->get('logout', 'Login::logout');
 
 $routes->get('activate-user/(:any)', 'Users::activateUser/$1');
 $routes->get('password-request', 'Users::linkRequestForm');
 $routes->post('password-email', 'Users::sendResetLinkEmail');
 $routes->get('password-reset/(:any)', 'Users::resetForm/$1');
 $routes->post('password/reset', 'Users::resetPassword');
 
 $routes->group('/', ['filter'=>'auth'], function($routes){
    // $routes->get('home', 'Users::index');
     //$routes->get('user', 'Users::index');
     $routes->resource('users', ['placeholder'=>'(:num)', 'except'=>'show']);
     //$routes->get('init', 'Dashboard::index');  // Si 'init' requiere autenticación
 });
 