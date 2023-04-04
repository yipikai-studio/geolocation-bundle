<?php
/*
 * This file is part of the Yipikai Geolocation Bundle package.
 *
 * (c) Yipikai <support@yipikai.studio>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yipikai\GeolocationBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Yipikai\GeolocationBundle\Event\GeolocationEvent;
use Yipikai\GeolocationBundle\Services\Geolocation;

/**
 * Yipikai Geolocation EventSubscriber.
 * @author Matthieu Beurel <matthieu@yipikai.studio>
 */
class GeolocationEventSubscriber implements EventSubscriberInterface
{

  /**
   * @var Geolocation
   */
  protected Geolocation $geolocation;

  /**
   * GeolocationEventSubscriber constructor
   *
   * @param Geolocation $geolocation
   */
  public function __construct(Geolocation $geolocation)
  {
    $this->geolocation = $geolocation;
  }

  /**
   * @return array[]
   */
  public static function getSubscribedEvents(): array
  {
    return [
      GeolocationEvent::EVENT_YIPIKAI_GEOLOCATION_RETRIEVE     =>  ["retrieve", 1024],
    ];
  }

  /**
   * @param GeolocationEvent $geolocationEvent
   *
   * @return void
   */
  public function retrieve(GeolocationEvent $geolocationEvent)
  {
    $coordinates = null;
    if($geolocationEvent->getObject())
    {
      $coordinates = $this->geolocation->retrieveByObject($geolocationEvent->getObject(), $geolocationEvent->isHydrateObject());
      $geolocationEvent->setAddress(array_key_exists("address", $coordinates) ? $coordinates["address"] : null);
    }
    elseif($geolocationEvent->getAddress())
    {
      $coordinates = $this->geolocation->retrieveByAddress($geolocationEvent->getAddress());
    }
    if(is_array($coordinates))
    {
      $geolocationEvent->setLatitude(array_key_exists(Geolocation::LATITUDE, $coordinates) ? $coordinates[Geolocation::LATITUDE] : null);
      $geolocationEvent->setLongitude(array_key_exists(Geolocation::LONGITUDE, $coordinates) ? $coordinates[Geolocation::LONGITUDE] : null);
    }
  }

}