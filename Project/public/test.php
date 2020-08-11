<?php
$title = 'Test - Test - Test';
try {
    include __DIR__ . '/../includes/DatabaseConnection.php';
    include __DIR__ . '/../includes/DatabaseFunctions.php';

    // function to be tested
    $data = allAuthors($pdo);

    $first = $data[0];
    ob_start();
    include __DIR__ . '/../templates/test.html.php';
    $output = ob_get_clean();
} catch (PDOException $e) {
    $output = 'Error on testing! ' . $e->getMessage();
}

include __DIR__ . '/../templates/layout.html.php';
