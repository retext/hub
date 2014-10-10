<?php

namespace Retext\Hub\BackendBundle\Service\Traits;

use Symfony\Component\Security\Core\Util\SecureRandom;

trait TokenGeneratorTrait
{
    /**
     * @return string
     */
    protected function generateToken()
    {
        $sr = new SecureRandom();
        return bin2hex($sr->nextBytes(8));
    }
} 
