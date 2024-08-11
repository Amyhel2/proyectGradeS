<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');
$routes->get('/', 'Login::index');
$routes->get('register', 'Users::index');
$routes->post('register', 'Users::create');
$routes->get('activate-user/(:any)', 'Users::activateUser/$1');
