<?php

namespace Retext\Hub\BackendBundle\Tests\Tests;

use Dothiv\ValueObject\EmailValue;
use Retext\Hub\BackendBundle\Entity\User;
use Retext\Hub\BackendBundle\Entity\UserLoginLinkRequest;
use Retext\Hub\BackendBundle\Repository\UserRepository;
use Retext\Hub\BackendBundle\Repository\UserLoginLinkRequestRepository;
use Retext\Hub\BackendBundle\Tests\Repository\Traits\RepositoryTestTrait;

class UserLoginLinkRequestTest extends \PHPUnit_Framework_TestCase
{
    use RepositoryTestTrait;

    /**
     * @test
     * @group Entity
     * @group BusinessBundle
     * @group User
     */
    public function itShouldBeInstantiateable()
    {
        $this->assertInstanceOf('\Retext\Hub\BackendBundle\Repository\UserLoginLinkRequestRepository', $this->getTestObject());
    }

    /**
     * @test
     * @group   Entity
     * @group   BusinessBundle
     * @group   User
     * @group   Integration
     * @depends itShouldBeInstantiateable
     */
    public function itShouldPersist()
    {
        /** @var UserRepository $userRepo */
        $userRepo = $this->getTestEntityManager()->getRepository('RetextHubBackendBundle:User');
        $userRepo->setValidator($this->testValidator);
        $user = new User();
        $user->setEmail(new EmailValue('john.doe@example.com'));
        $userRepo->persist($user)->flush();

        $loginRequest = new UserLoginLinkRequest();
        $loginRequest->setUser($user);
        $repo = $this->getTestObject();
        $repo->persist($loginRequest);
        $repo->flush();
        $this->assertEquals(1, count($repo->findAll()));
    }

    /**
     * @return UserLoginLinkRequestRepository
     */
    protected function getTestObject()
    {
        /** @var UserLoginLinkRequestRepository $repo */
        $repo = $this->getTestEntityManager()->getRepository('RetextHubBackendBundle:UserLoginLinkRequest');
        $repo->setValidator($this->testValidator);
        return $repo;
    }
} 
