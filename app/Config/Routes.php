<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Frontend\\Home::index');
$routes->post('contact', 'Frontend\\MessageController::store');
$routes->get('sitemap.xml', 'Sitemap::index');
$routes->get('lang/(:segment)', 'Language::switch/$1');
$routes->get('aktivitas', 'Frontend\\Sections::activities');
$routes->get('biodata', 'Frontend\\Sections::biodata');
$routes->get('pendidikan', 'Frontend\\Sections::educations');
$routes->group('api', ['namespace' => 'App\\Controllers\\Api'], static function (RouteCollection $routes) {
    $routes->get('portfolio/activities', 'Portfolio::activities');
    $routes->get('portfolio/biodata', 'Portfolio::biodata');
    $routes->get('portfolio/educations', 'Portfolio::educations');
    $routes->get('portfolio/projects', 'Portfolio::projects');
    $routes->get('portfolio/skills', 'Portfolio::skills');
});

$routes->group('admin', ['namespace' => 'App\\Controllers\\Admin'], static function (RouteCollection $routes) {
    $routes->get('login', 'AuthController::login', ['filter' => 'guest']);
    $routes->post('login', 'AuthController::attempt', ['filter' => 'guest']);
    $routes->get('register', 'AuthController::register', ['filter' => 'guest']);
    $routes->post('register', 'AuthController::store', ['filter' => 'guest']);
    $routes->get('logout', 'AuthController::logout');
});

$routes->group('admin', ['namespace' => 'App\\Controllers\\Admin', 'filter' => 'auth'], static function (RouteCollection $routes) {
    $routes->get('/', 'Dashboard::index');
    $routes->get('dashboard', 'Dashboard::index');

    $routes->get('projects', 'Projects::index');
    $routes->get('projects/create', 'Projects::create');
    $routes->post('projects', 'Projects::store');
    $routes->get('projects/(:num)/edit', 'Projects::edit/$1');
    $routes->post('projects/(:num)', 'Projects::update/$1');
    $routes->post('projects/(:num)/delete', 'Projects::delete/$1');

    $routes->get('activities', 'Activities::index');
    $routes->get('activities/create', 'Activities::create');
    $routes->post('activities', 'Activities::store');
    $routes->get('activities/export/(:alpha)', 'Activities::export/$1');
    $routes->get('activities/(:num)/edit', 'Activities::edit/$1');
    $routes->post('activities/(:num)', 'Activities::update/$1');
    $routes->get('activities/(:num)/delete', 'Activities::delete/$1');
    $routes->post('activities/bulk-delete', 'Activities::bulkDelete');
    $routes->get('search', 'Search::live');

    $routes->get('skills', 'Skills::index');
    $routes->get('skills/create', 'Skills::create');
    $routes->post('skills', 'Skills::store');
    $routes->get('skills/(:num)/edit', 'Skills::edit/$1');
    $routes->post('skills/(:num)', 'Skills::update/$1');
    $routes->post('skills/(:num)/delete', 'Skills::delete/$1');

    $routes->get('experiences', 'Experiences::index');
    $routes->get('experiences/create', 'Experiences::create');
    $routes->post('experiences', 'Experiences::store');
    $routes->get('experiences/(:num)/edit', 'Experiences::edit/$1');
    $routes->post('experiences/(:num)', 'Experiences::update/$1');
    $routes->post('experiences/(:num)/delete', 'Experiences::delete/$1');

    $routes->get('educations', 'Educations::index');
    $routes->get('educations/create', 'Educations::create');
    $routes->post('educations', 'Educations::store');
    $routes->get('educations/(:num)/edit', 'Educations::edit/$1');
    $routes->post('educations/(:num)', 'Educations::update/$1');
    $routes->get('educations/(:num)/delete', 'Educations::delete/$1');

    $routes->get('settings', 'Settings::index');
    $routes->post('settings', 'Settings::update');

    $routes->get('profile', 'Profile::index');
    $routes->post('profile', 'Profile::update');
    $routes->get('profile/backup', 'Profile::backup');
    $routes->post('profile/restore', 'Profile::restore');

    $routes->get('messages', 'Messages::index');
    $routes->get('messages/(:num)', 'Messages::show/$1');
    $routes->post('messages/(:num)/delete', 'Messages::destroy/$1');
    $routes->get('activity-logs', 'ActivityLogs::index');
    $routes->get('backups', 'Backups::index');
    $routes->get('backups/generate', 'Backups::generate');
    $routes->get('backups/download/(:segment)', 'Backups::download/$1');
});
