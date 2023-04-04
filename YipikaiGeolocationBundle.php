<?php
/*
 * This file is part of the Yipikai Geolocation Bundle package.
 *
 * (c) Yipikai <support@yipikai.studio>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yipikai\GeolocationBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Yipikai Geolocation Bundle.
 * @author Matthieu Beurel <matthieu@yipikai.studio>
 */
class YipikaiGeolocationBundle extends Bundle
{

  /**
   * @param ContainerBuilder $container
   */
  public function build(ContainerBuilder $container)
  {
    parent::build($container);
  }

}
