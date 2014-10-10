<?php

namespace Retext\Hub\BackendBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Retext\Hub\BackendBundle\Entity\UserLoginLinkRequest;
use Retext\Hub\BackendBundle\Repository\Traits\ValidatorTrait;
use Doctrine\ORM\EntityRepository as DoctrineEntityRepository;

class UserLoginLinkRequestRepository extends DoctrineEntityRepository implements UserLoginLinkRequestRepositoryInterface
{
    use ValidatorTrait;

    /**
     * {@inheritdoc}
     */
    public function persist(UserLoginLinkRequest $request)
    {
        $this->getEntityManager()->persist($this->validate($request));
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
     * {@inheritdoc}
     */
    function findUnprocessed()
    {
        return new ArrayCollection($this->createQueryBuilder('r')
            ->andWhere('r.processed IS NULL')
            ->getQuery()
            ->getResult());
    }
}
