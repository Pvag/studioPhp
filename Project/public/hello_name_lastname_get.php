<?php
    // example url to call this page:
    //        http://192.168.10.10/hello_name_lastname_get.php?name=Erich&lastname=Frommmmm

    $title = 'Hello Sir';

    // sanitize input!
    $name = htmlspecialchars($_GET['name'], ENT_QUOTES, 'UTF-8');
    $lastname = htmlspecialchars($_GET['lastname'], ENT_QUOTES, 'UTF-8');

    $output = '
        <h1>Values sent via HTTP \'GET\' (through the url)</h1>
        <p>
            Name and Last Name were sent from the forum, using GET
            - they appear on the url.
            You could also ask for this page with the proper url!
            Keys are: \'name\' and \'lastname\'.
        </p>
        <p>
            Hello <em>' . $name . '</em> !
            How\'s it going, Sir <em>' . $lastname . '</em> ?
        </p>
    ';

    include __DIR__ . '/../templates/structure.html.php';