<?php

namespace Delights\Sage\SObjects;

use Delights\Sage\SObject;

class SalesInvoiceLine extends SObject
{
    const RESOURCE_NAME = "sales_invoice_lines";

    protected $fields   = [
        "description"                   => ["required" => true, "type" => "array(string())"     ],
        "ledger_account_id"             => ["required" => true, "type" => "array(string())"     ],
        "quantity"                      => ["required" => true, "type" => "array(number)"       ],
        "unit_price"                    => ["required" => true, "type" => "array(number)"       ],
        "product_id"                    => ["required" => false, "type" => "array(string())"    ],
        "net_amount"                    => ["required" => false, "type" => "array(number)"      ],
        "tax_rate_id"                   => ["required" => false, "type" => "array(string())"    ],
        "tax_amount"                    => ["required" => false, "type" => "array(number)"      ],
        "tax_breakdown"                 => ["required" => false, "type" => "array(string())"    ],
        "total_amount"                  => ["required" => false, "type" => "number(double)"     ],
        "base_currency_unit_price"      => ["required" => false, "type" => "number(double)"     ],
        "base_currency_net_amount"      => ["required" => false, "type" => "number(double)"     ],
        "base_currency_tax_amount"      => ["required" => false, "type" => "number(double)"     ],
        "base_currency_tax_breakdown"   => ["required" => false, "type" => "array(string())"    ],
        "base_currency_total_amount"    => ["required" => false, "type" => "number(double)"     ],
        "service_id"                    => ["required" => false, "type" => "string()"           ],
        "discount_amount"               => ["required" => false, "type" => "number(double)"     ],
        "base_currency_discount_amount" => ["required" => false, "type" => "number(double)"     ],
    ];
}
