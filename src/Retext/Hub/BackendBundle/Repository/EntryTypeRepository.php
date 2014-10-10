<?php

namespace Retext\Hub\BackendBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Retext\Hub\BackendBundle\Entity\EntryType;
use Retext\Hub\BackendBundle\Entity\Project;
use Retext\Hub\BackendBundle\Repository\Traits\ValidatorTrait;
use Doctrine\ORM\EntityRepository as DoctrineEntityRepository;
use Symfony\Component\Validator\Constraints as Assert;

class EntryTypeRepository extends DoctrineEntityRepository implements EntryTypeRepositoryInterface
{
    use ValidatorTrait;

    /**
     * {@inheritdoc}
     */
    public function persist(EntryType $EntryType)
    {
        $this->getEntityManager()->persist($this->validate($EntryType));
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
    public function findByProject(Project $project)
    {
        $result = $this->createQueryBuilder('t')
            ->andWhere('t.project = :project')->setParameter('project', $project)
            ->getQuery()
            ->getResult();
        $types  = new ArrayCollection();
        foreach ($result as $t) {
            /** @var EntryType $t */
            $types->set((string)$t->getHandle(), $t);
        }
        return $types;
    }
}
