<?php

namespace Retext\Hub\ApiBundle\Model;

use Dothiv\ValueObject\URLValue;
use JMS\Serializer\Annotation as Serializer;

class PaginatedListModel implements JsonLdEntityInterface
{
    use Traits\JsonLdEntityTrait;

    /**
     * @var array
     */
    protected $items;

    /**
     * @var URLValue
     */
    protected $nextPageUrl;

    /**
     * @var UrlValue
     */
    protected $prevPageUrl;

    /**
     * @var int
     */
    protected $itemsPerPage;

    /**
     * @var int
     */
    protected $total;

    public function __construct()
    {
        $this->setJsonLdContext(new URLValue('http://hub.retext.it/jsonld/PaginatedList'));
    }

    /**
     * @param mixed $item
     *
     * @return self
     */
    public function addItem($item)
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * @param int $itemsPerPage
     *
     * @return self
     */
    public function setItemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;
        return $this;
    }

    /**
     * @return int
     */
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    /**
     * @param URLValue $nextPageUrl
     *
     * @return self
     */
    public function setNextPageUrl(URLValue $nextPageUrl)
    {
        $this->nextPageUrl = $nextPageUrl;
        return $this;
    }

    /**
     * @return URLValue
     */
    public function getNextPageUrl()
    {
        return $this->nextPageUrl;
    }

    /**
     * @param URLValue $prevPageUrl
     *
     * @return self
     */
    public function setPrevPageUrl(URLValue $prevPageUrl)
    {
        $this->prevPageUrl = $prevPageUrl;
        return $this;
    }

    /**
     * @return URLValue
     */
    public function getPrevPageUrl()
    {
        return $this->prevPageUrl;
    }

    /**
     * @return int
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("count")
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * @param int $total
     *
     * @return self
     */
    public function setTotal($total)
    {
        $this->total = $total;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }
} 
