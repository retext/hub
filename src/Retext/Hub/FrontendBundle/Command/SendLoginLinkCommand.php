<?php

namespace Retext\Hub\FrontendBundle\Command;

use Doctrine\Common\Collections\ArrayCollection;
use Dothiv\ValueObject\ClockValue;
use Dothiv\ValueObject\EmailValue;
use Dothiv\ValueObject\IdentValue;
use Retext\Hub\BackendBundle\Entity\UserLoginLinkRequest;
use Retext\Hub\BackendBundle\Repository\UserLoginLinkRequestRepositoryInterface;
use Retext\Hub\BackendBundle\Repository\UserTokenRepository;
use Retext\Hub\BackendBundle\Service\UserServiceInterface;
use Retext\Hub\BackendBundle\Service\UserTokenFactoryInterface;
use Retext\Hub\FrontendBundle\Service\LoginLinkFactoryInterface;
use Retext\Hub\MailerBundle\Service\TransactionalEmailMailerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendLoginLinkCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('retexthub:send:loginlink')
            ->setDescription('Send login links')
            ->addArgument('email', InputArgument::REQUIRED, 'A users email adress');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var UserTokenRepository $userTokenRepo */
        /** @var UserTokenFactoryInterface $userTokenFactory */
        /** @var TransactionalEmailMailerInterface $mailer */
        /** @var LoginLinkFactoryInterface $loginLinkGenerator */
        /** @var UserLoginLinkRequestRepositoryInterface $userLoginRepo */
        /** @var UserServiceInterface $userService */
        $userTokenRepo    = $this->getContainer()->get('hub.repo.user_token');
        $userTokenFactory = $this->getContainer()->get('hub.usertokenfactory');
        $mailer           = $this->getContainer()->get('hub.mailer.mailer');
        $loginLinkFactory = $this->getContainer()->get('hub.frontend.login_link_factory');
        $userService      = $this->getContainer()->get('hub.user');

        $user      = $userService->getOrCreateUserByEmail(new EmailValue($input->getArgument('email')));
        $userToken = $userTokenFactory->createLoginToken($user);
        $userTokenRepo->persist($userToken)->flush();
        $data = new ArrayCollection(array('loginLink' => (string)$loginLinkFactory->create($userToken)));
        $mailer->send(new IdentValue('login'), $userToken->getUser()->getEmail(), $data);
        if ($output->getVerbosity() > OutputInterface::VERBOSITY_QUIET) {
            $output->writeln('Sent login link to ' . $user->getEmail());
        }
    }
} 
