<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/', 'ProductController::index');
$routes->post('/order/create', 'OrderController::create');
$routes->get('/checkout/(:num)', 'OrderController::checkout/$1');
$routes->get('/payment/success', 'PaymentController::success');
$routes->get('/payment/error', 'PaymentController::error');
$routes->get('/orders', 'OrderController::myOrders'); // View all orders
$routes->get('/order/details/(:num)', 'OrderController::orderDetails/$1'); // View details of a specific order