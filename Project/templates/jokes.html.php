<p>The ijdb currently has <?= $jokesCount ?> jokes!</p>
<?php foreach ($result as $joke) : ?>
    <blockquote>
        <p style="display:inline">
            <?= htmlspecialchars($joke['joketext'], ENT_QUOTES, 'UTF-8'); ?>, by
            <a href="mailto:<?= $joke['email'] ?>"><?= $joke['name'] ?></a>
        </p>
        <a href="editjoke.php?id=<?= $joke['id'] ?>&joketext=<?= $joke['joketext'] ?>">Edit</a>
        <form action="deletejoke.php" method="POST">
            <input type="hidden" name="id" value="<?= $joke['id'] ?>">
            <input type="submit" value="Delete">
        </form>
    </blockquote>
<?php endforeach; ?>