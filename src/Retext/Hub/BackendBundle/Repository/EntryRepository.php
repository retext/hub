<?php

namespace Retext\Hub\BackendBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Dothiv\ValueObject\IdentValue;
use PhpOption\Option;
use Retext\Hub\BackendBundle\Entity\Entry;
use Retext\Hub\BackendBundle\Entity\Project;
use Doctrine\ORM\EntityRepository as DoctrineEntityRepository;
use Symfony\Component\Validator\Constraints as Assert;

class EntryRepository extends DoctrineEntityRepository implements EntryRepositoryInterface
{
    use Traits\ValidatorTrait;
    use Traits\TokenGeneratorTrait;

    /**
     * {@inheritdoc}
     */
    public function persist(Entry $entry)
    {
        if (Option::fromValue($entry->getId())->isEmpty()) {
            $entry->setHandle(new IdentValue($this->generateToken(16)));
        }
        $this->getEntityManager()->persist($this->validate($entry));
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
        $result = $this->createQueryBuilder('e')
            ->andWhere('e.project = :project')->setParameter('project', $project)
            ->getQuery()
            ->getResult();
        $types  = new ArrayCollection();
        foreach ($result as $e) {
            /** @var Entry $e */
            $types->set((string)$e->getHandle(), $e);
        }
        return $types;
    }

    /**
     * {@inheritdoc}
     */
    public function findByHandle(IdentValue $orgHandle, IdentValue $projectHandle, IdentValue $entryHandle)
    {
        return Option::fromValue($this->createQueryBuilder('e')
            ->andWhere('e.handle = :handle')->setParameter('handle', (string)$entryHandle)
            ->leftJoin('e.project', 'p')
            ->andWhere('p.handle = :projectHandle')->setParameter('projectHandle', (string)$projectHandle)
            ->getQuery()
            ->getOneOrNullResult());
    }
}
