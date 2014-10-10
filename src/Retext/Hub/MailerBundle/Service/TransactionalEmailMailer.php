<?php

namespace Retext\Hub\MailerBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Dothiv\ValueObject\EmailValue;
use Dothiv\ValueObject\IdentValue;

class TransactionalEmailMailer implements TransactionalEmailMailerInterface
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var string
     */
    protected $templateDir;

    /**
     * @param \Swift_Mailer $mailer
     * @param string        $templateDir
     * @param string        $fromAddress
     * @param string        $fromName
     */
    public function __construct(\Swift_Mailer $mailer, $templateDir, $fromAddress, $fromName)
    {
        $this->mailer           = $mailer;
        $this->templateDir      = rtrim($templateDir, '/');
        $this->emailFromAddress = new EmailValue($fromAddress);
        $this->emailFromName    = $fromName;
    }

    /**
     * {@inheritdoc}
     */
    public function send(IdentValue $type, EmailValue $recipient, ArrayCollection $data)
    {
        $subjectTemplate = $this->loadTemplate($type, new IdentValue('subject'));
        $bodyTemplate    = $this->loadTemplate($type, new IdentValue('body'));
        $twig            = new \Twig_Environment(new \Twig_Loader_String());
        $subject         = $twig->render($subjectTemplate, $data->toArray());
        $text            = $twig->render($bodyTemplate, $data->toArray());

        // send email
        $message = \Swift_Message::newInstance();
        $message
            ->setSubject($subject)
            ->setFrom((string)$this->emailFromAddress, $this->emailFromName)
            ->setTo((string)$recipient)
            ->setBody($text);

        $this->mailer->send($message);
    }

    /**
     * @param IdentValue $type
     * @param IdentValue $part
     *
     * @return string
     */
    protected function loadTemplate(IdentValue $type, IdentValue $part)
    {
        return file_get_contents(
            sprintf(
                '%s/%s/%s.text.twig',
                $this->templateDir,
                $type,
                $part
            )
        );
    }

} 
