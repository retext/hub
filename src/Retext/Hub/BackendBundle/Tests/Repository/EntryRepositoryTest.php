<?php

namespace Retext\Hub\BackendBundle\Tests\Tests;

use Doctrine\Common\Collections\ArrayCollection;
use Dothiv\ValueObject\IdentValue;
use Retext\Hub\BackendBundle\Entity\Entry;
use Retext\Hub\BackendBundle\Entity\Organization;
use Retext\Hub\BackendBundle\Entity\Project;
use Retext\Hub\BackendBundle\Entity\EntryType;
use Retext\Hub\BackendBundle\Repository\EntryRepository;
use Retext\Hub\BackendBundle\Repository\OrganizationRepository;
use Retext\Hub\BackendBundle\Repository\ProjectRepository;
use Retext\Hub\BackendBundle\Repository\EntryTypeRepository;
use Retext\Hub\BackendBundle\Tests\Repository\Traits\RepositoryTestTrait;

class EntryRepositoryTest extends \PHPUnit_Framework_TestCase
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
        $this->assertInstanceOf('\Retext\Hub\BackendBundle\Repository\EntryRepository', $this->getTestObject());
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

        $entry = new Entry();
        $entry->setHandle(new IdentValue('someentry'));
        $entry->setProject($project);
        $entry->setType($type);
        $entry->setFields(new ArrayCollection(array('some' => 'value')));
        $repo = $this->getTestObject();
        $repo->persist($entry);
        $repo->flush();
        $this->assertEquals(1, count($repo->findAll()));
    }

    /**
     * @return EntryRepository
     */
    protected function getTestObject()
    {
        /** @var EntryRepository $repo */
        $repo = $this->getTestEntityManager()->getRepository('RetextHubBackendBundle:Entry');
        $repo->setValidator($this->testValidator);
        return $repo;
    }
}
