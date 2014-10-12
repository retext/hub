<?php

namespace Retext\Hub\ApiBundle\Model\Transformer;

use Dothiv\ValueObject\URLValue;
use Retext\Hub\ApiBundle\Model\PaginatedListModel;
use Retext\Hub\BackendBundle\Repository\PaginatedResult;
use Symfony\Component\Routing\RouterInterface;

class PaginatedListTransformer extends AbstractTransformer
{
    /**
     * @param PaginatedResult $result
     *
     * @return PaginatedListModel
     */
    public function transform(PaginatedResult $result)
    {
        $paginatedList = new PaginatedListModel();
        $paginatedList->setItemsPerPage($result->getItemsPerPage());
        $paginatedList->setTotal($result->getTotal());
        if ($result->getNextPageKey()->isDefined()) {
            $paginatedList->setNextPageUrl(
                new URLValue(
                    $this->router->generate(
                        $this->route,
                        array('offsetKey' => $result->getNextPageKey()->get()),
                        RouterInterface::ABSOLUTE_URL
                    )
                )
            );
        }
        if ($result->getPrevPageKey()->isDefined()) {
            $paginatedList->setPrevPageUrl(
                new URLValue(
                    $this->router->generate(
                        $this->route,
                        array('offsetKey' => $result->getPrevPageKey()->get(), 'offsetDir' => 'back'),
                        RouterInterface::ABSOLUTE_URL
                    )
                )
            );
        }
        return $paginatedList;
    }
}
