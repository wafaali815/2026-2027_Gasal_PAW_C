<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <style>
        body { font-family: Verdana, sans-serif; font-size: 12px; }
        fieldset { background: #d9d9ff; width: 380px; }
        .field { margin: 4px 0; }
        .field label { display: inline-block; width: 110px; text-align: right; margin-right: 8px; }
        .error { color: #b00020; }
    </style>
</head>
<body>
    <h2>Register</h2>
    <?php
    $errors = array();
    if (isset($_POST['surname']))
    {
        require 'validate.inc';
        validateName($errors, $_POST, 'surname');
        validateEmail($errors, $_POST, 'email');
        validatePassword($errors, $_POST, 'passwd');
        validateRequired($errors, $_POST, 'address');
        validateState($errors, $_POST, 'state');
        validateRequired($errors, $_POST, 'sex');

        if ($errors)
        {
            echo '<h3 class="error">Invalid, correct the following errors:</h3>';
            foreach ($errors as $field => $error)
                echo "<span class=\"error\">$field $error</span><br/>";
            echo '<br/>';

            // tampilkan kembali form (dengan isian data sebelumnya)
            echo '<fieldset><legend>Person Details</legend>';
            include 'form.inc';
            echo '</fieldset>';
        }
        else
        {
            echo 'Form submitted successfully with no errors';
        }
    }
    else
    {
        // tampilkan form kosong
        echo '<fieldset><legend>Person Details</legend>';
        include 'form.inc';
        echo '</fieldset>';
    }
    ?>
</body>
</html>
