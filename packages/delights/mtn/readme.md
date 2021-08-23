## Laravel MTM MOMO API Integration

### Introduction

This package helps you integrate the [MTN MOMO API](https://momodeveloper.mtn.com) into your Laravel application. It provides a wrapper around the core MTN MOMO API services, leaving you to worry about other parts of your application.

### [Installation](https://packagist.org/packages/delights/mtn)

To get started, install the package via the Composer package manager:

```bash
composer require delights\mtn
```

The service provider will be auto-discovered for Laravel 5.5 and above. You may manually register the service provider in your configuration `config/app.php` file:

```php
'providers' => array(
   // ...
   Delights\Mtn\MtnMomoServiceProvider::class,
),
```

**Configuration customization**

If you wish to customize the default configurations, you may export the default configuration using

```bash
php artisan vendor:publish --provider="Delights\Mtn\MtnMomoServiceProvider" --tag="config"
```

**Database Migration**

The package service provider registers it's own database migrations with the framework, so you should migrate your database after installation. The migration will create a tokens tables your application needs to store access tokens from MTN MOMO API.

```bash
php artisan migrate
```

### Prerequisites

You will need the following to get started with you integration...

1. Create a [**developer account**](https://momodeveloper.mtn.com/signup) with MTN MOMO.
2. Subscribe to a [**product/service**](https://momodeveloper.mtn.com/products) that you wish to consume.

If you already subscribed to a product, the subscription key can be found in your [**profile**](https://momodeveloper.mtn.com/developer).

### Getting started (Sandbox)

Register your client details.

```bash
php artisan mtn-momo:init
```

Next you need to register your client app ID.

```bash
php artisan mtn-momo:register-id
```

You may want to verify your client ID at this stage

```bash
php artisan mtn-momo:validate-id
```

Then request for a client secret (key).

```bash
php artisan mtn-momo:request-secret
```

### Usage

```php
use Delights\Mtn\Products\Collection;

$collection = new Collection();

$momoTransactionId = $collection->requestToPay('transactionId', '46733123454', 100);
```

See [test numbers](https://momodeveloper.mtn.com/api-documentation/testing/#test-numbers)

**Exception handling**

```php
use Delights\Mtn\Products\Collection;
use Delights\Mtn\Exceptions\CollectionRequestException;

try {
    $collection = new Collection();
    
    $momoTransactionId = $collection->requestToPay('transactionId', '46733123453', 100);
} catch(CollectionRequestException $e) {
    do {
        printf("\n\r%s:%d %s (%d) [%s]\n\r", 
            $e->getFile(), $e->getLine(), $e->getMessage(), $e->getCode(), get_class($e));
    } while($e = $e->getPrevious());
}
```

### [Available methods](https://evans-wanguba.github.io/mtn/master/Delights/MtnMomo/Products.html)

**Collection**

1. [Collect money](https://evans-wanguba.github.io/mtn/master/Delights/MtnMomo/Products/Collection.html#method_requestToPay)

    ```php
    $collection->requestToPay($transactionId, $partyId, $amount)
    ```

2. [Check transaction status](https://evans-wanguba.github.io/mtn/master/Delights/MtnMomo/Products/Collection.html#method_getTransactionStatus)

    ```php
    $collection->getTransactionStatus($momoTransactionId)
    ```

3. [Check account balance](https://evans-wanguba.github.io/mtn/master/Delights/MtnMomo/Products/Collection.html#method_getAccountBalance)

    ```php
    $collection->getAccountBalance()
    ```

4. [Check account status](https://evans-wanguba.github.io/mtn/master/Delights/MtnMomo/Products/Collection.html#method_isActive)

    ```php
    $collection->isActive($partyId)
    ```

5. [Get OAuth token](https://evans-wanguba.github.io/mtn/master/Delights/MtnMomo/Products/Collection.html#method_getToken)

    ```php
    $collection->getToken()
    ```

6. [Get Account Holder Info](https://evans-wanguba.github.io/mtn/master/Delights/MtnMomo/Products/Collection.html#method_getAccountHolderBasicInfo)

    ```php
    $collection->getAccountHolderBasicInfo($partyId)
    ```

**Disbursement**

1. [Disburse money](https://evans-wanguba.github.io/mtn/master/Delights/MtnMomo/Products/Disbursement.html#method_transfer)

    ```php
    $disbursement->transfer($transactionId, $partyId, $amount)
    ```

2. [Check transaction status](https://evans-wanguba.github.io/mtn/master/Delights/MtnMomo/Products/Disbursement.html#method_getTransactionStatus)

    ```php
    $disbursement->getTransactionStatus($momoTransactionId)
    ```

3. [Check account balance](https://evans-wanguba.github.io/mtn/master/Delights/MtnMomo/Products/Disbursement.html#method_getAccountBalance)

    ```php
    $disbursement->getAccountBalance()
    ```

4. [Check account status](https://evans-wanguba.github.io/mtn/master/Delights/MtnMomo/Products/Disbursement.html#method_isActive)

    ```php
    $disbursement->isActive($partyId)
    ```

5. [Get OAuth token](https://evans-wanguba.github.io/mtn/master/Delights/MtnMomo/Products/Disbursement.html#method_getToken)

    ```php
    $disbursement->getToken()
    ```

6. [Get Account Holder Info](https://evans-wanguba.github.io/mtn/master/Delights/MtnMomo/Products/Collection.html#method_getAccountHolderBasicInfo)

    ```php
    $collection->getAccountHolderBasicInfo($partyId)
    ```
    
**Remittance**

1. [Remit money](https://evans-wanguba.github.io/mtn/master/Delights/MtnMomo/Products/Remittance.html#method_transact)

    ```php
    $remittance->transfer($transactionId, $partyId, $amount)
    ```

2. [Check transaction status](https://evans-wanguba.github.io/mtn/master/Delights/MtnMomo/Products/Remittance.html#method_getTransactionStatus)

    ```php
    $remittance->getTransactionStatus($momoTransactionId)
    ```

3. [Check account balance](https://evans-wanguba.github.io/mtn/master/Delights/MtnMomo/Products/Remittance.html#method_getAccountBalance)

    ```php
    $remittance->getAccountBalance()
    ```

4. [Check account status](https://evans-wanguba.github.io/mtn/master/Delights/MtnMomo/Products/Remittance.html#method_isActive)

    ```php
    $remittance->isActive($partyId)
    ```

5. [Get OAuth token](https://evans-wanguba.github.io/mtn/master/Delights/MtnMomo/Products/Remittance.html#method_getToken)

    ```php
    $remittance->getToken()
    ```

6. [Get Account Holder Info](https://evans-wanguba.github.io/mtn/master/Delights/MtnMomo/Products/Collection.html#method_getAccountHolderBasicInfo)

    ```php
    $collection->getAccountHolderBasicInfo($partyId)
    ```
    
### Go live

You will need to make some changes to your setup before going live. [Read more](https://github.com/evans-wanguba/mtn/wiki/Go-Live).

### Reporting bugs

If you've stumbled across a bug, please help us by leaving as much information about the bug as possible, e.g.
- Steps to reproduce
- Expected result
- Actual result

This will help us to fix the bug as quickly as possible, and if you wish to fix it yourself feel free to [fork the package](https://github.com/evans-wanguba/mtn) and submit a pull request!
