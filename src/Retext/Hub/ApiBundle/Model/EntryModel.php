<?php

namespace Retext\Hub\ApiBundle\Model;

use Dothiv\ValueObject\URLValue;
use JMS\Serializer\Annotation as Serializer;

class EntryModel implements JsonLdEntityInterface
{
    use Traits\JsonLdEntityTrait;

    /**
     * @var object
     */
    public $fields;

    public function __construct()
    {
        $this->setJsonLdContext(new URLValue('http://hub.retext.it/jsonld/Entry'));
    }
}
