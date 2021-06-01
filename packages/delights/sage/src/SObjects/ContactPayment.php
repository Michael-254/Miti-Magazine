<?php

namespace Delights\Sage\SObjects;

use Delights\Sage\SObject;

class ContactPayment extends SObject
{
    const RESOURCE_NAME = "contact_payments";

    protected $fields   = [
        "transaction_type_id"   => ["required" => true, "type" => "string()"            ],
        "contact_id"            => ["required" => true, "type" => "string(date)"        ],
        "bank_account_id"       => ["required" => true, "type" => "object"               ],
        "date"                  => ["required" => true, "type" => "object"               ],
        "total_amount"          => ["required" => true, "type" => "object"               ],
        "allocated_artefacts"   => ["required" => true, "type" => "object"               ],
    ];
}
