<?php

namespace EvilLib\Factory\Form;

class EditUserFormFactory implements \Zend\ServiceManager\FactoryInterface
{

    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator
     * @return \EvilLib\Form\EditUserForm
     * @throws \LogicException
     */
    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator)
    {
        $oEntityManager = $oServiceLocator->get('Doctrine\ORM\EntityManager');

        $oForm = new \EvilLib\Form\EditUserForm();
        $oForm->setHydrator(new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($oEntityManager, false));

        return $oForm;
    }
}
