<?php

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Psr7\Response;
use Progresivjose\ArcApiConnector\Client;

beforeEach(function () {
    $this->mockHttpClient = Mockery::mock(GuzzleHttpClient::class);
    $this->authToken = 'TEST1234';

    $this->client = new Client($this->mockHttpClient, 'https://sandbox.site.com', $this->authToken);
});

describe("GET Requests", function () {
    test("simple request", function () {
        $this->mockHttpClient->shouldReceive("request")
            ->once()
            ->with('GET', 'https://sandbox.site.com/test', [
                'headers' => [
                    'Authorization' => 'Bearer ' .  $this->authToken
                ]
            ])
            ->andReturn(new Response(200, [], ''));

        $this->client->get('/test');
    });

    test("request with query params", function () {
        $params = ['foo' => 'bar'];

        $this->mockHttpClient->shouldReceive("request")
            ->once()
            ->with('GET', 'https://sandbox.site.com/test', [
                'headers' => [
                    'Authorization' => 'Bearer ' .  $this->authToken
                ],
                'query' => $params
            ])
            ->andReturn(new Response(200, [], ''));

        $this->client->get('/test', $params);
    });

    it("should return the data as string", function () {
        $response = new Response(200, [], 'This is my response');

        $this->mockHttpClient->shouldReceive("request")
            ->once()
            ->with('GET', 'https://sandbox.site.com/test', [
                'headers' => [
                    'Authorization' => 'Bearer ' .  $this->authToken
                ]
            ])
            ->andReturn($response);

        expect($this->client->get('/test'))->toBe("This is my response");
    });

    it("should return the data as JSON", function () {
        $response = new Response(200, ['content-type' => 'application/json'], '{"message": "This is my response"}');

        $this->mockHttpClient->shouldReceive("request")
            ->once()
            ->with('GET', 'https://sandbox.site.com/test', [
                'headers' => [
                    'Authorization' => 'Bearer ' .  $this->authToken
                ]
            ])
            ->andReturn($response);

        expect($this->client->get('/test'))->toHaveProperty('message', 'This is my response');
    });

    it("should return the data as JSON if header has chartset", function () {
        $response = new Response(200, ['content-type' => 'application/json; charset=utf-8'], '{"message": "This is my response"}');

        $this->mockHttpClient->shouldReceive("request")
            ->once()
            ->with('GET', 'https://sandbox.site.com/test', [
                'headers' => [
                    'Authorization' => 'Bearer ' .  $this->authToken
                ]
            ])
            ->andReturn($response);

        expect($this->client->get('/test'))->toHaveProperty('message', 'This is my response');
    });
});

describe("POST Requests", function () {
    it("should make the request", function () {
        $this->mockHttpClient->shouldReceive("request")
            ->once()
            ->with('POST', 'https://sandbox.site.com/test', [
                'headers' => [
                    'Authorization' => 'Bearer ' .  $this->authToken
                ]
            ])->andReturn(new Response(200, [], ''));

        $this->client->post('/test');
    });

    it("should make the request with a params as form params", function () {
        $this->mockHttpClient->shouldReceive("request")
            ->once()
            ->with('POST', 'https://sandbox.site.com/test', [
                'headers' => [
                    'Authorization' => 'Bearer ' .  $this->authToken
                ],
                'form_params' => [
                    'name' => 'John',
                    'lastname' => 'Doe'
                ]
            ])->andReturn(new Response(200, [], ''));

        $this->client->post('/test', ['name' => 'John', 'lastname' => 'Doe']);
    });

    it("should make the request with params as JSON", function () {
        $this->mockHttpClient->shouldReceive("request")
            ->once()
            ->with('POST', 'https://sandbox.site.com/test', [
                'headers' => [
                    'Authorization' => 'Bearer ' .  $this->authToken
                ],
                'json' => [
                    'name' => 'John',
                    'lastname' => 'Doe'
                ]
            ])->andReturn(new Response(200, [], ''));

        $this->client->post('/test', ['name' => 'John', 'lastname' => 'Doe'], 'json');
    });
});

describe("PUT Requests", function () {
    it("should make the request with a params as form params", function () {
        $this->mockHttpClient->shouldReceive("request")
            ->once()
            ->with('PUT', 'https://sandbox.site.com/test', [
                'headers' => [
                    'Authorization' => 'Bearer ' .  $this->authToken
                ],
                'form_params' => [
                    'name' => 'John',
                    'lastname' => 'Doe'
                ]
            ])->andReturn(new Response(200, [], ''));

        $this->client->put('/test', ['name' => 'John', 'lastname' => 'Doe']);
    });

    it("should make the request with params as JSON", function () {
        $this->mockHttpClient->shouldReceive("request")
            ->once()
            ->with('PUT', 'https://sandbox.site.com/test', [
                'headers' => [
                    'Authorization' => 'Bearer ' .  $this->authToken
                ],
                'json' => [
                    'name' => 'John',
                    'lastname' => 'Doe'
                ]
            ])->andReturn(new Response(200, [], ''));

        $this->client->put('/test', ['name' => 'John', 'lastname' => 'Doe'], 'json');
    });
});

describe("DELETE Requests", function () {
    it("should make the request", function () {
        $this->mockHttpClient->shouldReceive("request")
            ->once()
            ->with('DELETE', 'https://sandbox.site.com/test', [
                'headers' => [
                    'Authorization' => 'Bearer ' .  $this->authToken
                ]
            ])->andReturn(new Response(200, [], ''));

        $this->client->delete('/test');
    });
});
