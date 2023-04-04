<?php
/*
 * This file is part of the Yipikai Geolocation Bundle package.
 *
 * (c) Yipikai <support@yipikai.studio>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yipikai\GeolocationBundle\Event;

/**
 * Austral Geolocation Event.
 * @author Matthieu Beurel <matthieu@yipikai.studio>
 * @final
 */
class GeolocationEvent
{
  const EVENT_YIPIKAI_GEOLOCATION_RETRIEVE = "yipikai.event.geolocation.retrieve";

  /**
   * @var object|null
   */
  private ?object $object = null;

  /**
   * @var string|null
   */
  private ?string $address = null;

  /**
   * @var float|null
   */
  private ?float $latitude = null;

  /**
   * @var float|null
   */
  private ?float $longitude = null;

  /**
   * @var bool
   */
  private bool $hydrateObject = false;

  public function __construct()
  {

  }

  /**
   * @return object|null
   */
  public function getObject(): ?object
  {
    return $this->object;
  }

  /**
   * @param object|null $object
   *
   * @return $this
   */
  public function setObject(?object $object): GeolocationEvent
  {
    $this->object = $object;
    return $this;
  }

  /**
   * @return string|null
   */
  public function getAddress(): ?string
  {
    return $this->address;
  }

  /**
   * @param string|null $address
   *
   * @return $this
   */
  public function setAddress(?string $address): GeolocationEvent
  {
    $this->address = $address;
    return $this;
  }

  /**
   * @return float|null
   */
  public function getLatitude(): ?float
  {
    return $this->latitude;
  }

  /**
   * @param float|null $latitude
   *
   * @return $this
   */
  public function setLatitude(?float $latitude): GeolocationEvent
  {
    $this->latitude = $latitude;
    return $this;
  }

  /**
   * @return float|null
   */
  public function getLongitude(): ?float
  {
    return $this->longitude;
  }

  /**
   * @param float|null $longitude
   *
   * @return $this
   */
  public function setLongitude(?float $longitude): GeolocationEvent
  {
    $this->longitude = $longitude;
    return $this;
  }

  /**
   * @return bool
   */
  public function isHydrateObject(): bool
  {
    return $this->hydrateObject;
  }

  /**
   * @param bool $hydrateObject
   *
   * @return $this
   */
  public function setHydrateObject(bool $hydrateObject): GeolocationEvent
  {
    $this->hydrateObject = $hydrateObject;
    return $this;
  }


}