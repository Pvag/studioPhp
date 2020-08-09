<?php foreach ($result as $joke) : ?>
    <blockquote>
        <p style="display:inline">
            <?= $joke['joketext']; ?>
        </p>
        <form action="deletejoke.php" method="POST">
            <input type="hidden" name="id" value="<?= $joke['id'] ?>">
            <input type="submit" value="Delete">
        </form>
    </blockquote>
<?php endforeach; ?>