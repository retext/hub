<?php

namespace Retext\Hub\FrontendBundle\Service;

use Dothiv\ValueObject\URLValue;
use Retext\Hub\BackendBundle\Entity\UserToken;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouterInterface;

class LoginLinkFactory implements LoginLinkFactoryInterface
{

    /**
     * @var string
     */
    protected $route;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var string
     */
    protected $hostname;

    /**
     * @param string          $route
     * @param RouterInterface $router
     * @param string          $hostname
     */
    public function __construct($route, RouterInterface $router, $hostname)
    {
        $this->route    = $route;
        $this->router   = $router;
        $this->hostname = $hostname;
    }

    /**
     * {@inheritdoc}
     */
    function create(UserToken $token)
    {
        $ctx = new RequestContext();
        $ctx->setHost($this->hostname);
        $this->router->setContext($ctx);
        return new URLValue(
            $this->router->generate(
                $this->route,
                array(
                    'user'  => $token->getUser()->getHandle(),
                    'token' => $token->getBearerToken()
                ),
                RouterInterface::ABSOLUTE_URL
            )
        );
    }


} 
