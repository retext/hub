<?php

namespace Retext\Hub\MailerBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Dothiv\ValueObject\EmailValue;
use Dothiv\ValueObject\IdentValue;

interface TransactionalEmailMailerInterface
{
    /**
     * Sends a transactional email.
     *
     * @param IdentValue      $type
     * @param EmailValue      $recipient
     * @param ArrayCollection $data
     */
    function send(IdentValue $type, EmailValue $recipient, ArrayCollection $data);
} 
