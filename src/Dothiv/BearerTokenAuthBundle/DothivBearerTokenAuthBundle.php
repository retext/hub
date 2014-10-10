<?php

namespace Dothiv\BearerTokenAuthBundle;

use Dothiv\BearerTokenAuthBundle\Factory\Oauth2BearerFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DothivBearerTokenAuthBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new Oauth2BearerFactory());
    }
}
