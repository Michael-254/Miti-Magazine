<?php

namespace Delights\Sage\SObjects;

use Delights\Sage\SObject;

class SalesInvoice extends SObject
{
    const RESOURCE_NAME = "sales_invoices";

    protected $fields   = [
        "contact_id"                            => ["required" => true, "type" => "string()"            ],
        "date"                                  => ["required" => true, "type" => "string(date)"        ],
        "invoice_lines"                         => ["required" => true, "type" => "object"               ],

        "transaction_type_id"                   => ["required" => false, "type" => "The ID of the Transaction Type.	string()" ],
        "invoice_number"                        => ["required" => false, "type" => "The generated invoice number	string()" ],
        "contact_name"                          => ["required" => false, "type" => "The name of the contact when the invoice was created	string()" ],
        "contact_reference"                     => ["required" => false, "type" => "The reference of the contact when the invoice was created	string()" ],
        "due_date"                              => ["required" => false, "type" => "The due date of the invoice	string(date)" ],
        "reference"                             => ["required" => false, "type" => "The reference for the invoice	string()" ],
        "main_address_free_form"                => ["required" => false, "type" => "The free-form main address of the invoice	string()" ],
        "delivery_address_free_form"            => ["required" => false, "type" => "The free-form delivery address of the invoice	string()" ],
        "notes"                                 => ["required" => false, "type" => "Invoice notes	string()" ],
        "terms_and_conditions"                  => ["required" => false, "type" => "Invoice terms and conditions	string()" ],
        "shipping_net_amount"                   => ["required" => false, "type" => "The net shipping amount	number(double)" ],
        "shipping_tax_rate_id"                  => ["required" => false, "type" => "The ID of the Shipping Tax Rate.	string()" ],
        "shipping_tax_amount"                   => ["required" => false, "type" => "The tax shipping amount. NOTE: This is not required for POST/PUT requests as the shipping tax is calculated based on the shipping_net_amount and the shipping_tax_rate.	number(double)" ],
        "shipping_total_amount"                 => ["required" => false, "type" => "The total shipping amount	number(double)" ],
        "net_amount"                            => ["required" => false, "type" => "The net amount of the invoice	number(double)" ],
        "tax_amount"                            => ["required" => false, "type" => "The tax amount of the invoice	number(double)" ],
        "total_amount"                          => ["required" => false, "type" => "The total amount of the invoice	number(double)" ],
        "payments_allocations_total_amount"     => ["required" => false, "type" => "The total amount of all payments and allocations	number(double)" ],
        "payments_allocations_total_discount"   => ["required" => false, "type" => "The total discount of all payments and allocations	number(double)" ],
        "total_paid"                            => ["required" => false, "type" => "The total paid amount of the invoice including any payments, allocations and discounts	number(double)" ],
        "outstanding_amount"                    => ["required" => false, "type" => "The outstanding amount of the invoice	number(double)" ],
        "currency_id"                           => ["required" => false, "type" => "The ID of the Currency.	string()" ],
        "exchange_rate"                         => ["required" => false, "type" => "The exchange rate for the invoice	number(double)" ],
        "inverse_exchange_rate"                 => ["required" => false, "type" => "The inverse exchange rate for the invoice	number(double)" ],
        "base_currency_shipping_net_amount"     => ["required" => false, "type" => "The net shipping amount in base currency	number(double)" ],
        "base_currency_shipping_tax_amount"     => ["required" => false, "type" => "The tax shipping amount in base currency	number(double)" ],
        "base_currency_shipping_total_amount"   => ["required" => false, "type" => "The total shipping amount in base currency	number(double)" ],
        "total_quantity"                        => ["required" => false, "type" => "The total quantity of the invoice	number(double)" ],
        "total_discount_amount"                 => ["required" => false, "type" => "The discount amount on the invoice	number(double)" ],
        "base_currency_total_discount_amount"   => ["required" => false, "type" => "The discount amount on the invoice in base currency	number(double)" ],
        "base_currency_net_amount"              => ["required" => false, "type" => "The net amount of the invoice in base currency	number(double)" ],
        "base_currency_tax_amount"              => ["required" => false, "type" => "The tax amount of the invoice in base currency	number(double)" ],
        "base_currency_total_amount"            => ["required" => false, "type" => "The total amount of the invoice in base currency	number(double)" ],
        "base_currency_outstanding_amount"      => ["required" => false, "type" => "The outstanding amount of the invoice in base currency	number(double)" ],
        "status_id"                             => ["required" => false, "type" => "The ID of the Status.	string()" ],
        "sent"                                  => ["required" => false, "type" => "Indicates whether the invoice has been sent	boolean()" ],
        "void_reason"                           => ["required" => false, "type" => "The reason the invoice was voided	string()" ],
        "tax_address_region_id"                 => ["required" => false, "type" => "The ID of the Tax Address Region. (Canada only)	string()	Not applicable" ],
        "delivery_performance_date"             => ["required" => false, "type" => "Delivery/Performance Date (Germany only)	string()" ],
        "withholding_tax_rate"                  => ["required" => false, "type" => "IRPF withheld Tax Rate (Spain only)	number(double)" ],
        "withholding_tax_amount"                => ["required" => false, "type" => "IRPF withheld Tax Amount (Spain only)	number(double)" ],
        "base_currency_withholding_tax_amount"  => ["required" => false, "type" => "IRPF withheld Tax Amount (Spain only) in the base currency	number(double)" ],
        "corrections"                           => ["required" => false, "type" => "The corrective entries associated with the invoice	array(string())" ],
        "tax_reconciled"                        => ["required" => false, "type" => "Indicates if the sales invoice is tax reconciled or not.	boolean()" ],
        "migrated"                              => ["required" => false, "type" => "Indicates if the sales invoice was migrated from another system.	boolean()" ],
        "tax_calculation_method"                => ["required" => false, "type" => "The tax calculation method, if applicable, for this sales invoice, returns invoice or cash.	string()" ],
        "links"                                 => ["required" => false, "type" => "See sales_invoices_sales_invoice_links	array" ],
        "shipping_tax_breakdown"                => ["required" => false, "type" => "See sales_invoices_sales_invoice_shipping_tax_breakdown	array" ],
        "base_currency_shipping_tax_breakdown"  => ["required" => false, "type" => "See sales_invoices_sales_invoice_base_currency_shipping_tax_breakdown	array" ],
        "tax_analysis"                          => ["required" => false, "type" => "See sales_invoices_sales_invoice_tax_analysis	array" ],
        "original_quote_estimate_id"            => ["required" => false, "type" => "See sales_invoices_sales_invoice_original_quote_estimate_id	array" ],
        "Expandable"                            => ["required" => false, "type" => "sub entity fields from GET, POST and PUT requests" ],
        "transaction"                           => ["required" => false, "type" => "See sales_invoices_sales_invoice_transaction	object" ],
        "main_address"                          => ["required" => false, "type" => "See sales_invoices_sales_invoice_main_address	object" ],
        "delivery_address"                      => ["required" => false, "type" => "See sales_invoices_sales_invoice_delivery_address	object" ],
        "detailed_tax_analysis"                 => ["required" => false, "type" => "See sales_invoices_sales_invoice_detailed_tax_analysis	object" ],
        "payments_allocations"                  => ["required" => false, "type" => "See sales_invoices_sales_invoice_payments_allocations	object" ],
    ];
}
