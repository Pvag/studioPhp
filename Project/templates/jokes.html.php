<?php foreach ($result as $joke) : ?>
    <blockquote>
        <p style="display:inline">
            <?= $joke['joketext']; ?>, by
            <a href="mailto:<?= $joke['email'] ?>"><?= $joke['name'] ?></a>
        </p>
        <form action="deletejoke.php" method="POST">
            <input type="hidden" name="id" value="<?= $joke['id'] ?>">
            <input type="submit" value="Delete">
        </form>
    </blockquote>
<?php endforeach; ?>