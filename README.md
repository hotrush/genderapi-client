### PHP SDK for GenderApi.io API

Simple to use, `api key` is optional. See API docs here - https://genderapi.io/api-documentation

#### Installation

```
composer require hotrush/genderapi-client 
```

#### Usage

```php
use Hotrush\GenderApi\GenderApiClient;
use Hotrush\GenderApi\Adapter\GuzzleHttpAdapter;

$client = new GenderApiClient(
    new GuzzleHttpAdapter($apiToken)
);

$nameData = $client->getGender($name, $countryCode);
echo $nameData->getGender();

$namesData = $client->getGendersBatch($namesArray, $countryCode);
foreach ($namesData as $nameData) {
    echo $nameData->getGender().PHP_EOL;
    echo $nameData->getName().PHP_EOL;
    echo $nameData->getProbability().PHP_EOL;
}

$nameData = $client->getGenderByEmail($name, $countryCode);
echo $nameData->getGender();
```