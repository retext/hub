<?php

namespace Retext\Hub\BackendBundle\Tests\Service;

use Dothiv\ValueObject\ClockValue;
use PhpOption\None;
use Retext\Hub\BackendBundle\Entity\User;
use Retext\Hub\BackendBundle\Entity\UserLoginLinkRequest;
use Retext\Hub\BackendBundle\Entity\UserToken;
use Retext\Hub\BackendBundle\Repository\UserLoginLinkRequestRepositoryInterface;
use Retext\Hub\BackendBundle\Repository\UserRepositoryInterface;
use Retext\Hub\BackendBundle\Repository\UserTokenRepositoryInterface;
use Dothiv\ValueObject\EmailValue;
use Retext\Hub\BackendBundle\Service\UserService;

class UserServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|UserRepositoryInterface
     */
    private $mockUserRepo;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|UserTokenRepositoryInterface
     */
    private $mockUserTokenRepo;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|UserLoginLinkRequestRepositoryInterface
     */
    private $mockUserLoginLinkRequestRepo;

    /**
     * @test
     * @group BackendBundle
     * @group Service
     */
    public function itShouldBeInstantiateable()
    {
        $this->assertInstanceOf('\Retext\Hub\BackendBundle\Service\UserService', $this->createTestObject());
    }

    /**
     * @test
     * @group   BackendBundle
     * @group   Service
     * @depends itShouldBeInstantiateable
     */
    public function itShouldReturnAUser()
    {
        // Set up data
        $email = new EmailValue('john.doe@example.com');

        // Set up mocks
        $this->mockUserRepo->expects($this->once())->method('findByEmail')
            ->with($email)
            ->willReturn(None::create());

        $this->mockUserRepo->expects($this->once())->method('persist')
            ->with($this->callback(function (User $user) use ($email) {
                $this->assertEquals($email, $user->getEmail());
                return true;
            }))
            ->willReturnSelf();

        $this->mockUserRepo->expects($this->once())->method('flush');

        // Execute
        $user = $this->createTestObject()->getOrCreateUserByEmail($email);
        $this->assertInstanceOf('\Retext\Hub\BackendBundle\Entity\User', $user, 'Expected User to be returned.');
    }

    /**
     * @test
     * @group   BackendBundle
     * @group   Service
     * @depends itShouldBeInstantiateable
     */
    public function itShouldCreateALoginLink()
    {
        // Set up data
        $user = new User();
        $user->setEmail(new EmailValue('john.doe@example.com'));

        // Set up mocks
        $this->mockUserTokenRepo->expects($this->once())->method('hasTokens')
            ->with($user, UserToken::SCOPE_LOGIN, new \DateTime('2014-10-01T11:34:56+02:00'))
            ->willReturn(false);

        $this->mockUserLoginLinkRequestRepo->expects($this->once())->method('persist')
            ->with($this->callback(function (UserLoginLinkRequest $event) use ($user) {
                $this->assertEquals($user, $event->getUser());
                return true;
            }))
            ->willReturnSelf();

        $this->mockUserLoginLinkRequestRepo->expects($this->once())->method('flush');

        // Execute
        $this->createTestObject()->createLoginLinkRequest($user);
    }

    /**
     * @return UserService
     */
    protected function createTestObject()
    {
        return new UserService(
            $this->mockUserRepo,
            $this->mockUserTokenRepo,
            $this->mockUserLoginLinkRequestRepo,
            new ClockValue('2014-10-01T12:34:56+02:00')
        );
    }

    public function setUp()
    {
        $this->mockUserRepo                 = $this->getMock('\Retext\Hub\BackendBundle\Repository\UserRepositoryInterface');
        $this->mockUserTokenRepo            = $this->getMock('\Retext\Hub\BackendBundle\Repository\UserTokenRepositoryInterface');
        $this->mockUserLoginLinkRequestRepo = $this->getMock('\Retext\Hub\BackendBundle\Repository\UserLoginLinkRequestRepositoryInterface');
    }
} 
