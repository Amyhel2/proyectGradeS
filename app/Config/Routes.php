<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Login::index');
$routes->post('auth', 'Login::auth');
$routes->get('logout', 'Login::logout');
$routes->get('register', 'Users::index');
$routes->post('register', 'Users::create');
$routes->get('activate-user/(:any)', 'Users::activateUser/$1');

$routes->get('password-request', 'Users::linkRequestForm');

$routes->post('password-email', 'Users::sendResetLinkEmail');

$routes->get('password-reset/(:any)', 'Users::resetForm/$1');

$routes->post('password/reset', 'Users::resetPassword');

///$routes->get('home', 'Home::index');

$routes->group('/',['filter'=>'auth'], function($routes){
    $routes->get('home', 'Home::index');
});