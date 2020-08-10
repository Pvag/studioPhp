<?php
if (isset($_POST['id'])) {
    try {
        include __DIR__ . '/../includes/DatabaseConnection.php';

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
