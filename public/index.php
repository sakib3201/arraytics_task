<?php

require_once '../autoload.php';

use App\Controllers\SubmissionController;


$controller = new SubmissionController();

require_once '../routes/web.php';

// Handle the request
$uri = str_replace('/public', '', $_SERVER['REQUEST_URI']);
$router->dispatch($uri);

?>