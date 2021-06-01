<?php

namespace Tests\Unit;

use Delights\Sage\SObjects\Contact;

class SageAccountingLoginTest extends SageAccountingBaseTest
{
    /** @test */
    public function can_update_env_tokens()
    {
        (new Contact($this->api))->all();
        $this->object = null;
    }
}
