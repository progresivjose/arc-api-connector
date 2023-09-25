# Installation

To install the package you should run the followin command

```composer require progrevisjose/arc-api-connector:1.0```

# Usage

First you must initialize the class

```php
import GuzzleHttp\Client;

$client = new \Progresivjose\ArcApiConnector(new Client, 'ARC API SECRET TOKEN');
```

Then you can start making the requests

```php
//making a simple request
$this->client->get('https://example.test');

//passing params to the request
$this->client->get('https://example.test', ['foo' => 'bar']);

//example of post as form_params
$this->client->post('https://example.test'. ['name' => 'John', 'lastname' => 'Doe']);

//example of post as json body
$this->client->post('http://example.test', ['name' => 'John', 'lastname' => 'Doe'], 'json');

//example of post as multipart
$this->client->post('http://example.test', ['name' => 'John', 'lastname' => 'Doe'], 'multipart');
```


