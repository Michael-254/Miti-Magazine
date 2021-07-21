@extends('layouts.app')

@section('content')
<div class="content-body">
    <!-- invoice functionality start -->
    <section class="invoice-print mb-1">
        <div class="row">
            <div class="col-12 col-md-12 d-flex flex-column flex-md-row justify-content-end">
                <button class="btn btn-primary btn-print mb-1 mb-md-0"> <i class="feather icon-file-text"></i> Print</button>
            </div>
        </div>
    </section>
    <!-- invoice functionality end -->
    <!-- invoice page -->
    <section class="card invoice-page">
        <div id="invoice-template" class="card-body">
            <!-- Invoice Company Details -->
            <div id="invoice-company-details" class="row">
                <div class="col-sm-6 col-12 text-left pt-1">
                    <div class="media pt-1">
                        <img src="{{asset('storage/logo.png')}}" alt="company logo" class="w-32 h-32" />
                    </div>
                </div>
                <div class="col-sm-6 col-12 text-right">
                    <h1 class="font-bold text-3xl">Invoice</h1>
                    <div class="invoice-details mt-2">
                        <h6 class="font-bold">INVOICE NO.</h6>
                        <p>001/2019</p>
                        <h6 class="mt-2 font-bold">INVOICE DATE</h6>
                        <p>10 Dec 2018</p>
                    </div>
                </div>
            </div>
            <!--/ Invoice Company Details -->

            <!-- Invoice Recipient Details -->
            <div id="invoice-customer-details" class="row pt-2">
                <div class="col-sm-6 col-12 text-left">
                    <h5>Recipient</h5>
                    <div class="recipient-info my-2">
                        <p>Peter Stark</p>
                        <p>8577 West West Drive</p>
                        <p>Holbrook, NY</p>
                        <p>90001</p>
                    </div>
                    <div class="recipient-contact pb-2">
                        <p>
                            <i class="feather icon-mail"></i>
                            peter@mail.com
                        </p>
                        <p>
                            <i class="feather icon-phone"></i>
                            +91 988 888 8888
                        </p>
                    </div>
                </div>
                <div class="col-sm-6 col-12 text-right">
                    <h5 class="font-semibold text-xl">Better Globe Forestry LTD.</h5>
                    <div class="company-info my-2">
                        <p>Tabere Cresecent, Kileleshwa</p>
                        <p>Nairobi, Kenya</p>
                        <p>823-00606</p>
                    </div>
                    <div class="company-contact">
                        <h5 class="font-semibold">Contact Person</h5>
                        <p>
                            <i class="feather icon-mail"></i>
                            lawrence@betterglobeforestry.com
                        </p>
                        <p>
                            <i class="feather icon-phone"></i>
                            +254724374483
                        </p>
                    </div>
                </div>
            </div>
            <!--/ Invoice Recipient Details -->

            <!-- Invoice Items Details -->
            <div id="invoice-items-details" class="pt-1 invoice-items-table">
                <div class="row">
                    <div class="table-responsive col-12">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>ITEM DESCRIPTION</th>
                                    <th>QUANTITY</th>
                                    <th>UNIT PRICE</th>
                                    <th>SUB-TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Website Redesign</td>
                                    <td>60</td>
                                    <td>15 USD</td>
                                    <td>90000 USD</td>
                                </tr>
                                <tr>
                                    <td>Newsletter template design</td>
                                    <td>20</td>
                                    <td>12 USD</td>
                                    <td>24000 USD</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="invoice-total-details" class="invoice-total-table">
                <div class="row">
                    <div class="col-7 offset-5">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>SUBTOTAL</th>
                                        <td>114000 USD</td>
                                    </tr>
                                    <tr>
                                        <th>DISCOUNT (5%)</th>
                                        <td>5700 USD</td>
                                    </tr>
                                    <tr>
                                        <th>TOTAL</th>
                                        <td>108300 USD</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Invoice Footer -->
            <div id="invoice-footer" class="text-right pt-3">
                <p><span class="font-bold">Tel:</span> +254(02)3594200 <span class="font-bold ml-2">Email:</span> accounts@betterglobeforestry.com
                    <span class="font-bold ml-2">Website: </span>www.betterglobeforestry.com
                </p>
                <p class="bank-details mb-0 mr-4">
                    <span class="mr-4">KRA PIN: <strong>P051167447E</strong></span>
                </p>
            </div>
            <!--/ Invoice Footer -->

        </div>
    </section>
    <!-- invoice page end -->

</div>
@endsection