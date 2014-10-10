<?php

namespace Retext\Hub\BackendBundle\Tests\Tests;

use Dothiv\ValueObject\IdentValue;
use Retext\Hub\BackendBundle\Entity\EntryType;
use Retext\Hub\BackendBundle\Entity\Organization;
use Retext\Hub\BackendBundle\Entity\Project;
use Retext\Hub\BackendBundle\Entity\EntryField;
use Retext\Hub\BackendBundle\Repository\EntryTypeRepository;
use Retext\Hub\BackendBundle\Repository\OrganizationRepository;
use Retext\Hub\BackendBundle\Repository\ProjectRepository;
use Retext\Hub\BackendBundle\Repository\EntryFieldRepository;
use Retext\Hub\BackendBundle\Tests\Repository\Traits\RepositoryTestTrait;

class EntryFieldRepositoryTest extends \PHPUnit_Framework_TestCase
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
        $this->assertInstanceOf('\Retext\Hub\BackendBundle\Repository\EntryFieldRepository', $this->getTestObject());
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

        /** @var EntryTypeRepository $typeRepo */
        $typeRepo = $this->getTestEntityManager()->getRepository('RetextHubBackendBundle:EntryType');
        $typeRepo->setValidator($this->testValidator);
        $type = new EntryType();
        $type->setHandle(new IdentValue('someorg'));
        $type->setProject($project);
        $typeRepo->persist($type)->flush();

        $entryField = new EntryField();
        $entryField->setHandle(new IdentValue('someentrytype'));
        $entryField->setType($type);
        $repo = $this->getTestObject();
        $repo->persist($entryField);
        $repo->flush();
        $this->assertEquals(1, count($repo->findAll()));
    }

    /**
     * @return EntryFieldRepository
     */
    protected function getTestObject()
    {
        /** @var EntryFieldRepository $repo */
        $repo = $this->getTestEntityManager()->getRepository('RetextHubBackendBundle:EntryField');
        $repo->setValidator($this->testValidator);
        return $repo;
    }
}
