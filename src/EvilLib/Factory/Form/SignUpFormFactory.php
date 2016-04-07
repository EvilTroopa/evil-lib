<?php

namespace EvilLib\Factory\Form;

class SignUpFormFactory implements \Zend\ServiceManager\FactoryInterface
{

    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator
     * @return \EvilLib\Form\SignUpForm
     * @throws \LogicException
     */
    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator)
    {
        $oEntityManager = $oServiceLocator->get('Doctrine\ORM\EntityManager');

        $oForm = new \EvilLib\Form\SignUpForm(array('object_repository' => $oServiceLocator->get('\EvilLib\Repository\UserRepository')));
        $oForm->setHydrator(new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($oEntityManager, false));

        return $oForm;
    }
}
