<?php

namespace EvilLib\Controller;

class ConsoleController extends \EvilLib\Controller\AbstractController
{

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function createDatabaseSchemaAction()
    {
        // Retrieve service locator
        $oServiceLocator = $this->getServiceLocator();

        // Retrieve console
        $oConsole = $oServiceLocator->get('console');

        // Retrieve EntityManager
        $oEntityManager = $oServiceLocator->get('Doctrine\ORM\EntityManager');

        // Check if tables already exist
        if ($oEntityManager->getConnection()->getSchemaManager()->listTables()) {
            // Can't execute createSchema
            $oConsole->writeLine('Schema already exists');
        } else {

            $aMetadatas = $oEntityManager->getMetadataFactory()->getAllMetadata();

            // Instantiate SchemaTool
            $oSchemaTool = new \Doctrine\ORM\Tools\SchemaTool($oEntityManager);
            $oConsole->write('Creating schema...');
            $oSchemaTool->createSchema($aMetadatas);
            $oConsole->writeLine('OK');
        }

        return new \Zend\View\Model\ViewModel();
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function validateDatabaseSchemaAction()
    {
        // Retrieve service locator
        $oServiceLocator = $this->getServiceLocator();

        // Retrieve console
        $oConsole = $oServiceLocator->get('console');

        $oEntityManager = $oServiceLocator->get('Doctrine\ORM\EntityManager');
        $oSchemaValidator = new \Doctrine\ORM\Tools\SchemaValidator($oEntityManager);

        $oConsole->writeLine('Validate Schema');
        $aErrors = $oSchemaValidator->validateMapping();

        if ($aErrors) {
            foreach ($aErrors as $aError) {
                $oConsole->writeLine(implode("\n\n", $aError));
            }
        } else {
            $oConsole->writeLine('No error found');
        }

        return new \Zend\View\Model\ViewModel();
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function updateDatabaseSchemaAction()
    {
        // Retrieve service locator
        $oServiceLocator = $this->getServiceLocator();

        // Retrieve console
        $oConsole = $oServiceLocator->get('console');

        // Retrieve EntityManager
        $oEntityManager = $oServiceLocator->get('Doctrine\ORM\EntityManager');

        // Check if tables already exist
        if (!$oEntityManager->getConnection()->getSchemaManager()->listTables()) {
            // Can't execute createSchema
            $oConsole->writeLine('Schema does not exist yet');
        } else {

            $aMetadatas = $oEntityManager->getMetadataFactory()->getAllMetadata();

            // Instantiate SchemaTool
            $oSchemaTool = new \Doctrine\ORM\Tools\SchemaTool($oEntityManager);
            $oConsole->write('Updating schema...');
            $oConsole->writeLine(implode(PHP_EOL, $oSchemaTool->getUpdateSchemaSql($aMetadatas)));
            $oSchemaTool->updateSchema($aMetadatas);
            $oConsole->writeLine('OK');
        }

        return new \Zend\View\Model\ViewModel();
    }
}
