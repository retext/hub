<?php

namespace Retext\Hub\BackendBundle\Tests\Tests;

use Dothiv\ValueObject\EmailValue;
use Dothiv\ValueObject\IdentValue;
use PhpOption\Option;
use Retext\Hub\BackendBundle\Entity\Organization;
use Retext\Hub\BackendBundle\Entity\User;
use Retext\Hub\BackendBundle\Entity\Project;
use Retext\Hub\BackendBundle\Repository\OrganizationRepository;
use Retext\Hub\BackendBundle\Repository\OrganizationRepositoryInterface;
use Retext\Hub\BackendBundle\Repository\UserRepository;
use Retext\Hub\BackendBundle\Repository\ProjectRepository;
use Retext\Hub\BackendBundle\Tests\Repository\Traits\RepositoryTestTrait;

class ProjectTest extends \PHPUnit_Framework_TestCase
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
        $this->assertInstanceOf('\Retext\Hub\BackendBundle\Repository\ProjectRepository', $this->getTestObject());
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
        /** @var OrganizationRepository $orgRepo */
        $orgRepo = $this->getTestEntityManager()->getRepository('RetextHubBackendBundle:Organization');
        $orgRepo->setValidator($this->testValidator);
        $organization = new Organization();
        $organization->setHandle(new IdentValue('someorg'));
        $orgRepo->persist($organization)->flush();

        $project = new Project();
        $project->setHandle(new IdentValue('someproject'));
        $project->setOrganization($organization);
        $repo = $this->getTestObject();
        $repo->persist($project);
        $repo->flush();
        $this->assertEquals(1, count($repo->findAll()));
    }

    /**
     * @test
     * @group   Entity
     * @group   BackendBundle
     * @group   Integration
     * @depends itShouldBeInstantiateable
     */
    public function itShouldFindByHandle()
    {
        /** @var OrganizationRepository $orgRepo */
        $orgRepo = $this->getTestEntityManager()->getRepository('RetextHubBackendBundle:Organization');
        $orgRepo->setValidator($this->testValidator);
        $organization = new Organization();
        $organization->setHandle(new IdentValue('someorg'));
        $orgRepo->persist($organization)->flush();

        $project = new Project();
        $project->setHandle(new IdentValue('someproject'));
        $project->setOrganization($organization);
        $repo = $this->getTestObject();
        $repo->persist($project);
        $repo->flush();

        $this->assertEquals(Option::fromValue($project), $repo->findByHandle(new IdentValue('someorg'), new IdentValue('someproject')));
    }

    /**
     * @return ProjectRepository
     */
    protected function getTestObject()
    {
        /** @var ProjectRepository $repo */
        $repo = $this->getTestEntityManager()->getRepository('RetextHubBackendBundle:Project');
        $repo->setValidator($this->testValidator);
        return $repo;
    }
} 
