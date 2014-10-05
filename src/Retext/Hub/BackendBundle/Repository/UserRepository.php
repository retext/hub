<?php

namespace Retext\Hub\BackendBundle\Repository;

use Dothiv\ValueObject\EmailValue;
use Retext\Hub\BackendBundle\Entity\User;
use Retext\Hub\BackendBundle\Repository\Traits\ValidatorTrait;
use PhpOption\Option;
use Doctrine\ORM\EntityRepository as DoctrineEntityRepository;

class UserRepository extends DoctrineEntityRepository implements UserRepositoryInterface
{
    use ValidatorTrait;

    /**
     * @param EmailValue $email
     *
     * @return Option
     */
    public function findByEmail(EmailValue $email)
    {
        return Option::fromValue(
            $this->createQueryBuilder('u')
                ->andWhere('u.email = :email')->setParameter('email', strtolower($email))
                ->getQuery()
                ->getOneOrNullResult()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function persist(User $user)
    {
        $this->getEntityManager()->persist($this->validate($user));
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
}
