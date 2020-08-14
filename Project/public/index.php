<?php


try {
    include __DIR__ . '/../classes/EntryPoint.php';
    include __DIR__ . '/../classes/IjdbActions.php';
    // controller/action
    $route = ltrim((strtok($_SERVER['REQUEST_URI'], '?')), '/') ?? 'joke/home';
    $routes = new IjdbActions();
    // an instance of the class with the routes (actions) is injected
    // into the instance of EntryPoint.
    // Now EntryPoint is a completely generic class (doesn't depend on the specific problem at hand).
    $entryPoint = new EntryPoint($route, $routes);
    $entryPoint->run();
} catch (PDOException $e) {
    $output = 'Sorry! ' . $e->getMessage();
}
