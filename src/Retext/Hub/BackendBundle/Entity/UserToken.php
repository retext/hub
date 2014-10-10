<?php

namespace Retext\Hub\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Retext\Hub\BackendBundle\Entity\Traits\CreateTimeTrait;
use Dothiv\ValueObject\IdentValue;
use Retext\Hub\BackendBundle\Entity\Traits\IdTrait;
use Retext\Hub\BackendBundle\Entity\Traits\UserTrait;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Represents a user's login token
 *
 * @ORM\Entity(repositoryClass="Retext\Hub\BackendBundle\Repository\UserTokenRepository")
 * @ORM\Table(
 *      uniqueConstraints={
 *          @ORM\UniqueConstraint(name="usertoken__user_token",columns={"user_id", "token"}),
 *          @ORM\UniqueConstraint(name="usertoken__bearerToken",columns={"bearerToken"})
 *      },
 *      indexes={@ORM\Index(name="usertoken__scope_idx", columns={"scope"})})
 * )
 *
 * @Serializer\ExclusionPolicy("all")
 *
 * @ORM\HasLifecycleCallbacks
 */
class UserToken
{
    use IdTrait;
    use CreateTimeTrait;
    use UserTrait;

    const SCOPE_LOGIN = 'login';

    /**
     * The token used to login.
     *
     * @ORM\Column(type="string", nullable=false)
     * @Assert\Type("string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    protected $token;

    /**
     * Scope of the token.
     *
     * @ORM\Column(type="string", nullable=false)
     * @Assert\Type("string")
     * @Assert\NotBlank()
     * @Assert\Choice({"login"})
     *
     * @var string
     */
    protected $scope;

    /**
     * The lifetime of the token
     *
     * @ORM\Column(type="datetime", nullable=false)
     * @Assert\Type("\DateTime")
     * @Assert\NotBlank()
     *
     * @var \DateTime
     */
    protected $lifeTime;

    /**
     * The time of revokation
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\Type("\DateTime")
     *
     * @var \DateTime
     */
    protected $revokedTime;

    /**
     * The bearer token for easier lookup
     *
     * @ORM\Column(type="string", nullable=false)
     * @Assert\Type("string")
     * @Assert\NotBlank()
     */
    protected $bearerToken;

    /**
     * @param IdentValue $token
     *
     * @return self
     */
    public function setToken(IdentValue $token)
    {
        $this->token = (string)$token;
        return $this;
    }

    /**
     * @return IdentValue
     */
    public function getToken()
    {
        return new IdentValue($this->token);
    }

    /**
     * @ORM\PrePersist
     */
    public function updateBearerToken()
    {
        $this->bearerToken = sha1(sprintf('%s:%s', $this->user->getEmail(), $this->token));
    }

    /**
     * @return mixed
     */
    public function getBearerToken()
    {
        return new IdentValue($this->bearerToken);
    }

    /**
     * @return \DateTime
     */
    public function getLifeTime()
    {
        return $this->lifeTime;
    }

    /**
     * @param \DateTime $lifeTime
     */
    public function setLifeTime(\DateTime $lifeTime)
    {
        $this->lifeTime = $lifeTime;
    }

    public function revoke(\DateTime $revokeTime)
    {
        $this->revokedTime = $revokeTime;
    }

    /**
     * @return bool
     */
    public function isRevoked()
    {
        return !empty($this->revokedTime);
    }

    /**
     * @param \DateTime $revokedTime
     */
    public function setRevokedTime(\DateTime $revokedTime)
    {
        $this->revokedTime = $revokedTime;
    }

    /**
     * @return \DateTime
     */
    public function getRevokedTime()
    {
        return $this->revokedTime;
    }

    /**
     * @param IdentValue $scope
     *
     * @return self
     */
    public function setScope(IdentValue $scope)
    {
        $this->scope = (string)$scope;
        return $this;
    }

    /**
     * @return string
     */
    public function getScope()
    {
        return $this->scope;
    }
}
