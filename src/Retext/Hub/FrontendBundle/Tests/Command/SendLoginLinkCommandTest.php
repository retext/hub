<?php

namespace Retext\Hub\FrontendBundle\Tests\Command;

use Doctrine\Common\Collections\ArrayCollection;
use Dothiv\ValueObject\ClockValue;
use Dothiv\ValueObject\EmailValue;
use Dothiv\ValueObject\IdentValue;
use Dothiv\ValueObject\URLValue;
use Retext\Hub\BackendBundle\Entity\User;
use Retext\Hub\BackendBundle\Entity\UserLoginLinkRequest;
use Retext\Hub\BackendBundle\Entity\UserToken;
use Retext\Hub\BackendBundle\Repository\UserLoginLinkRequestRepositoryInterface;
use Retext\Hub\BackendBundle\Repository\UserTokenRepositoryInterface;
use Retext\Hub\BackendBundle\Service\UserServiceInterface;
use Retext\Hub\BackendBundle\Service\UserTokenFactoryInterface;
use Retext\Hub\FrontendBundle\Command\SendLoginLinkCommand;
use Retext\Hub\FrontendBundle\Service\LoginLinkFactoryInterface;
use Retext\Hub\MailerBundle\Service\TransactionalEmailMailerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SendLoginLinkCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var InputInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $mockInput;

    /**
     * @var OutputInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $mockOutput;

    /**
     * @var ContainerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $mockContainer;

    /**
     * @var UserTokenRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $mockUserTokenRepo;

    /**
     * @var UserTokenFactoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $mockUserTokenFactory;

    /**
     * @var LoginLinkFactoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $mockLoginLinkFactory;

    /**
     * @var TransactionalEmailMailerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $mockMailer;

    /**
     * @var UserServiceInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $mockUserService;

    /**
     * @test
     * @group FrontendBundle
     * @group Command
     */
    public function itShouldBeInstantiateable()
    {
        $this->assertInstanceOf('\Retext\Hub\FrontendBundle\Command\SendLoginLinkCommand', $this->getTestObject());
    }

    /**
     * @test
     * @group   FrontendBundle
     * @group   Command
     * @depends itShouldBeInstantiateable
     */
    public function itShouldSendLoginLinks()
    {
        $containerMap = array(
            array('hub.repo.user_token', ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE, $this->mockUserTokenRepo),
            array('hub.usertokenfactory', ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE, $this->mockUserTokenFactory),
            array('hub.frontend.login_link_factory', ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE, $this->mockLoginLinkFactory),
            array('hub.mailer.mailer', ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE, $this->mockMailer),
            array('hub.user', ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE, $this->mockUserService),
            array('clock', ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE, new ClockValue('now')),
        );
        $this->mockContainer->expects($this->any())->method('get')
            ->will($this->returnValueMap($containerMap));
        $this->mockContainer->expects($this->any())->method('getParameter')
            ->with('kernel.environment')->willReturn('test');

        // Set up entites
        $user  = new User();
        $email = new EmailValue('john.doe@example.com');
        $user->setEmail($email);
        $userToken = new UserToken();
        $userToken->setUser($user);

        // Get email from input
        $this->mockInput->expects($this->once())->method('getArgument')->with('email')
            ->willReturn((string)$user->getEmail());

        // Find user
        $this->mockUserService->expects($this->once())->method('getOrCreateUserByEmail')
            ->with($email)
            ->willReturn($user);

        // Create token
        $this->mockUserTokenFactory->expects($this->once())->method('createLoginToken')
            ->with($user)
            ->willReturn($userToken);

        // Save token
        $this->mockUserTokenRepo->expects($this->once())->method('persist')
            ->with($this->callback(function (UserToken $token) use ($userToken) {
                $this->assertEquals($userToken, $token);
                return true;
            }))
            ->will($this->returnSelf());
        $this->mockUserTokenRepo->expects($this->once())->method('flush');

        // Create login link
        $this->mockLoginLinkFactory->expects($this->once())->method('create')
            ->with($userToken)
            ->willReturn(new URLValue('http://example.com/login'));

        // Send email
        $this->mockMailer->expects($this->once())->method('send')
            ->with(
                $this->callback(function (IdentValue $ident) {
                    $this->assertEquals('login', (string)$ident);
                    return true;
                }),
                $user->getEmail(),
                $this->callback(function (ArrayCollection $data) {
                    $this->assertEquals('http://example.com/login', $data->get('loginLink'));
                    return true;
                })
            )
            ->willReturn(new URLValue('http://example.com/login'));

        $this->assertEquals(0, $this->getTestObject()->run($this->mockInput, $this->mockOutput));
    }

    /**
     * @return SendLoginLinkCommand
     */
    protected function getTestObject()
    {
        $command = new SendLoginLinkCommand();
        $command->setContainer($this->mockContainer);
        return $command;
    }

    /**
     * Test setup
     */
    protected function setUp()
    {
        parent::setUp();

        $this->mockInput
            = $this->getMock('\Symfony\Component\Console\Input\InputInterface');
        $this->mockOutput
            = $this->getMock('\Symfony\Component\Console\Output\OutputInterface');
        $this->mockContainer
            = $this->getMock('\Symfony\Component\DependencyInjection\ContainerInterface');
        $this->mockUserTokenRepo
            = $this->getMock('\Retext\Hub\BackendBundle\Repository\UserTokenRepositoryInterface');
        $this->mockUserTokenFactory
            = $this->getMock('\Retext\Hub\BackendBundle\Service\UserTokenFactoryInterface');
        $this->mockLoginLinkFactory
            = $this->getMock('\Retext\Hub\FrontendBundle\Service\LoginLinkFactoryInterface');
        $this->mockMailer
            = $this->getMock('\Retext\Hub\MailerBundle\Service\TransactionalEmailMailerInterface');
        $this->mockUserService
            = $this->getMock('\Retext\Hub\BackendBundle\Service\UserServiceInterface');

    }
}
