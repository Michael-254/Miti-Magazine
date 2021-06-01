<?php

namespace Tests\Unit;

use Dotenv\Dotenv;
use Delights\Sage\Api;
use Delights\Sage\Auth;
use PHPUnit\Framework\TestCase;

abstract class SageAccountingBaseTest extends TestCase
{
    protected $object;
    protected $api;

    public function setUp()
    {
        parent::setUp();
        $this->loadEnv();
        $this->api = $this->getSageApi();
    }

    public function getSageApi()
    {
        if (! $this->api) {
            $auth = new Auth(getenv('SAGE_ACCOUNTING_CLIENT_ID'), getenv('SAGE_ACCOUNTING_CLIENT_SECRET'));
            $auth->setAuthKeys([
                "access_token"      => getenv('TEST_ACCESS_TOKEN'),
                "refresh_token"     => getenv('TEST_REFRESH_TOKEN'),
            ], [
                "country"           => getenv('TEST_COUNTRY'),
                "resource_owner_id" => getenv('TEST_RESOURCE_OWNER_ID'),
                "subscription_id"   => getenv('SAGE_ACCOUNTING_SUBSCRIPTION_ID'),
            ]);
            $this->api = new Api($auth, 'ES');
        }
        return $this->api;
    }

    public function tearDown()
    {
        if ($this->object) {
            $this->object->destroy();
        }
        if ($this->api->auth->access_token != getenv('TEST_ACCESS_TOKEN')) {
            dd("UPDATE .env tokens to access_token: {$this->api->auth->access_token} and refresh_token: {$this->api->auth->refresh_token}");
        }
        parent::tearDown();
    }

    /**
     * @return array
     */
    private function loadEnv()
    {
        return (new Dotenv(__DIR__, "../../.env"))->load();
    }
}
