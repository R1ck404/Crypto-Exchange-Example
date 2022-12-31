<?php

namespace Exchange;

session_start();

include('utils/AutoLoader.php');

use Resources\Php\User\UserManager;

if (isset($_SESSION['isLoggedIn'])) { //check if the user is logged in.
    //if the user is logged in it redirects to index.php
    header('Location: ./index.php');
    die();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>
    <!-- Insert your html code here -->
</body>

</html>

<script>
function checkPassword() { //sum fancy stuff
    let origin_password = document.getElementById("register_password"); //the inserted password in the password section.
    let confirm_password = document.getElementById(
        "confirm_password"); //the inserted password in the confirm password section.

    if (confirm_password.value === origin_password.value) { //check if the password's match.
        console.log(confirm_password.value);
        console.log(origin_password.value)
        confirm_password.style.border = "solid 1px green";
    } else {
        confirm_password.style.border = "solid 1px red";
    }
}
</script>

<?php
if ($_POST) { //Check if a POST Http Request is received, and act when it is.
    $usermanager = new UserManager();

    $username = $_POST['register_username'];
    $password = $_POST['register_password'];

    if (!$usermanager->userExists($username, $password)) { //check if the user does NOT exist
        $usermanager->createUser($username, $password); //

        $_SESSION['isLoggedIn'] = true;
        $_SESSION['loggedInAs'] = $username;

        echo ("<script>createAlert('Success', '', 'You have succesfully logged in.', 'success', false, true, 'pageMessages');</script>");
        echo ("<script>location.href = 'index.php';</script>");
    }
}
?>