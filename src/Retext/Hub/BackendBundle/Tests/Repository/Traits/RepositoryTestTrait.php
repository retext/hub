<?php

namespace Retext\Hub\BackendBundle\Tests\Repository\Traits;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\DependencyInjection\ContainerInterface;

trait RepositoryTestTrait
{
    /**
     * @var \AppKernel
     */
    private $testKernel;

    /**
     * @var \Symfony\Component\Validator\Validator
     */
    protected $testValidator = null;

    /**
     * @return EntityManager
     */
    protected function getTestEntityManager()
    {
        return $this->getTestContainer()->get('doctrine.orm.entity_manager');
    }

    /**
     * Get test kernel
     *
     * @return \AppKernel
     */
    protected function getTestKernel()
    {
        if (!$this->testKernel) {
            require_once dirname(__FILE__) . '/../../../../../../../app/AppKernel.php';

            $kernel = new \AppKernel('test', false);
            $kernel->loadClassCache();
            $kernel->boot();

            $this->testKernel = $kernel;

            // Create schema
            $em         = $this->testKernel->getContainer()->get('doctrine.orm.entity_manager');
            $schemaTool = new SchemaTool($em);
            $metadata   = $em->getMetadataFactory()->getAllMetadata();
            $schemaTool->dropSchema($metadata);
            $schemaTool->createSchema($metadata);
        }

        return $this->testKernel;
    }

    /**
     * @return ContainerInterface
     */
    protected function getTestContainer()
    {
        return $this->getTestKernel()->getContainer();
    }

    public function setUp()
    {
        $this->testValidator = $this->getTestContainer()->get('validator');
    }

    protected function tearDown()
    {
        if ($this->testKernel) {
            $em         = $this->getTestEntityManager();
            $schemaTool = new SchemaTool($em);
            $metadata   = $em->getMetadataFactory()->getAllMetadata();
            $schemaTool->dropSchema($metadata);
            $this->testKernel->shutdown();
        }
    }
} 
