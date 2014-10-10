<?php

namespace Dothiv\BearerTokenAuthBundle;

use PhpOption\Option;

interface UserTokenRepositoryInterface
{

    /**
     * @param string $bearerToken
     *
     * @return Option
     */
    public function getTokenByBearerToken($bearerToken);
}
