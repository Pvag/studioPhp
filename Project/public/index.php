<?php

try {
    include __DIR__ . '/../includes/autoloader.php';
    $route = ltrim((strtok($_SERVER['REQUEST_URI'], '?')), '/') ?? 'joke/home'; // route is formed by 'controller/action'
    $method = $_SERVER['REQUEST_METHOD'];
    // an instance of the class with the routes (actions) is injected
    // into the instance of EntryPoint.
    // Now EntryPoint is a completely generic class (doesn't depend on the specific problem at hand).
    $entryPoint = new \Ninja\EntryPoint($route, $method, new \Ijdb\IjdbRoutes());
    $entryPoint->run();
} catch (PDOException $e) {
    $output = 'Sorry! ' . $e->getMessage();
}
