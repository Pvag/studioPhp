<?php foreach ($result as $joke) : ?>
    <blockquote>
        <p>
            <?= $joke['joketext']; ?>
        </p>
    </blockquote>
<?php endforeach; ?>