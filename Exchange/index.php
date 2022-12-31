<?php

namespace Exchange;

use PDO;
use Resources\Php\Exchange\exchanges\Binance;
use Resources\Php\Exchange\Sockets\BinanceSocket;

session_start();

include('login-check.php');

include('utils/AutoLoader.php');

use Resources\Php\User\{User, UserManager};
use Resources\Php\Database\DatabaseConnector;
use Resources\Php\Exchange\Sockets\ExchangeSocket;

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trading Exchange</title>
</head>

<body>
    <!-- Insert html code here -->
</body>

</html>