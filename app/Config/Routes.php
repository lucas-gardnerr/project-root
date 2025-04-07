<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Home page route
$routes->get('/', 'MovieController::index');

// Movie routes
$routes->get('/movies', 'MovieController::index'); // Movies index page
$routes->get('/movie/viewMovie/(:num)', 'MovieController::viewMovie/$1'); // View movie details
$routes->get('/movie/addReview/(:num)', 'MovieController::addReview/$1');  // Add review page for a movie
$routes->post('/movie/saveReview/(:num)', 'MovieController::saveReview/$1'); // Save review for a movie
$routes->post('movies/search', 'MovieController::search');