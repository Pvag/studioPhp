<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Introductory</title>
</head>
<body>
    <h1>Sends values via HTTP GET</h1>
    <p>
        Fill the form and press enter, lovely
    </p>
    <form action="hello_name_lastname_get.php" method="GET">
        <label for="name">Name:</label>
        <input type="text" name="name">
        <label for="lastname">Last Name:</label>
        <input type="text" name="lastname">
        <input type="submit" value="Send!">
    </form>
</body>
</html>