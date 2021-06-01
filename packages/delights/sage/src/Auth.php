<?php

namespace Delights\Sage;

class Auth extends \Delights\SageApi\Auth
{
    public $country             = 'es';
    public $resource_owner_id   = '';
    public $subscription_id     = '';
    protected $authUrl          = "https://www.sageone.com/oauth2/auth/central";
    private $tokenUrls          = [
        "CA" => "https://oauth.na.sageone.com/token",
        "DE" => "https://oauth.eu.sageone.com/token",
        "ES" => "https://oauth.eu.sageone.com/token",
        "FR" => "https://oauth.eu.sageone.com/token",
        "GB" => "https://app.sageone.com/oauth2/token",
        "IE" => "https://app.sageone.com/oauth2/token",
        "US" => "https://oauth.na.sageone.com/token",
    ];

    public function __construct($client_id, $client_secret)
    {
        parent::__construct($client_id, $client_secret);
        $this->setTokenUrl();
    }

    public function loginCallback($redirect_uri, $code)
    {
        $this->country = request('country', 'GB');
        $this->setTokenUrl();
        return parent::loginCallback($redirect_uri, $code);
    }

    public function getAuthHeaders()
    {
        return array_merge(parent::getAuthHeaders(), [
            "X-Site"                    => $this->resource_owner_id,
            "ocp-apim-subscription-key" => $this->subscription_id
        ]);
    }

    private function setTokenUrl()
    {
        $this->tokenUrl = $this->tokenUrls[strtoupper($this->country)];
    }
}
