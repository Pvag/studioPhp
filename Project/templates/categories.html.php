<h3>Categories</h3>
<a href="/category/edit">Add a new Category</a>
<?php foreach ($categories as $category) : ?>
    <blockquote>
        <p>
            <?= htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
            <a href="/category/edit?category[id]=<?= $category->id ?>">Edit</a>
            <form action="/category/delete" method="POST">
                <input type="hidden" name="category[id]" value="<?= $category->id ?>">
                <input type="submit" value="Delete">
            </form>
        </p>
    </blockquote>
<?php endforeach; ?>