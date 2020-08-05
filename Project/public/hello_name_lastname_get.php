<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello Sir</title>
</head>
<body>
    <!-- example url to call this page:
            http://192.168.10.10/hello_name_lastname_get.php?name=Erich&lastname=Frommmmm -->
    <h1>Values sent via HTTP 'GET' (through the url)</h1>
    <p>
        Name and Last Name are sent directly from the url.
        Ask for this page with the proper url!
        Keys are: 'name' and 'lastname'.
    </p>
    <p>
        <?php
            $name = htmlspecialchars($_GET['name'], ENT_QUOTES, 'UTF-8');
            $lastname = htmlspecialchars($_GET['lastname'], ENT_QUOTES, 'UTF-8');
        ?>
        Hello <em><?=$name?></em> !
        How's it going, Sir <em><?php echo $lastname?></em> ?
    </p>
</body>
</html>