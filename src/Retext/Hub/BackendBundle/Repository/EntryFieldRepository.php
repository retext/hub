<?php

namespace Retext\Hub\BackendBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Retext\Hub\BackendBundle\Entity\EntryField;
use Retext\Hub\BackendBundle\Entity\EntryType;
use Retext\Hub\BackendBundle\Repository\Traits\ValidatorTrait;
use Doctrine\ORM\EntityRepository as DoctrineEntityRepository;
use Symfony\Component\Validator\Constraints as Assert;

class EntryFieldRepository extends DoctrineEntityRepository implements EntryFieldRepositoryInterface
{
    use ValidatorTrait;

    /**
     * {@inheritdoc}
     */
    public function persist(EntryField $entryField)
    {
        $this->getEntityManager()->persist($this->validate($entryField));
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
    public function findByType(EntryType $type)
    {
        $result = $this->createQueryBuilder('f')
            ->andWhere('f.type = :type')->setParameter('type', $type)
            ->getQuery()
            ->getResult();
        $fields = new ArrayCollection();
        foreach ($result as $f) {
            /** @var EntryField $f */
            $fields->set((string)$f->getHandle(), $f);
        }
        return $fields;
    }
}
