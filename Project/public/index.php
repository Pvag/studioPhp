<?php
    $title = 'Introductory';

    $output = '
        <h1>Sends values via HTTP GET</h1>
        <h2>Explanations about this branch</h2>
        <p>
            This project has an \'index.php\' file that is called first (this page);
            it sends its title and content (the form with inputs name
            and lastname) to a main template with the structure. The template
            is using \'Skeleton\' to put on a little bit of style.
        </p>
        <p>
            After the form is sent, the page with the greeting is loaded:
            the input is sanitized and the main template is called again,
            this time with a different title and content. The style is
            provided through the main template, so I don\'t need to take
            care of it anymore!
        </p>
        <p>
            The problem with this implementation is that I have 2 controllers
            and 1 template: the user can bookmark the greeting page, which is
            something I don\'t want. What I will implement in the \'next\' branch
            (follow the numbering) is to only have a Single Controller, found at
            \'index.php\' that decides what to show to the user: if the page was
            just requested, show the form; if the form was sent, greet the user.
        </p>
        <p>
            I will send the request via POST. I will also use Output Buffer,
            since I will have to include twice: first the template with the
            form or the greet; then the main template, that contains the
            large part of HTML code for the entire web page.
        </p>
        <p>
            Fill the form and press enter, lovely
        </p>
        <form action="hello_name_lastname_get.php" method="GET">
            <label for="name">Name:</label>
            <input type="text" name="name">
            <label for="lastname">Last Name:</label>
            <input type="text" name="lastname">
            <input type="submit" value="Send!">
        </form>';
    
    include __DIR__ . '/../templates/structure.html.php';