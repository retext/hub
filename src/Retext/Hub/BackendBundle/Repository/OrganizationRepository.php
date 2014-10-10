<?php

namespace Retext\Hub\BackendBundle\Repository;

use Retext\Hub\BackendBundle\Entity\Organization;
use Retext\Hub\BackendBundle\Repository\Traits\ValidatorTrait;
use Doctrine\ORM\EntityRepository as DoctrineEntityRepository;
use Symfony\Component\Validator\Constraints as Assert;

class OrganizationRepository extends DoctrineEntityRepository implements OrganizationRepositoryInterface
{
    use ValidatorTrait;

    /**
     * {@inheritdoc}
     */
    public function persist(Organization $organization)
    {
        $this->getEntityManager()->persist($this->validate($organization));
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
