<?php

try {
    include __DIR__ . '/../includes/autoloader.php';
    // controller/action
    $route = ltrim((strtok($_SERVER['REQUEST_URI'], '?')), '/') ?? 'joke/home';
    $routes = new \Ijdb\IjdbRoutes();
    // an instance of the class with the routes (actions) is injected
    // into the instance of EntryPoint.
    // Now EntryPoint is a completely generic class (doesn't depend on the specific problem at hand).
    $entryPoint = new \Ninja\EntryPoint($route, $routes);
    $entryPoint->run();
} catch (PDOException $e) {
    $output = 'Sorry! ' . $e->getMessage();
}
