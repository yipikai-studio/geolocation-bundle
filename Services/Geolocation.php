<?php
/*
 * This file is part of the Yipikai Geolocation Bundle package.
 *
 * (c) Yipikai <support@yipikai.studio>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yipikai\GeolocationBundle\Services;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\NativeHttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Yipikai\GeolocationBundle\Mapping\GeolocationMapping;

class Geolocation
{

  CONST LATITUDE = "latitude";
  CONST LONGITUDE = "longitude";

  /**
   * @var GeolocationMapping
   */
  protected GeolocationMapping $geolocationMapping;

  /**
   * @var LoggerInterface
   */
  protected LoggerInterface $logger;

  /**
   * @return void
   */
  public function __construct(GeolocationMapping $geolocationMapping, LoggerInterface $logger)
  {
    $this->geolocationMapping = $geolocationMapping;
    $this->logger = $logger;
  }

  /**
   * retrieveByAddress
   *
   * @param object $object
   * @param bool $hydrate
   *
   * @return array|null
   */
  public function retrieveByObject(object $object, bool $hydrate = false): ?array
  {
    $coordinates = null;
    try {
      $this->geolocationMapping->initialise($object);
      $address = $this->geolocationMapping->getAddress();
      $coordinates = $this->retrieveByAddress($address);
      $coordinates["address"] = $address;
      if($hydrate) {
        $this->geolocationMapping->coordinateHydrate($coordinates);
      }
      throw new \Exception("Error");
    } catch (\Exception $e) {
      $this->logger->critical("Geolocation.service -> retrieveByObject : {$e->getMessage()}");
    }
    return $coordinates;
  }


  /**
   * retrieveByAddress
   *
   * @param string $adresse
   *
   * @return array
   */
  public function retrieveByAddress(string $adresse): array
  {
    $geolocation = array();
    try {
      $requestParameters = array(
        "query" =>  array(
          "q" =>  $adresse
        )
      );
      $httpClient = new NativeHttpClient();
      $response = $httpClient->request("GET", "https://api-adresse.data.gouv.fr/search", $requestParameters);
      $responseArray = json_decode($response->getContent(false), true);
      if(array_key_exists("features", $responseArray))
      {
        if($firstAddress = array_shift($responseArray["features"]))
        {
          $geometry = array_key_exists("geometry", $firstAddress) ? $firstAddress["geometry"] : array();
          $geolocationValue = array_key_exists("coordinates", $geometry) ? $geometry["coordinates"] : array();
          $geolocation = array(
            self::LATITUDE    => $geolocationValue[1],
            self::LONGITUDE   => $geolocationValue[0],
          );
        }
      }
    } catch(\Exception|TransportExceptionInterface|ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface $e) {
      $this->logger->critical("Geolocation.service -> retrieveByAddress : {$e->getMessage()}");
    }
    return $geolocation;
  }


}