<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('home', 'Home::index');
$routes->get('about', 'Home::about');
$routes->get('contact', 'Home::contact');

// Authentication Routes
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::register');

// Dashboard Routes for all users
$routes->get('/dashboard', 'Auth::dashboard');

// AJAX enrollment route
$routes->post('/course/enroll', 'Course::enroll');

 // header routes
$routes->get('/admin/courses', 'Course::adminCourses');
$routes->get('/teacher/classes', 'Course::teacherClasses');

// Material management
$routes->get('/materials/course/(:num)', 'Materials::index/$1');
$routes->get('/materials/upload/(:num)', 'Materials::uploadForm/$1');
$routes->post('/materials/upload', 'Materials::upload');
$routes->get('/materials/delete/(:num)', 'Materials::delete/$1');
$routes->get('/materials/download/(:num)', 'Materials::download/$1');



$routes->setAutoRoute(true);