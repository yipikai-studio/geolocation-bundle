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

use Doctrine\Common\Annotations\Reader;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Yipikai\GeolocationBundle\Doctrine\Mapping\Address;
use Yipikai\GeolocationBundle\Doctrine\Mapping\AddressCity;
use Yipikai\GeolocationBundle\Doctrine\Mapping\AddressPostalCode;
use Yipikai\GeolocationBundle\Doctrine\Mapping\AddressStreet;
use Yipikai\GeolocationBundle\Doctrine\Mapping\Coordinate;

class GeolocationMapping
{

  /**
   * @var Reader
   */
  protected Reader $reader;

  /**
   * @var PropertyAccessor
   */
  protected PropertyAccessor $propertyAccessor;

  /**
   * @var array
   */
  protected array $elementMappingGeolocationAddress = array();

  /**
   * @var array
   */
  protected array $elementMappingGeolocationCoordinates = array();

  /**
   * @var object
   */
  protected object $object;

  /**
   * @return void
   */
  public function __construct(Reader $reader)
  {
    $this->reader = $reader;
    $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
  }

  /**
   * initialise
   *
   * @param object $object
   *
   * @return GeolocationMapping
   * @throws \ReflectionException
   */
  public function initialise(object $object): GeolocationMapping
  {
    $this->object = $object;
    $this->elementMappingGeolocationAddress = array();
    $this->elementMappingGeolocationCoordinates = array();
    $reflectionClass = new \ReflectionClass($object::class);
    foreach ($reflectionClass->getProperties() as $property)
    {
      foreach ($this->reader->getPropertyAnnotations($property) as $annotation)
      {
        $this->elementMapping($annotation, $property);
      }
    }
    foreach ($reflectionClass->getMethods() as $method)
    {
      foreach ($this->reader->getMethodAnnotations($method) as $annotation)
      {
        $this->elementMapping($annotation, $method);
      }
    }
    return $this;
  }

  /**
   * elementMapping
   *
   * @param $annotation
   * @param \ReflectionMethod|\ReflectionProperty $propertyOrMethod
   *
   * @return GeolocationMapping
   */
  protected function elementMapping($annotation, \ReflectionMethod|\ReflectionProperty $propertyOrMethod): GeolocationMapping
  {
    if($annotation instanceof Coordinate || $annotation instanceof Address)
    {
      if($annotation instanceof Coordinate) {
        $elementMapping = $this->elementMappingGeolocationCoordinates[$annotation::class] ?? null;
      }
      else {
        $elementMapping = $this->elementMappingGeolocationAddress[$annotation::class] ?? null;
      }

      if(!$elementMapping)
      {
        $elementMapping = new ElementMapping();
        $elementMapping->annotation = $annotation;
      }
      if($propertyOrMethod instanceof \ReflectionProperty)
      {
        $elementMapping->property = $propertyOrMethod;
      }
      if($propertyOrMethod instanceof \ReflectionMethod)
      {
        $elementMapping->method = $propertyOrMethod;
      }

      if($annotation instanceof Coordinate) {
        $this->elementMappingGeolocationCoordinates[$annotation::class] = $elementMapping;
      }
      else {
        $this->elementMappingGeolocationAddress[$annotation::class] = $elementMapping;
      }
    }
    return $this;
  }

  /**
   * getAddress
   * @return string
   */
  public function getAddress(): string
  {
    $finalAddress = "";
    if(array_key_exists(Address::class, $this->elementMappingGeolocationAddress))
    {
      /** @var ElementMapping $elementMapping */
      $elementMapping = $this->elementMappingGeolocationAddress[Address::class];
      if($elementMapping->property)
      {
        $finalAddress = $this->propertyAccessor->getValue($this->object, $elementMapping->property->name);
      }
      elseif($elementMapping->method)
      {
        $finalAddress = $this->propertyAccessor->getValue($this->object, $elementMapping->method->name);
      }
    }
    if(!$finalAddress)
    {
      $addressParameters = array();
      /**
       * @var string $key
       * @var ElementMapping $elementMapping
       */
      foreach ($this->elementMappingGeolocationAddress as $key => $elementMapping)
      {
        if($key === AddressStreet::class)
        {
          $addressParameters[0] = $this->propertyAccessor->getValue($this->object, $elementMapping->property->name);
        }
        elseif($key === AddressPostalCode::class)
        {
          $addressParameters[1] = $this->propertyAccessor->getValue($this->object, $elementMapping->property->name);
        }
        elseif($key === AddressCity::class)
        {
          $addressParameters[2] = $this->propertyAccessor->getValue($this->object, $elementMapping->property->name);
        }
      }
      $finalAddress = implode($addressParameters);
    }
    return $finalAddress;
  }

  /**
   * coordinateHydrate
   *
   * @param array $coordinates
   *
   * @return GeolocationMapping
   */
  public function coordinateHydrate(array $coordinates): GeolocationMapping
  {
    /** @var ElementMapping $elementMapping */
    foreach($this->elementMappingGeolocationCoordinates as $elementMapping)
    {
      if(array_key_exists($elementMapping->annotation->coordinateKeyname, $coordinates) && ($value = $coordinates[$elementMapping->annotation->coordinateKeyname]))
      {
        $this->propertyAccessor->setValue($this->object, $elementMapping->property->name, $value);
      }
    }
    return $this;
  }

}