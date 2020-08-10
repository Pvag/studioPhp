<?php
$title = 'Add Joke';
if (isset($_POST['joketext'])) {
    try {
        include __DIR__ . '/../includes/DatabaseConnection.php';

        $author = '1'; // fixed, for now
        $sql = 'INSERT INTO `joke` (`joketext`, `jokedate`, `authorid`) VALUES (:joketext, CURDATE(), ' . $author . ')';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':joketext', $_POST['joketext']);
        $stmt->execute();

        header('location: jokes.php');
    } catch (PDOException $e) {
        $output = 'Problems accessing db in \'Add Joke\'. ' . $e->getMessage();
    }
} else {
    ob_start();
    include __DIR__ . '/../templates/addjoke.html.php';
    $output = ob_get_clean();
}

include __DIR__ . '/../templates/layout.html.php';
