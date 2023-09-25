<?php

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Psr7\Response;
use Progresivjose\ArcApiConnector\Client;

beforeEach(function () {
    $this->mockHttpClient = Mockery::mock(GuzzleHttpClient::class);
    $this->authToken = 'TEST1234';

    $this->client = new Client($this->mockHttpClient, $this->authToken);
});

it("should make a simple GET request", function () {
    $this->mockHttpClient->shouldReceive("request")
        ->once()
        ->with('GET', 'http://testing.test', [
            'headers' => [
                'Authorization' => 'Bearer ' .  $this->authToken
            ]
        ]);

    $this->client->get('http://testing.test');
});

it("should make a GET request with query params", function () {
    $params = ['foo' => 'bar'];

    $this->mockHttpClient->shouldReceive("request")
        ->once()
        ->with('GET', 'http://testing.test', [
            'headers' => [
                'Authorization' => 'Bearer ' .  $this->authToken
            ],
            'query' => $params
        ]);

    $this->client->get('http://testing.test', $params);
});

it("should return the data as string", function () {
    $response = new Response(200, [], 'This is my response');

    $this->mockHttpClient->shouldReceive("request")
       ->once()
       ->with('GET', 'http://testing.test', [
           'headers' => [
               'Authorization' => 'Bearer ' .  $this->authToken
           ]
       ])
       ->andReturn($response);

    expect($this->client->get('http://testing.test'))->toBe("This is my response");
});

it("should return the data as JSON", function () {
    $response = new Response(200, ['content-type' => 'application/json'], '{"message": "This is my response"}');

    $this->mockHttpClient->shouldReceive("request")
       ->once()
       ->with('GET', 'http://testing.test', [
           'headers' => [
               'Authorization' => 'Bearer ' .  $this->authToken
           ]
       ])
       ->andReturn($response);

    expect($this->client->get('http://testing.test'))->toBeObject((object) [
        'message' => 'This is my response'
    ]);
});

it("should make a POST request", function () {
    $this->mockHttpClient->shouldReceive("request")
        ->once()
        ->with('POST', 'http://testing.test', [
            'headers' => [
                'Authorization' => 'Bearer ' .  $this->authToken
            ]
        ]);

    $this->client->post('http://testing.test');
});

it("should make a POST request with a params as form params", function () {
    $this->mockHttpClient->shouldReceive("request")
        ->once()
        ->with('POST', 'http://testing.test', [
            'headers' => [
                'Authorization' => 'Bearer ' .  $this->authToken
            ],
            'form_params' => [
                'name' => 'John',
                'lastname' => 'Doe'
            ]
        ]);

    $this->client->post('http://testing.test', ['name' => 'John', 'lastname' => 'Doe']);
});

it("should make a POST request with params as JSON", function () {
    $this->mockHttpClient->shouldReceive("request")
        ->once()
        ->with('POST', 'http://testing.test', [
            'headers' => [
                'Authorization' => 'Bearer ' .  $this->authToken
            ],
            'json' => [
                'name' => 'John',
                'lastname' => 'Doe'
            ]
        ]);

    $this->client->post('http://testing.test', ['name' => 'John', 'lastname' => 'Doe'], 'json');
});

it("should make a PUT request with a params as form params", function () {
    $this->mockHttpClient->shouldReceive("request")
        ->once()
        ->with('PUT', 'http://testing.test', [
            'headers' => [
                'Authorization' => 'Bearer ' .  $this->authToken
            ],
            'form_params' => [
                'name' => 'John',
                'lastname' => 'Doe'
            ]
        ]);

    $this->client->put('http://testing.test', ['name' => 'John', 'lastname' => 'Doe']);
});

it("should make a PUT request with params as JSON", function () {
    $this->mockHttpClient->shouldReceive("request")
        ->once()
        ->with('PUT', 'http://testing.test', [
            'headers' => [
                'Authorization' => 'Bearer ' .  $this->authToken
            ],
            'json' => [
                'name' => 'John',
                'lastname' => 'Doe'
            ]
        ]);

    $this->client->put('http://testing.test', ['name' => 'John', 'lastname' => 'Doe'], 'json');
});