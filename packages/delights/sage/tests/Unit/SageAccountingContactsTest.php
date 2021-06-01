<?php

namespace Tests\Unit;

use Delights\Sage\SObjects\Contact;

class SageAccountingContactsTest extends SageAccountingBaseTest
{
    /** @test */
    public function can_create_sage_contact()
    {
        $contactResource = (new Contact($this->api));

        $contacts_count  = $contactResource->count();
        $reference = str_random(10);

        $this->object = (new Contact($this->api, [
            "name"              => "Jordi",
            "reference"         => $reference,
            "contact_type_ids"  => ["CUSTOMER"],
            "main_address"      => [
                "name"              => "Main Address",
                "address_line_1"    => "C/Església nº 18",
                "address_line_2"    => "",
                "city"              => "Sant Salvador de Guardiola",
                "region"            => "Barcelona",
                "postal_code"       => "08253",
                "country_id"        => "ES"
            ], "main_contact_person"   => [
                "name"      => "Contact name",
                "telephone" => "Contact phone",
                "mobile"    => "Contact mobile",
                "email"     => "email@revo.works",
            ]
        ]))->create();

        $this->assertNotFalse($this->object->id);
        $this->assertEquals("Jordi", $this->object->name);
        $this->assertEquals($reference, $this->object->reference);
        $this->assertArraySubset(["name" => "Main Address", "country_id" => "ES"], $this->object->main_address);
        $this->assertEquals($contacts_count + 1, $contactResource->count());
    }

    /** @test */
    public function can_update_sage_contact()
    {
        $contactResource = (new Contact($this->api));
        $this->object    = (new Contact($this->api, [
            "name"             => "Jordi",
            "contact_type_ids" => ["CUSTOMER"],
        ]))->create();
        $contacts_count  = $contactResource->count();

        $this->object->update([
            "name" => "Joan",
        ]);

        var_dump($this->api->log);
        $this->assertNotFalse($this->object->id);
        $this->assertEquals("Joan", $this->object->name);
        $contact = (new Contact($this->api))->find($this->object->id);
        $this->assertEquals("Joan", $contact->name);
        $this->assertEquals($contacts_count, $contactResource->count());
    }

    /** @test */
    public function can_get_sage_contacts()
    {
        $this->object = (new Contact($this->api, [
            "name"             => "Jordi",
            "contact_type_ids" => ["CUSTOMER"],
        ]))->create();

        $this->assertGreaterThanOrEqual(1, (new Contact($this->api))->count());
    }

    /** @test */
    public function can_see_a_sage_contact()
    {
        $this->object = (new Contact($this->api, [
            "name"             => "Jordi",
            "contact_type_ids" => ["CUSTOMER"],
        ]))->create();

        $contact = (new Contact($this->api))->find($this->object->id);

        $this->assertEquals($this->object->id, $contact->id);
        $this->assertEquals('Jordi', $contact->name);
    }

    public function can_delete_sage_contact()
    {
        $this->object = (new Contact($this->api, [
            "name"             => "Jordi",
            "contact_type_ids" => ["CUSTOMER"],
        ]))->create();
        $contacts_count = (new Contact($this->api))->count();

        $this->object->destroy();
        $actual_contacts_count =  (new Contact($this->api))->count();

        $this->assertEquals($contacts_count - 1, $actual_contacts_count);
        $this->object = null;
    }

    /** @test */
    public function do_not_run_if_run_can_delete_all_sage_contacts()
    {
        (new Contact($this->api))->all()->first();
        (new Contact($this->api))->all()->each(function ($contact) {
            $contact->destroy();
        });
        $this->object = null;
    }
}
