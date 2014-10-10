<?php

namespace Retext\Hub\FrontendBundle\Service;

use Dothiv\ValueObject\URLValue;
use Retext\Hub\BackendBundle\Entity\UserToken;

interface LoginLinkFactoryInterface
{
    /**
     * Creates a login link for a user token
     *
     * @param UserToken $token
     *
     * @return URLValue
     */
    function create(UserToken $token);
} 
