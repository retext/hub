<?php

namespace Retext\Hub\FrontendBundle\Tests\Command;

use Doctrine\Common\Collections\ArrayCollection;
use Dothiv\ValueObject\ClockValue;
use Dothiv\ValueObject\EmailValue;
use Retext\Hub\BackendBundle\Entity\User;
use Retext\Hub\BackendBundle\Entity\UserLoginLinkRequest;
use Retext\Hub\BackendBundle\Entity\UserToken;
use Retext\Hub\BackendBundle\Repository\UserLoginLinkRequestRepositoryInterface;
use Retext\Hub\FrontendBundle\Command\SendLoginLinksCommand;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SendLoginLinksCommandTest extends \PHPUnit_Framework_TestCase
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
     * @var UserLoginLinkRequestRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $mockUserLoginLinkRequestRepo;

    /**
     * @test
     * @group FrontendBundle
     * @group Command
     */
    public function itShouldBeInstantiateable()
    {
        $this->assertInstanceOf('\Retext\Hub\FrontendBundle\Command\SendLoginLinksCommand', $this->getTestObject());
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
            array('hub.repo.user_login_link_request', ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE, $this->mockUserLoginLinkRequestRepo),
            array('clock', ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE, new ClockValue('now')),
        );
        $this->mockContainer->expects($this->any())->method('get')
            ->will($this->returnValueMap($containerMap));
        $this->mockContainer->expects($this->any())->method('getParameter')
            ->with('kernel.environment')->willReturn('test');

        $user = new User();
        $user->setEmail(new EmailValue('john.doe@example.com'));
        $request = new UserLoginLinkRequest();
        $request->setUser($user);
        $requests  = new ArrayCollection(array($request));
        $userToken = new UserToken();
        $userToken->setUser($user);

        $this->mockUserLoginLinkRequestRepo->expects($this->once())->method('findUnprocessed')
            ->willReturn($requests);

        $this->mockUserLoginLinkRequestRepo->expects($this->once())->method('persist')
            ->with($this->callback(function (UserLoginLinkRequest $r) {
                $this->assertNotNull($r->getProcessed());
                return true;
            }))
            ->will($this->returnSelf());
        $this->mockUserLoginLinkRequestRepo->expects($this->once())->method('flush');

        $mockSubCommand = $this->getMockBuilder('\Symfony\Component\Console\Command\Command')
            ->disableOriginalConstructor()->getMock();
        $mockSubCommand->expects($this->once())->method('run')
            ->with(
                $this->callback(function (ArrayInput $input) {
                    $this->assertEquals('john.doe@example.com', $input->getParameterOption('email'));
                    return true;
                }),
                $this->mockOutput
            );

        $mockApp = $this->getMock('\Symfony\Component\Console\Application');
        $mockApp->expects($this->once())->method('find')->with('retexthub:send:loginlink')
            ->willReturn($mockSubCommand);
        $mockApp->expects($this->any())->method('getHelperSet')
            ->willReturn(new HelperSet());
        $mockApp->expects($this->any())->method('getDefinition')
            ->willReturn(new InputDefinition());

        $command = $this->getTestObject();
        $command->setApplication($mockApp);

        $this->assertEquals(0, $command->run($this->mockInput, $this->mockOutput));
    }

    /**
     * @return SendLoginLinksCommand
     */
    protected function getTestObject()
    {
        $command = new SendLoginLinksCommand();
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
        $this->mockUserLoginLinkRequestRepo
            = $this->getMock('\Retext\Hub\BackendBundle\Repository\UserLoginLinkRequestRepositoryInterface');
    }
}
