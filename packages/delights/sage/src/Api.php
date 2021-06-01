<?php

namespace Delights\Sage;

use Zttp\ZttpResponse;

class Api extends \Delights\SageApi\Api
{
    const PATCH_METHOD = 'put';
    private $country;
    private $countries = [
        "CA"    => "ca",
        "DE"    => "de",
        "ES"    => "es",
        "FR"    => "fr",
        "GB"    => "uki",
        "IE"    => "uki",
        "US"    => "us",
    ];

    public function __construct(Auth $auth, $country = 'ES')
    {
        parent::__construct($auth);
        $this->country = $this->countries[$this->country] ?? 'es';
    }

    protected function urlForResource($resource)
    {
        return "https://api.columbus.sage.com/{$this->country}/sageone/accounts/v3/{$resource}";
    }

    protected function urlForQueries()
    {
        return "https://api.columbus.sage.com/{$this->country}/sageone/accounts/v3/";
    }

    public function get($resource, $query = null, $fields = [])
    {
        $response = $this->call('get', $this->urlForQueries() . $resource . ( $query ? "?{$query}" : "" ));
        return $response instanceof ZttpResponse ? $response->json() : null;
    }
}
