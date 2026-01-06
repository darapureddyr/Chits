<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// =======================
// PUBLIC (LANDING)
// =======================
$routes->get('/', 'Frontend\Home::index');

// =======================
// AUTH (FRONTEND)
// =======================
$routes->get('auth', 'Frontend\Auth::index');
$routes->get('login', 'Frontend\Auth::index'); // alias
$routes->post('auth/login', 'Frontend\Auth::loginPost');
$routes->post('auth/register', 'Frontend\Auth::registerPost');
$routes->get('auth/logout', 'Frontend\Auth::logout');

// =======================
// PLANS (FRONTEND)
// =======================
$routes->get('plan/(:num)', 'Frontend\Plan::view/$1');

// =======================
// USER ENROLLMENT (FRONTEND)
// =======================
$routes->get('enroll/(:num)', 'Frontend\Enrollment::enroll/$1');
$routes->get('my-enrollments', 'Frontend\Enrollment::index');

// =======================
// ADMIN AUTH
// =======================
$routes->get('admin/login', 'Admin\Login::login');
$routes->post('admin/login-post', 'Admin\Login::loginPost');
$routes->get('admin/logout', 'Admin\Login::logout');

// =======================
// ADMIN DASHBOARD
// =======================
$routes->get('admin/dashboard', 'Admin\Dashboard::index');

// =======================
// ADMIN PLANS (CRUD + ENROLLMENTS)
// =======================
$routes->group('admin', function ($routes) {

    // Plans
    $routes->get('plans', 'Admin\Plan::index');
    $routes->post('plans/store', 'Admin\Plan::store');

    $routes->get('plans/edit/(:num)', 'Admin\Plan::edit/$1');
    $routes->post('plans/update/(:num)', 'Admin\Plan::update/$1');

    $routes->get('plans/delete/(:num)', 'Admin\Plan::delete/$1');

    // Plan enrollments
    $routes->get('plans/enrollments/(:num)', 'Admin\Enrollment::index/$1');
});

// =======================
// ADMIN CMS (PLAN PAGE CONTENT)
// =======================
$routes->get('admin/plan-page-content', 'Admin\PlanPageContent::index');
$routes->post('admin/plan-page-content/update', 'Admin\PlanPageContent::update');
