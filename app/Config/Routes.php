<?php

use CodeIgniter\Router\RouteCollection;

$routes->get('/', 'Pages::index');
$routes->get('tasks', 'Tasks::index');
$routes->get('profile', 'Profile::index');
$routes->get('about', 'Pages::about');

$routes->get('customers', 'Customers::index');
$routes->get('users', 'Users::index');
