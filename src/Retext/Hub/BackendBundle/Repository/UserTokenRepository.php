<?php

namespace Retext\Hub\BackendBundle\Repository;

use PhpOption\Option;
use Retext\Hub\BackendBundle\Entity\User;
use Retext\Hub\BackendBundle\Entity\UserToken;
use Retext\Hub\BackendBundle\Repository\Traits\ValidatorTrait;
use Doctrine\ORM\EntityRepository as DoctrineEntityRepository;
use Symfony\Component\Validator\Constraints as Assert;

class UserTokenRepository extends DoctrineEntityRepository implements UserTokenRepositoryInterface
{
    use ValidatorTrait;

    /**
     * Returns whether the user has tokens of scope $scope which have been created after $created
     *
     * @param User      $user
     * @param string    $scope
     * @param \DateTime $created
     *
     * @return bool
     */
    function hasTokens(User $user, $scope, \DateTime $created)
    {
        // TODO: Implement hasTokens() method.
    }


    /**
     * {@inheritdoc}
     */
    public function persist(UserToken $UserToken)
    {
        $this->getEntityManager()->persist($this->validate($UserToken));
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function flush()
    {
        $this->getEntityManager()->flush();
        return $this;
    }

    /**
     * @param string $bearerToken
     *
     * @return Option
     */
    public function getTokenByBearerToken($bearerToken)
    {
        return Option::fromValue($this->createQueryBuilder('ut')
            ->andWhere('ut.bearerToken = :bearerToken')->setParameter('bearerToken', $bearerToken)
            ->leftJoin('ut.user', 'u')
            ->getQuery()
            ->getOneOrNullResult());
    }
}
