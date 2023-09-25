<?php

namespace Progresivjose\ArcApiConnector;

use GuzzleHttp\Client as GuzzleHttpClient;
use Progresivjose\ArcApiConnector\Responses\JsonResponse;
use Progresivjose\ArcApiConnector\Responses\Response;
use Progresivjose\ArcApiConnector\Responses\StringResponse;
use Psr\Http\Message\ResponseInterface;

class Client
{
    private GuzzleHttpClient $httpClient;

    private String $authToken;

    public function __construct(GuzzleHttpClient $httpClient, String $authToken)
    {
        $this->httpClient = $httpClient;

        $this->authToken = $authToken;
    }

    public function get(String $url, array $params = [])
    {
        return $this->makeRequest('GET', $url, $params);
    }

    public function post(String $url, array $params = [], String $requestType = 'form_params')
    {
        return $this->makeRequest('POST', $url, $params, $requestType);
    }

    public function put(String $url, array $params = [], String $requestType = 'form_params')
    {
        return $this->makeRequest('PUT', $url, $params, $requestType);
    }

    private function makeRequest(String $method, String $url, array $params = [], String $requestType = 'query')
    {
        return $this->processResponse(
            $this->httpClient->request($method, $url, $this->getOptions($params, $requestType))
        );
    }

    private function getOptions(array $params = [], String $requestType = 'query'): array
    {
        $options = [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->authToken
            ]
        ];

        if (sizeof($params) > 0) {
            $options[$requestType] = $params;
        }

        return $options;
    }

    private function processResponse(?ResponseInterface $response)
    {
        if (!isset($response)) {
            return '';
        }

        return $this->getResponseType($response)->getData();
    }

    private function getResponseType(ResponseInterface $response): Response
    {
        $customResponse = $this->wantsJson($response) ? new JsonResponse() : new StringResponse();

        $customResponse->setData((string) $response->getBody());

        return $customResponse;
    }

    private function wantsJson(ResponseInterface $response): bool
    {
        if (!$response->hasHeader('content-type')) {
            return false;
        }

        $header = $response->getHeader('content-type')[0];

        return $header == 'application/json';
    }
}
