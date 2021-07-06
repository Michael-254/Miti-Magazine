<?php

namespace Delights\Sage;

use GuzzleHttp\Client;

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
    private $baseUri = 'http://desktop-g75h35c:5000/freedom.core/Delights/SDK/Rest/';

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

            return json_decode($response->getBody()->getContents());
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}
