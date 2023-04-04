<?php
/*
 * This file is part of the Yipikai Geolocation Bundle package.
 *
 * (c) Yipikai <support@yipikai.studio>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yipikai\GeolocationBundle\Mapping;

use Yipikai\GeolocationBundle\Doctrine\Mapping\Address;
use Yipikai\GeolocationBundle\Doctrine\Mapping\Coordinate;

class ElementMapping
{

  /**
   * @var Address|Coordinate
   */
  public Address|Coordinate $annotation;

  /**
   * @var \ReflectionProperty|null
   */
  public ?\ReflectionProperty $property;

  /**
   * @var \ReflectionMethod|null
   */
  public ?\ReflectionMethod $method;

}