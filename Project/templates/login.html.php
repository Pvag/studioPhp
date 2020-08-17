<?php if (isset($error)) : ?>
    <p class="errors">Error: <?= $error ?></p>
<?php endif; ?>
<form action="/login" method="POST">
    <label for="username">e-mail</label>
    <input type="text" name="username">
    <label for="password">password</label>
    <input type="text" name="password">
    <input type="submit" value="Submit">
</form>