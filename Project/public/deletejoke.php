<?php
if (isset($_POST['id'])) {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=ijdb;charset=utf8', 'pvag', 'asDeup');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = 'DELETE FROM `ijdb`.`joke` WHERE `id` = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $_POST['id']);
        $stmt->execute();

        header('location: jokes.php');
    } catch (PDOException $e) {
        $title = 'Error deleting joke! ' . $e->getMessage();
    }
} else {
    header('location: index.php');
}

include __DIR__ . '/../templates/layout.html.php';
