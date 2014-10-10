<?php

namespace Retext\Hub\BackendBundle\Tests\Tests;

use Dothiv\ValueObject\IdentValue;
use Retext\Hub\BackendBundle\Entity\Organization;
use Retext\Hub\BackendBundle\Entity\Project;
use Retext\Hub\BackendBundle\Entity\EntryType;
use Retext\Hub\BackendBundle\Repository\OrganizationRepository;
use Retext\Hub\BackendBundle\Repository\ProjectRepository;
use Retext\Hub\BackendBundle\Repository\EntryTypeRepository;
use Retext\Hub\BackendBundle\Tests\Repository\Traits\RepositoryTestTrait;

class EntryTypeRepositoryTest extends \PHPUnit_Framework_TestCase
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
        $this->assertInstanceOf('\Retext\Hub\BackendBundle\Repository\EntryTypeRepository', $this->getTestObject());
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

        /** @var ProjectRepository $orgRepo */
        $orgRepo = $this->getTestEntityManager()->getRepository('RetextHubBackendBundle:Project');
        $orgRepo->setValidator($this->testValidator);
        $project = new Project();
        $project->setHandle(new IdentValue('someorg'));
        $project->setOrganization($organization);
        $orgRepo->persist($project)->flush();

        $entryType = new EntryType();
        $entryType->setHandle(new IdentValue('someentrytype'));
        $entryType->setProject($project);
        $repo = $this->getTestObject();
        $repo->persist($entryType);
        $repo->flush();
        $this->assertEquals(1, count($repo->findAll()));
    }

    /**
     * @return EntryTypeRepository
     */
    protected function getTestObject()
    {
        /** @var EntryTypeRepository $repo */
        $repo = $this->getTestEntityManager()->getRepository('RetextHubBackendBundle:EntryType');
        $repo->setValidator($this->testValidator);
        return $repo;
    }
}
