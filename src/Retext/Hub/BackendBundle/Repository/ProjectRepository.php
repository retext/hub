<?php

namespace Retext\Hub\BackendBundle\Repository;

use Dothiv\ValueObject\IdentValue;
use PhpOption\Option;
use Retext\Hub\BackendBundle\Entity\Project;
use Retext\Hub\BackendBundle\Repository\Traits\ValidatorTrait;
use Doctrine\ORM\EntityRepository as DoctrineEntityRepository;
use Symfony\Component\Validator\Constraints as Assert;

class ProjectRepository extends DoctrineEntityRepository implements ProjectRepositoryInterface
{
    use ValidatorTrait;

    /**
     * {@inheritdoc}
     */
    public function persist(Project $Project)
    {
        $this->getEntityManager()->persist($this->validate($Project));
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
    public function findByHandle(IdentValue $orgHandle, IdentValue $projectHandle)
    {
        return Option::fromValue($this->createQueryBuilder('p')
            ->andWhere('p.handle = :handle')->setParameter('handle', (string)$projectHandle)
            ->andWhere('o.handle = :orgHandle')->setParameter('orgHandle', (string)$orgHandle)
            ->leftJoin('p.organization', 'o')
            ->getQuery()
            ->getOneOrNullResult());
    }

}
