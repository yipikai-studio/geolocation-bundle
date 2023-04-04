# Geolocation Bundle

[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.4-8892BF.svg)](https://php.net/)
[![Latest Stable Version](https://img.shields.io/packagist/v/yipikai/geolocation-bundle.svg)](https://packagist.org/packages/yipikai/geolocation-bundle)
[![Total Downloads](https://poser.pugx.org/yipikai/geolocation-bundle/downloads.svg)](https://packagist.org/packages/yipikai/geolocation-bundle)
[![License](https://poser.pugx.org/yipikai/geolocation-bundle/license.svg)](https://packagist.org/packages/yipikai/geolocation-bundle)

## Install bundle

You can install it with Composer:

```
composer require yipikai/geolocation-bundle
```

This bundle use the api to the [adresse.data.gouv.fr](https://adresse.data.gouv.fr/api-doc/adresse)

## Documentation

### Retrieve Coordinates with address postal

**Use Event Dispatcher**
```php
$geolocationEvent = new GeolocationEvent();
$geolocationEvent->setAddress("134 route de Vertou 44200 Nantes");
$eventDispatcher->dispatch($geolocationEvent, GeolocationEvent::EVENT_YIPIKAI_GEOLOCATION_RETRIEVE);

// Get Latitude
$latitude = $geolocationEvent->getLatitude();

// Get Longitude
$longitude = $geolocationEvent->getLongitude();
```

**Use Service Container**
```php
$coordinates = $this->container->get('yipikai.geolocation')->retrieveByAddress("134 route de Vertou 44200 Nantes");
/**
 * $coordinates = array:2 [
 *   "latitude" => 47.186543
 *   "longitude" => -1.528056
 * ]
 */
```

### Retrieve Coordinates with Object

```php
...
use Yipikai\GeolocationBundle\Doctrine\Mapping as Geolocation;
class Object
{
  ...
  /**
   * @var string|null
   * @Geolocation\AddressStreet()
   */
  protected ?string $addressStreet = null;
  
  /**
   * @var string|null
   * @Geolocation\AddressCity()
   */
  protected ?string $city = null;
  
  /**
   * @var string|null
   * @Geolocation\AddressPostalCode()
   */
  protected ?string $postalCode = null;
  
  /**
   * @var string|null
   * @Geolocation\CoordinateLatitude()
   */
  protected ?string $latitude = null;
  
  /**
   * @var string|null
   * @Geolocation\CoordinateLongitude()
   */
  protected ?string $longitude = null;
  ...
}
```

**Use Event Dispatcher**
```php

$object = new Object();
$object->setAddressStreet("134 route de Vertou");
$object->setCity("Nantes");
$object->setPostalCode("44200");

$geolocationEvent = new GeolocationEvent();
$geolocationEvent->setObject($object);
// hydrate auto latitude and longitude in to object
$geolocationEvent->setHydrateObject(true);

$eventDispatcher->dispatch($geolocationEvent, GeolocationEvent::EVENT_YIPIKAI_GEOLOCATION_RETRIEVE);

// Get Latitude
$latitude = $geolocationEvent->getLatitude();

// Get Longitude
$longitude = $geolocationEvent->getLongitude();

// Get Address
$address = $geolocationEvent->getAddress();
```

**Use Service Container**
```php
$object = new Object();
$object->setAddressStreet("134 route de Vertou");
$object->setCity("Nantes");
$object->setPostalCode("44200");

$coordinates = $this->geolocation->retrieveByObject($object, true); // This second var is hydrate auto
$coordinates = $this->container->get('yipikai.geolocation')->retrieveByAddress("134 route de Vertou 44200 Nantes");
/**
 * $coordinates = array:2 [
 *   "latitude" => 47.186543
 *   "longitude" => -1.528056,
 *   "address" => "134 route de Vertou 44200 Nantes"
 * ]
 */
```


## Commit Messages

The commit message must follow the [Conventional Commits specification](https://www.conventionalcommits.org/).
The following types are allowed:

* `update`: Update
* `fix`: Bug fix
* `feat`: New feature
* `docs`: Change in the documentation
* `spec`: Spec change
* `test`: Test-related change
* `perf`: Performance optimization

Examples:

    update : Something

    fix: Fix something

    feat: Introduce X

    docs: Add docs for X

    spec: Z disambiguation

## License and Copyright
See licence file

## Credits
Created by [Matthieu Beurel](https://www.mbeurel.com). Sponsored by [Yipikai Studio](https://yipikai.studio).