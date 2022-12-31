<?php

namespace Exchange;

session_start();

include('utils/AutoLoader.php');

use Resources\Php\User\{User, UserManager};
use Resources\Php\Database\DatabaseConnector;

if (isset($_SESSION['isLoggedIn'])) {
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
    <title>Login</title>
</head>

<body>
    <!-- Insert html code here -->
</body>

</html>

<script>
function redirectForm() {
    $.ajax({
        type: 'POST',
        url: 'login.php',
        data: $('.login').serialize(),
        success: function() {
            console.log('success');
        }
    });

}
</script>
<?php

    if ($_POST) {
        $usermanager = new UserManager();

        $username = $_POST['login_username'];
        $password = $_POST['login_password'];

        if ($usermanager->userExists($username, $password)) {
            $_SESSION['isLoggedIn'] = true;
            $_SESSION['username'] = $username;

            $usermanager->addUser($_SESSION['username']);
            
            echo("<script>createAlert('Success', '', 'You have succesfully logged in.', 'success', false, true, 'pageMessages');</script>");
            echo("<script>location.href = 'index.php';</script>");
            exit();
    } else
        echo ("<script>createAlert('Danger', '', 'Incorrect password or username.', 'danger', false, true, 'pageMessages');</script>");
    }
?>