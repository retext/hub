<?php

namespace Retext\Hub\BackendBundle\Tests\Tests;

use Dothiv\ValueObject\IdentValue;
use Retext\Hub\BackendBundle\Entity\Organization;
use Retext\Hub\BackendBundle\Repository\OrganizationRepository;
use Retext\Hub\BackendBundle\Tests\Repository\Traits\RepositoryTestTrait;

class OrganizationTest extends \PHPUnit_Framework_TestCase
{
    use RepositoryTestTrait;

    /**
     * @test
     * @group Entity
     * @group BackendBundle
     * @group User
     */
    public function itShouldBeInstantiateable()
    {
        $this->assertInstanceOf('\Retext\Hub\BackendBundle\Repository\OrganizationRepository', $this->getTestObject());
    }

    /**
     * @test
     * @group   Entity
     * @group   BackendBundle
     * @group   Integration
     * @depends itShouldBeInstantiateable
     */
    public function itShouldPersist()
    {
        $organization = new Organization();
        $organization->setHandle(new IdentValue('someorg'));
        $repo = $this->getTestObject();
        $repo->persist($organization);
        $repo->flush();
        $this->assertEquals(1, count($repo->findAll()));
    }

    /**
     * @return OrganizationRepository
     */
    protected function getTestObject()
    {
        /** @var OrganizationRepository $repo */
        $repo = $this->getTestEntityManager()->getRepository('RetextHubBackendBundle:Organization');
        $repo->setValidator($this->testValidator);
        return $repo;
    }
} 
