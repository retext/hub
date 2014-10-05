<?php

namespace Retext\Hub\BackendBundle\Tests\Extra;

use Doctrine\Common\EventArgs;

class TimestampableListener extends \Gedmo\Timestampable\TimestampableListener
{
    /**
     * {@inheritdoc}
     */
    protected function getEventAdapter(EventArgs $args)
    {
        $adapter = new TimestampableAdapter();
        $adapter->setEventArgs($args);
        return $adapter;
    }
}
