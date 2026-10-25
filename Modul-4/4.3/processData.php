<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Process Data</title>
</head>
<body>
    <h3>Posted data: </h3>
    <?php
    foreach ($_POST as $key => $value)
        echo "($key) => ($value)<br/>";

    //$surname = $_POST['surname'];
    ?>
</body>
</html>
