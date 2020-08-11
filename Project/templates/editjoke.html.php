<form action="" method="POST">
    <label for="text">Text of the joke:</label>
    <textarea name="joketext" cols="30" rows="10"><?= $joketext ?? '' ?></textarea>
    <input type="hidden" name="id" value="<?= $id ?? '' ?>">
    <input type="submit" value="Save">
</form>