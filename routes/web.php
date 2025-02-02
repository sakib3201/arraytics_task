<?php
use Core\Router;
$router = new Router();

$router->get('/', 'App\Controllers\SubmissionController@index');
$router->post('/submit', 'App\Controllers\SubmissionController@submitForm');
$router->get('/report', 'App\Controllers\SubmissionController@showSubmissions');