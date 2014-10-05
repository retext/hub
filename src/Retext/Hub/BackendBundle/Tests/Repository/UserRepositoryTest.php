<?php

namespace Retext\Hub\BackendBundle\Tests\Tests;

use Dothiv\ValueObject\EmailValue;
use Retext\Hub\BackendBundle\Entity\User;
use Retext\Hub\BackendBundle\Repository\UserRepository;
use Retext\Hub\BackendBundle\Tests\Repository\Traits\RepositoryTestTrait;

class UserRepositoryTest extends \PHPUnit_Framework_TestCase
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
        $this->assertInstanceOf('\Retext\Hub\BackendBundle\Repository\UserRepository', $this->getTestObject());
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
        $e     = 'john.doe@example.com';
        $email = new EmailValue($e);
        $User  = new User();
        $User->setEmail($email);
        $repo = $this->getTestObject();
        $repo->persist($User);
        $repo->flush();
        $createdUser = $repo->findByEmail($email);
        $this->assertEquals(1, count($repo->findAll()));
        $this->assertEquals($e, (string)$createdUser->get()->getEmail());
    }

    /**
     * @return UserRepository
     */
    protected function getTestObject()
    {
        /** @var UserRepository $repo */
        $repo = $this->getTestEntityManager()->getRepository('RetextHubBackendBundle:User');
        $repo->setValidator($this->testValidator);
        return $repo;
    }
} 
