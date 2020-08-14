<style>
    #edit-link {
        margin-left: 1em;
        margin-right: 1em;
    }

    .inline {
        display: inline;
    }

    .italic {
        font-style: italic;
    }

    .centered {
        justify-content: center
    }

    .joke {
        padding-top: 1em;
        justify-content: center;
        /* background-color: aquamarine; */
    }

    hr {
        width: 50%;
    }
</style>
<p>The ijdb currently has <?= $jokesCount ?> jokes!</p>
<?php foreach ($jokes as $joke) : ?>
    <blockquote class="joke">
        <div style="display:inline;">
            <?= htmlspecialchars($joke['joketext'], ENT_QUOTES, 'UTF-8'); ?>,
            <div class="inline italic centered">
                by
                <a href="mailto:<?= $joke['email'] ?>"><?= $joke['name'] ?></a>
                on
                <?php
                $date = new DateTime($joke['jokedate']);
                echo $date->format('jS F Y');
                ?>
            </div>
        </div>
        <a id="edit-link" class="inline" href="/joke/edit?id=<?= $joke['id'] ?>&joketext=<?= $joke['joketext'] ?>">Edit</a>
        <form class="inline" action="/joke/delete" method="POST">
            <input type="hidden" name="id" value="<?= $joke['id'] ?>">
            <input type="submit" value="Delete">
        </form>
    </blockquote>
    <hr>
<?php endforeach; ?>