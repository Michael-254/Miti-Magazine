<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Delights\Sage\SObjects\BankAccount;
use Delights\Sage\SObjects\Contact;
use Delights\Sage\SObjects\ContactPayment;
use Delights\Sage\SObjects\LedgerAccount;
use Delights\Sage\SObjects\SalesInvoice;

class SageAccountingInvoicesTest extends SageAccountingBaseTest
{
    private $products;
    private $contact;

    public function tearDown()
    {
        collect($this->products)->each(function ($product) {
            $product->destroy();
        });
        $this->contact->destroy();
    }

    /** @test */
    public function can_create_and_pay_a_sage_invoice()
    {
        $this->contact    = (new Contact($this->api, [
            "name"             => "Jordi",
            "contact_type_ids" => ["CUSTOMER"],
        ]))->create();

        $ledgerAccount = (new LedgerAccount($this->api))
            ->where("ledger_account_type_id=SALES")->where("items_per_page=100")->where("ledger_account_classification=ES_SALES_AND_INCOMES")
            ->get()->first(function ($ledgerAccount) {
                return str_contains($ledgerAccount->displayed_as, '70500000');
            });

        $bankAccount = (new BankAccount($this->api))
            ->get()->first(function ($bankAccount) {
                return str_contains($bankAccount->displayed_as, '57200000');   // Cuenta corriente    57000000 -> Efectivo en caja
            });

        $invoiceResource = (new SalesInvoice($this->api));
        $invoices_count  = $invoiceResource->count();

        $invoice = (new SalesInvoice($this->api, [
            "contact_id"        => $this->contact->id,
            "date"              => Carbon::now()->toDateString(),
            "main_address"      => [
                "name"              => "Main Address",
                "address_line_1"    => "C/Església nº 18",
                "address_line_2"    => "",
                "city"              => "Sant Salvador de Guardiola",
                "region"            => "Barcelona",
                "postal_code"       => "08253",
                "country_id"        => "ES"
            ], "invoice_lines"      => [
                [
                    "description" => "Line 1",
                    "ledger_account_id" => $ledgerAccount->id,
                    "quantity" => 2,
                    "unit_price" => 55,
                    "tax_rate_id" => "ES_NO_TAX",
                ],
            ],
        ]))->create();
        $contactPayment = (new ContactPayment($this->api, [
            "transaction_type_id" => "CUSTOMER_RECEIPT",
            "contact_id" => $this->contact->id,
            "bank_account_id" => $bankAccount->id,
            "date" => Carbon::now()->toDateString(),
            "total_amount"  => 110.00,
            "allocated_artefacts" =>  [
                [ 
                    'artefact_id'   =>  $invoice->id,
                    'amount'        => 110.00
                ]
            ]
        ]))->create();

        $this->assertNotFalse($invoice->id);
        $freshInvoice = $invoiceResource->find($invoice->id);

        $this->assertNotFalse($contactPayment->id);
        $this->assertEquals($this->contact->id, $freshInvoice->contact["id"]);
        $this->assertEquals(Carbon::now()->toDateString(), $freshInvoice->date);
        $this->assertCount(1, $freshInvoice->invoice_lines);
        $this->assertEquals($invoices_count + 1, $invoiceResource->count());
        $this->assertEquals("PAID", $freshInvoice->status["id"]);
        $this->assertEquals(110.0, $freshInvoice->total_paid);
    }

}
