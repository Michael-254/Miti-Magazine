<?php

namespace Delights\Sage\SObjects;

use Delights\Sage\Validators\Validator;
use Delights\Sage\SObject;

class Contact extends SObject
{
    const RESOURCE_NAME = "contacts";
    protected $fields   = [
        "name"                              => ["required" => true, "type" => "string()"            ],
        "contact_type_ids"                  => ["required" => true, "type" => "array"               ],
        "transaction_id"                    => ["required" => false, "type" => "string()"           ],
        "transaction_type_id"               => ["required" => false, "type" => "string()"           ],
        "deleted_at"                        => ["required" => false, "type" => "string(date-time)"  ],
        "reference"                         => ["required" => false, "type" => "string()"           ],
        "default_sales_ledger_account_id"   => ["required" => false, "type" => "string()"           ],
        "default_sales_tax_rate_id"         => ["required" => false, "type" => "string()"           ],
        "default_purchase_ledger_account_id"=> ["required" => false, "type" => "string()"           ],
        "tax_number"                        => ["required" => false, "type" => "string()"           ],
        "notes"                             => ["required" => false, "type" => "string()"           ],
        "locale"                            => ["required" => false, "type" => "string()"           ],
        "credit_limit"                      => ["required" => false, "type" => "number(double)"     ],
        "credit_days"                       => ["required" => false, "type" => "interger(int32)"    ],
        "credit_terms_and_conditions"       => ["required" => false, "type" => "string()"           ],
        "product_sales_price_type"          => ["required" => false, "type" => "object"             ],
        "source_guid"                       => ["required" => false, "type" => "string()"           ],
        "currency_id"                       => ["required" => false, "type" => "string()"           ],
        "aux_reference"                     => ["required" => false, "type" => "string()"           ],
        "registered_number"                 => ["required" => false, "type" => "string()"           ],
        "deletable"                         => ["required" => false, "type" => "boolean()"          ],
        "links"                             => ["required" => false, "type" => "array"              ],
        "main_address"                      => ["required" => false, "type" => "object"             ], // ["name" => "", "address_line_1" => "", "address_line_2" => "", "city" => "", "region" => "", "postal_code" => "", "country_id" => "", "country_group_id" => ""]
        "delivery_address"                  => ["required" => false, "type" => "object"             ], // ["name" => "", "address_line_1" => "", "address_line_2" => "", "city" => "", "region" => "", "postal_code" => "", "country_id" => "", "country_group_id" => ""]
        "main_contact_person"               => ["required" => false, "type" => "object"             ], // [ "name" => "", "job_title" => "", "telephone" => "", "mobile" => "", "email" => "", "fax" => ""]
        "bank_account_details"              => ["required" => false, "type" => "object"             ], // ["account_name" => "","account_number" => "","sort_code" => "","bic" => "","iban" => ""]
        "tax_treatment"                     => ["required" => false, "type" => "object"             ],
    ];
}
