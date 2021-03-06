<?php

namespace Retext\Hub\BackendBundle\Repository\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\QueryBuilder;
use PhpOption\Option;
use Retext\Hub\BackendBundle\Entity\PaginatedEntityInterface;
use Retext\Hub\BackendBundle\Repository\PaginatedResult;

trait PaginatedResultBuilderTrait
{
    /**
     * Builds a paginated result.
     *
     * @param QueryBuilder $qb
     * @param mixed|null   $offsetKey
     * @param mixed|null   $offsetDir
     *
     * @return PaginatedResult
     */
    protected function buildPaginatedResult(QueryBuilder $qb, $offsetKey = null, $offsetDir = null)
    {
        $statsQb = clone $qb;
        list(, $total, $minKey, $maxKey) = $statsQb->select('COUNT(i), MAX(i.id), MIN(i.id)')->getQuery()->getScalarResult()[0];
        $paginatedResult = new PaginatedResult(10, $total);
        $offsetDir       = Option::fromValue($offsetDir)->getOrElse('forward');
        if (Option::fromValue($offsetKey)->isDefined()) {
            if ($offsetDir == 'back') {
                $qb->orderBy('i.id', 'ASC');
                $qb->andWhere('i.id > :offsetKey')->setParameter('offsetKey', $offsetKey);
            } else { // forward
                $qb->orderBy('i.id', 'DESC');
                $qb->andWhere('i.id < :offsetKey')->setParameter('offsetKey', $offsetKey);
            }

        } else {
            $qb->orderBy('i.id', 'DESC');
        }
        $qb->setMaxResults($paginatedResult->getItemsPerPage());

        $items = $qb
            ->getQuery()
            ->getResult();
        if ($offsetDir == 'back') {
            $items = array_reverse($items);
        }
        $result = new ArrayCollection($items);
        if ($result->count() == 0) {
            return $paginatedResult;
        }
        $paginatedResult->setResult($result);
        if ($result->count() == $paginatedResult->getItemsPerPage()) {
            $paginatedResult->setNextPageKey(function (PaginatedEntityInterface $item) use ($maxKey) {
                return $item->getIdentifier() != $maxKey ? $item->getIdentifier() : null;
            });
        }
        if ($offsetKey !== null) {
            $paginatedResult->setPrevPageKey(function (PaginatedEntityInterface $item) use ($minKey) {
                return $item->getIdentifier() != $minKey ? $item->getIdentifier() : null;
            });
        }

        return $paginatedResult;
    }
} 
