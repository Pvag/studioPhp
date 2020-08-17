<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/skeleton/2.0.4/skeleton.min.css" integrity="sha512-EZLkOqwILORob+p0BXZc+Vm3RgJBOe1Iq/0fiI7r/wJgzOFZMlsqTa29UEl6v6U6gsV4uIpsNZoV32YZqrCRCQ==" crossorigin="anonymous" />
    <link rel="stylesheet" href="/css/style.css">
    <title><?= $title ?></title>
</head>

<body>
    <div class="container">
        <nav class="navbar">
            <div class="container">
                <ul class="navbar-list">
                    <li class="navbar-item two columns"><a class="navbar-link" href="/joke/home">Home</a></li>
                    <li class="navbar-item two columns"><a class="navbar-link" href="/joke/list">Jokes List</a></li>
                    <li class="navbar-item two columns"><a class="navbar-link" href="/joke/edit">Add Joke</a></li>
                    <?php if (!$loggedin) : ?>
                        <li><a href="/login">Login</a></li>
                    <?php else : ?>
                        <li><a href="/logout">Logout</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
        <section class="header">
            <h2 class="title">The Internet Jokes Database</h2>
        </section>
        <?= $output ?>
    </div>
</body>

</html>