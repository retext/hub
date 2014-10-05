<?php

namespace Retext\Hub\BackendBundle\Tests\Tests;

use Dothiv\ValueObject\EmailValue;
use Dothiv\ValueObject\IdentValue;
use Retext\Hub\BackendBundle\Entity\User;
use Retext\Hub\BackendBundle\Entity\UserToken;
use Retext\Hub\BackendBundle\Repository\UserRepository;
use Retext\Hub\BackendBundle\Repository\UserTokenRepository;
use Retext\Hub\BackendBundle\Tests\Repository\Traits\RepositoryTestTrait;

class UserTokenTest extends \PHPUnit_Framework_TestCase
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
        $this->assertInstanceOf('\Retext\Hub\BackendBundle\Repository\UserTokenRepository', $this->getTestObject());
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

        $token = new UserToken();
        $token->setToken(new IdentValue('sometoken'));
        $token->setScope(UserToken::SCOPE_LOGIN);
        $token->setUser($user);
        $token->setLifeTime(new \DateTime());
        $token->updateBearerToken();
        $repo = $this->getTestObject();
        $repo->persist($token);
        $repo->flush();
        $this->assertEquals(1, count($repo->findAll()));
    }

    /**
     * @return UserTokenRepository
     */
    protected function getTestObject()
    {
        /** @var UserTokenRepository $repo */
        $repo = $this->getTestEntityManager()->getRepository('RetextHubBackendBundle:UserToken');
        $repo->setValidator($this->testValidator);
        return $repo;
    }
} 
