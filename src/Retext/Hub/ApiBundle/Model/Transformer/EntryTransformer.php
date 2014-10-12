<?php

namespace Retext\Hub\ApiBundle\Model\Transformer;

use Dothiv\ValueObject\URLValue;
use Retext\Hub\ApiBundle\Model\EntryModel;
use Retext\Hub\BackendBundle\Entity\Entry;
use Symfony\Component\Routing\RouterInterface;

class EntryTransformer extends AbstractTransformer
{
    /**
     * @param Entry $entry
     *
     * @return EntryModel
     */
    public function transform(Entry $entry)
    {
        $model = new EntryModel();
        $model->setJsonLdId($this->generateLink($entry));
        $model->fields = $entry->getFields();
        return $model;
    }


    /**
     * @param Entry $entry
     *
     * @return URLValue
     */
    protected function generateLink(Entry $entry)
    {
        $link = $this->router->generate(
            $this->route,
            array(
                'organization' => (string)$entry->getProject()->getOrganization()->getHandle(),
                'project'      => (string)$entry->getProject()->getHandle(),
                'entry'        => (string)$entry->getHandle()
            ),
            RouterInterface::ABSOLUTE_URL
        );
        return new URLValue($link);
    }
}
