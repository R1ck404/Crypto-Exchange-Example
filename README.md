__Quick note, the code isnt perfect.__

# Crypto Exchange Example

This project is a Crypto Exchange Example written in PHP. It is a small, flexible, and extensible application that allows users to easily add and work with different exchanges. The project includes the Binance exchange as an example, but other exchanges can easily be added as well. Whether you are a beginner or an experienced developer, this project is a great resource for learning about and building your own crypto exchange. Its easy-to-use design makes it simple to work with and edit, so you can quickly get up and running with your own exchange. Whether you want to integrate a single exchange or multiple exchanges, this project has you covered.


## Features

- Users
- Password Encryption & Decryption.
- Exchange Sockets
- Different Exchanges


## FAQ

#### Is this a fully ready crypto exchange?

Sadly, no. This is just a small example of a crypto exchange.

#### Does this project include frontend?

No it does not. This project is mainly backend, there are a few small frontend examples.


## Usage/Examples
### Create an user 
```php
$usermanager = new UserManager();
$usermanager->createUser('username', 'password');
```

### Get an user 
```php
$usermanager = new UserManager();
$usermanager->getUser('username');
```
## How to add a custom exchange?

Go to Resources/php/Exchange/exchanges

```bash
Create a file named ExchangeName.php
```

Then
```php
Add the namespace, and import the Exchange file.

<?php

namespace Resources\Php\Exchange\exchanges;

use Resources\Php\Exchange\Exchange;

<?php
```

Then
```php
Create the class, add the construct and the getEndPoints function.

<?php

namespace Resources\Php\Exchange\exchanges;

use Resources\Php\Exchange\Exchange;

class ExchangeName extends Exchange {

    public function __construct(string $apiKey, string $apiSecret)
    {
        $this->setEndPoints([
            "api" => "https://api.exchange.com", // Dont leave empty
            "api1" => "https://api1.exchange.com", // can be left empty
            "api2" => "https://api2.exchange.com", // can be left empty
            "api3" => "https://api3.exchange.com", // can be left empty

            "spot-trading" => "/api/v3/", //spot endpoint
            "futures" => "/sapi/v1/futures/", //futures endpoint
            "futures-algo" => "/sapi/v1/algo/futures/", //futures algo endpoint
            "fiat" => "/sapi/v1/fiat/", //fiat endpoint
            "margin" => "/sapi/v1/margin/", //margin endpoint
            "nft" => "/sapi/v1/nft/", //nft endpoint

            "market" => "/api/v3/", //market endpoint
            "wallet" => "/sapi/v1/", //wallet endpoint
            "sub-account" => "/sapi/v1/sub-account/", //sub-acc endpoint

            "mining" => "/sapi/v1/mining/", //mining endpoint
            "staking" => "/sapi/v1/staking/", //staking endpoint
            "saving" => "/sapi/v1/lending/" //saving endpoint
        ]);

        $this->apiKey = $apiKey; //The users api key.
        $this->apiSecret = $apiSecret; //The users api secret.

        parent::__construct($apiKey, $apiSecret);
    }

    public function getEndPoints(): array
    {
        return $this->endPoints;
    }
}

?>
```
## License

[APACHE-2.0](https://www.apache.org/licenses/LICENSE-2.0)


## Support

Im not sure if i will continue to work on this project, but if people want me to i will probaly continue.
For private support, Contact me via discord Rick404#8294.
