<?php
/*
 * This file is part of the Yipikai Geolocation Bundle package.
 *
 * (c) Yipikai <support@yipikai.studio>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yipikai\GeolocationBundle\Doctrine\Mapping;
use Yipikai\GeolocationBundle\Services\Geolocation;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
final class CoordinateLatitude implements Coordinate
{

  /**
   * @var string
   */
  public string $coordinateKeyname = Geolocation::LATITUDE;

}
