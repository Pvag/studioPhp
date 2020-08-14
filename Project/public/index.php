<?php

include __DIR__ . '/../classes/EntryPoint.php';

try {
    // controller/action
    $route = ltrim((strtok($_SERVER['REQUEST_URI'], '?')), '/') ?? 'joke/home';
    $entryPoint = new EntryPoint($route);
    $entryPoint->run();
} catch (PDOException $e) {
    $output = 'Sorry! ' . $e->getMessage();
}
