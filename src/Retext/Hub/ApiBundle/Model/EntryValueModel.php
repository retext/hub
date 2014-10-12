<?php

namespace Retext\Hub\ApiBundle\Model;

use Dothiv\ValueObject\URLValue;
use Retext\Hub\BackendBundle\Entity\EntryField;

class EntryValueModel implements JsonLdEntityInterface
{
    use Traits\JsonLdEntityTrait;

    /**
     * @var EntryField
     */
    private $field;

    /**
     * @var mixed
     */
    private $value;

    public function __construct(EntryField $field, $value)
    {
        $this->field = $field;
        $this->value = $value;
        $this->setJsonLdContext(new URLValue('http://hub.retext.it/jsonld/EntryValue'));
    }
}
