<?php if (!empty($errors)) : ?>
    <div class="errors">
        <p>Your account could not be created, please check the following:</p>
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form action="/author/register" method="POST">
    <label for="name">Name of the Joker</label>
    <input type="text" name="author[name]" value="<?= $author['name'] ?? '' ?>">
    <label for="email">e-mail</label>
    <input type="text" name="author[email]" value="<?= $author['email'] ?? '' ?>">
    <label for="password">Password</label>
    <input type="text" name="author[password]" value="<?= $author['password'] ?? '' ?>">
    <input type="submit" value="Submit">
</form>