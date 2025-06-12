<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('support', 'Support\Dashboard::index');
$routes->get('support/groups-scales', 'Support\GroupsScales::index');
$routes->post('support/groups-scales/list', 'Support\GroupsScales::list');
$routes->match(['get', 'post'], 'support/groups-scales/create', 'Support\GroupsScales::create');
$routes->match(['get', 'post'], 'support/groups-scales/edit/(:any)', 'Support\GroupsScales::edit/$1');
$routes->get('support/groups-scales/detail/(:any)', 'Support\GroupsScales::detail/$1');
$routes->match(['get', 'delete'], 'support/groups-scales/delete/(:any)', 'Support\GroupsScales::delete/$1');
$routes->patch('support/groups-scales/restore/(:any)', 'Support\GroupsScales::restore/$1');
// $routes->post('support/questions/import/list-question-tmp', 'Support/Questions::questionTmp');
$routes->post('support/import/(:any)', 'Support\Import::index');
$routes->get('support/questions/import/save', 'Support\Questions::saveImport');
$routes->add('support/classes', 'Support\Classes::index');
$routes->add('support/classes/list', 'Support\Classes::list');
$routes->add('support/classes/create', 'Support\Classes::create');
$routes->add('support/classes/edit/(:any)', 'Support\Classes::edit/$1');
$routes->add('support/classes/detail/(:any)', 'Support\Classes::detail/$1');
$routes->add('support/classes/delete/(:any)', 'Support\Classes::delete/$1');
$routes->add('support/classes/users/(:any)', 'Support\Classes::users/$1');
$routes->add('support/classes/listusers/(:any)', 'Support\Classes::listusers/$1');
$routes->add('support/classes/getusersnot/(:any)', 'Support\Classes::getusersnot/$1');
$routes->add('support/classes/setusers/(:any)', 'Support\Classes::setusers/$1');
$routes->add('support/classes/deleteuser/(:any)', 'Support\Classes::deleteuser/$1');
$routes->add('support/classes/tests/(:any)', 'Support\Classes::tests/$1');
$routes->add('support/classes/listtests/(:any)', 'Support\Classes::listtests/$1');
$routes->add('support/classes/gettestsnot/(:any)', 'Support\Classes::gettestsnot/$1');
$routes->add('support/classes/settests/(:any)', 'Support\Classes::settests/$1');
$routes->add('support/classes/deletetest/(:any)', 'Support\Classes::deletetest/$1');

$routes->get('class', 'ClassController::index', ['filter' => 'login']);
$routes->get('class/(:any)', 'ClassController::detail/$1', ['filter' => 'login']);
$routes->match(['get', 'post'], 'order', 'Accounts::order', ['filter' => 'login']);
$routes->add('autocomplete/(:any)', 'Autocomplete::index', ['filter' => 'login']);

$routes->get('result/(:any)', 'Result::index/$1');

$routes->group('api/v1', ['namespace' => 'App\Controllers\Api\V1'], function ($routes) {
	$routes->group('client', ['namespace' => 'App\Controllers\Api\V1\Client'], function ($routes) {
		$routes->resource('room', ['only' => ['show']]);
		$routes->get('test/list', 'Test::list');
	});
	$routes->resource('question');
	$routes->resource('answer');
	$routes->get('test/do/(:any)', 'Test::do/$1');
	$routes->get('test/listbyclient', 'Test::listByClient');
	$routes->post('test/answer', 'Test::answer');
	$routes->resource('test', ['only' => ['show']]);
});

$routes->group('api/v2', ['namespace' => 'App\Controllers\Api\V2'], function ($routes) {
	$routes->group('list', function ($routes) {
		$routes->get('dashboard', 'Lists::dashboard');
		$routes->get('class', 'Lists::class');
		$routes->get('test', 'Lists::test');
		$routes->post('search', 'Lists::search');
	});
	$routes->group('test', function ($routes) {
		$routes->get('instruction', 'Test::instruction');
		$routes->get('do/(:any)', 'Test::do/$1');
		$routes->post('answer', 'Test::answer');
	});
	$routes->group('application', function ($routes) {
		$routes->get('configuration', 'Configuration::getConfiguration');
	});
});

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
