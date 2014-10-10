<?php

namespace Retext\Hub\FrontendBundle\Command;

use Dothiv\ValueObject\ClockValue;
use Retext\Hub\BackendBundle\Repository\UserLoginLinkRequestRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendLoginLinksCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('retexthub:send:loginlinks')
            ->setDescription('Send login links');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var UserLoginLinkRequestRepositoryInterface $userLoginRepo */
        /** @var ClockValue $clock */
        $userLoginRepo = $this->getContainer()->get('hub.repo.user_login_link_request');
        $clock         = $this->getContainer()->get('clock');

        foreach ($userLoginRepo->findUnprocessed() as $request) {
            $command    = $this->getApplication()->find('retexthub:send:loginlink');
            $input      = new ArrayInput(array(
                'email' => (string)$request->getUser()->getEmail()
            ));
            $returnCode = $command->run($input, $output);
            if ($returnCode == 0) {
                $request->process($clock->getNow());
                $userLoginRepo->persist($request)->flush();
            }
        }
    }
} 
