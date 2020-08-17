<?php if (!$authorid || $userid == $authorid) : ?>
    <form action="/joke/edit" method="POST">
        <label for="text">Text of the joke:</label>
        <textarea name="joke[joketext]" cols="30" rows="10"><?= $joketext ?? '' ?></textarea>
        <input type="hidden" name="joke[id]" value="<?= $id ?? '' ?>">
        <input type="submit" value="Save">
    </form>
<?php else : ?>
    <p>You have no rights over this joke - this is not a joke!</p>
<?php endif; ?>