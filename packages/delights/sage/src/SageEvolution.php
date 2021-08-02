<?php

namespace Delights\Sage;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;

/**
 * Class Cashier.
 *
 * @category PHP
 * @author   Evans Wanguba <ewanguba@gmail.com>
 */
class SageEvolution
{
    /**
     * The base URI to be called.
     *
     * @var string
     */
    private $baseUri = 'http://107.180.88.92:5000/freedom.core/Demo/SDK/Rest/';
    private $baseUriBackUp = 'http://197.232.244.211:5000/freedom.core/Better Globe Forestry Ltd NEW/SDK/Rest/';

    /**
     * The Guzzle HTTP Client.
     *
     * @var Client
     */
    private $client;

    /**
     * Cashier constructor.
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUri,
            'auth' => [
                env('SAGE_CLIENT_ID'), 
                env('SAGE_CLIENT_SECRET')
            ]
        ]);
    }

    /**
     * Initiate a get request and send the information to Sage.
     *
     * @return string
     */
    public function getTransaction($initiateEndpoint)
    {
        try {
            $response = $this->client->request('GET', $initiateEndpoint);

            $statuscode = $response->getStatusCode();
            if (404 === $statuscode || 523 === $statuscode) {
                $this->client = new Client([
                    'base_uri' => $this->baseUriBackUp,
                    'auth' => [
                        env('SAGE_CLIENT_ID'), 
                        env('SAGE_CLIENT_SECRET')
                    ]
                ]);
                
                $response = $this->client->request('GET', $initiateEndpoint);
            }

            return $response->getBody()->getContents();
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * Initiate a post request and send the information to Sage.
     *
     * @return string
     */
    public function postTransaction($initiateEndpoint, $params)
    {
        try {
            $response = $this->client->request('POST', $initiateEndpoint, [
                'json' => $params
            ]);

            $statuscode = $response->getStatusCode();
            if (404 === $statuscode || 523 === $statuscode) {
                $this->client = new Client([
                    'base_uri' => $this->baseUriBackUp,
                    'auth' => [
                        env('SAGE_CLIENT_ID'), 
                        env('SAGE_CLIENT_SECRET')
                    ]
                ]);
                
                $response = $this->client->request('POST', $initiateEndpoint, [
                    'json' => $params
                ]);
            }

            return json_decode($response->getBody()->getContents());
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}
