<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Login::index');

$routes->post('auth', 'Login::auth');

$routes->get('logout', 'Login::logout');

$routes->get('register', 'UsersRegister::index');

$routes->post('register', 'UsersRegister::create');

$routes->get('activate-user/(:any)', 'UsersRegister::activateUser/$1');

$routes->get('password-request', 'UsersRegister::linkRequestForm');

$routes->post('password-email', 'UsersRegister::sendResetLinkEmail');

$routes->get('password-reset/(:any)', 'UsersRegister::resetForm/$1');

$routes->post('password/reset', 'UsersRegister::resetPassword');


///$routes->get('home', 'Home::index');


//$routes->get('users', 'User::index');
//$routes->get('users/new', 'User::new');
$routes->resource('users', ['placeholder'=>'(:num)', 'except'=>'show']);


$routes->group('/',['filter'=>'auth'], function($routes){
    $routes->get('home', 'Home::index');
});

$routes->get('desktop', 'Dashboard::index');