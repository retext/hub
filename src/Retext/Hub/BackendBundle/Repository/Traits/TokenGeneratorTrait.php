<?php

namespace Retext\Hub\BackendBundle\Repository\Traits;

use Symfony\Component\Security\Core\Util\SecureRandom;

trait TokenGeneratorTrait
{
    /**
     * @param int $bytes
     *
     * @return string
     */
    protected function generateToken($bytes = 8)
    {
        $sr = new SecureRandom();
        return bin2hex($sr->nextBytes($bytes));
    }
} 
