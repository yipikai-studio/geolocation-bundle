<?php
/*
 * This file is part of the Yipikai Geolocation Bundle package.
 *
 * (c) Yipikai <support@yipikai.studio>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yipikai\GeolocationBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

use \Exception;

/**
 * Yipikai Geolocation Extension.
 * @author Matthieu Beurel <matthieu@yipikai.studio>
 * @final
 */
class YipikaiGeolocationExtension extends Extension
{
  /**
   * {@inheritdoc}
   * @throws Exception
   */
  public function load(array $configs, ContainerBuilder $container)
  {
    $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
    $loader->load('services.yaml');
  }

  /**
   * @return string
   */
  public function getNamespace(): string
  {
    return 'https://yipikai.app/schema/dic/geolocation';
  }

}
