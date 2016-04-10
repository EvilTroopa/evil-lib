<?php

/*
 * The MIT License
 *
 * Copyright 2016 EvilTroopa.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace EvilLib\Service;

/**
 * Description of UserService
 *
 * @author EvilTroopa
 */
class UserService extends \EvilLib\Service\AbstractService implements \BjyAuthorize\Provider\Identity\ProviderInterface
{

    /**
     * @param \EvilLib\Entity\UserEntityInterface $oUserEntity
     * @param string $sPassword
     * @return boolean
     * @throws \InvalidArgumentException
     */
    public function checkUserPassword(\EvilLib\Entity\UserEntityInterface $oUserEntity, $sPassword)
    {
        if (!is_string($sPassword)) {
            throw new \InvalidArgumentException('Argument $sPassword expects a string value . "' . gettype($sPassword) . '" given');
        }

        return $oUserEntity->getUserPassword() === $this->getServiceLocator()->get('Encryptor')->hash($sPassword);
    }

    /**
     * @param \EvilLib\Entity\UserEntityInterface $oUserEntity
     * @return \EvilLib\Service\UserService
     * @throws \LogicException
     */
    public function processUserSignUp(\EvilLib\Entity\UserEntityInterface $oUserEntity)
    {
        // Retrieve Service locator and User Repository
        $oServiceLocator = $this->getServiceLocator();
        $oUserRepository = $oServiceLocator->get('\Doctrine\ORM\EntityManager')->getRepository(get_class($oUserEntity));

        if (!($oUserRepository instanceof \EvilLib\Repository\AbstractEntityRepository)) {
            throw new \LogicException('User Repository expects an instance of \EvilLib\Repository\AbstractEntityRepository');
        }

        // Prepare sign up hash key
        $oCurrentDate = new \DateTime();
        $sUserSignUpHashKey = sha1(uniqid() . $oUserEntity->getUserEmail()) . '-' . sha1($oCurrentDate->format('Y-m-d\TH:i:s'));

        // Update user entity date
        $oUserEntity->setUserSignUpHashKey($sUserSignUpHashKey)
                ->setUserPassword($oServiceLocator->get('Encryptor')->hash($oUserEntity->getUserPassword()));

        // Add default role
        $sRoleEntityClassName = $this->getRoleEntityClassName();
        $oRoleEntity = $oServiceLocator->get('\Doctrine\ORM\EntityManager')->getRepository($sRoleEntityClassName)->find(1);
        $oUserEntity->getUserRoles()->add($oRoleEntity);
//        Persist user entity
        $oUserRepository->createEntity($oUserEntity);
        // Send sign-up mail
        $this->sendSignUpValidateEmail($oUserEntity);

        return $this;
    }

    /**
     * Override this (and the view) to send your own email
     * @param \EvilLib\Entity\UserEntityInterface $oUserEntity
     * @return \EvilLib\Service\UserService
     */
    public function sendSignUpValidateEmail(\EvilLib\Entity\UserEntityInterface $oUserEntity)
    {
        // Retrieve Service locator and User Repository
        $oServiceLocator = $this->getServiceLocator();

        // Prepare validate link
        $sValidateLink = $oServiceLocator->get('Router')->assemble(array('hash' => $oUserEntity->getUserSignUpHashKey()), array('name' => 'Home/SignUp/Validate', 'force_canonical' => true));
        $oMailViewModel = new \Zend\View\Model\ViewModel();
        $oMailViewModel->setTemplate('evillib/mail/sign-up-validate')->setVariable('validateUrl', $sValidateLink);

        $oServiceLocator->get('MailService')->sendMail($oMailViewModel, array(
            'to' => $oUserEntity->getUserEmail(),
            'subject' => 'My website - Validate account',
        ));

        return $this;
    }

    /**
     * @param string $sUserEmail
     * @param string $sUserPassword
     * @return boolean
     * @throws \InvalidArgumentException
     * @throws \LogicException
     */
    public function authenticate($sUserEmail, $sUserPassword)
    {
        if (!is_string($sUserEmail)) {
            throw new \InvalidArgumentException('Argument $sUserEmail expects a string value, "' . gettype($sUserEmail) . '"');
        }
        if (!is_string($sUserPassword)) {
            throw new \InvalidArgumentException('Argument $sUserPassword expects a string value, "' . gettype($sUserPassword) . '"');
        }

        $oAuthenticationService = $this->getServiceLocator()->get('AuthenticationService');
        $oAuthenticationService->getAdapter()->setIdentity($sUserEmail)->setCredential($sUserPassword);
        $oAuthenticationResult = $oAuthenticationService->authenticate();

        if ($oAuthenticationResult instanceof \Zend\Authentication\Result) {
            return ($oAuthenticationResult->getCode() === \Zend\Authentication\Result::SUCCESS);
        }
        throw new \LogicException('$oAuthenticationResult expects an instance \Zend\Authentication\Result, "' . (is_object($oAuthenticationResult) ? get_class($oAuthenticationResult) : gettype($oAuthenticationResult)));
    }

    /**
     * @return \EvilLib\Entity\UserEntity
     */
    public function getUser()
    {
        return $this->getServiceLocator()->get('AuthenticationService')->getIdentity();
    }

    /**
     * @return \EvilLib\Service\UserService
     */
    public function logOut()
    {
        $this->getServiceLocator()->get('AuthenticationService')->clearIdentity();
        return $this;
    }

    /**
     * @return array
     */
    public function getIdentityRoles()
    {
        $oServiceLocator = $this->getServiceLocator();
        $oAuthenticationService = $this->getServiceLocator()->get('AuthenticationService');
        if ($oAuthenticationService->hasIdentity()) {
            $sUserClassName = get_class($oAuthenticationService->getIdentity());
            $oUserEntity = $oServiceLocator->get('\Doctrine\ORM\EntityManager')->getRepository($sUserClassName)->find($oAuthenticationService->getIdentity()->getUserId());

            $aRoles = array();
            foreach ($oUserEntity->getUserRoles() as $oUserRole) {
                $aRoles[] = $oUserRole->getRoleName();
            }
            return $aRoles;
        }
        return array('guest');
    }

    /**
     * @return string
     * @throws \LogicException
     */
    public function getUserEntityClassName()
    {
        // Retrieve config
        $aConfig = $this->getServiceLocator()->get('configuration');

        // Check config
        if (!array_key_exists('authentication', $aConfig)) {
            throw new \LogicException('Config should contain an entry named "authentication"');
        }
        if (!array_key_exists('entities', $aConfig['authentication'])) {
            throw new \LogicException('Config authentication should contain an entry named "entities"');
        }
        if (!array_key_exists('user_entity', $aConfig['authentication']['entities']) || !is_string($aConfig['authentication']['entities']['user_entity'])) {
            throw new \LogicException('Config authentication entities should contain an string entry named "user_entity"');
        }

        // Check user entity class
        if (!class_exists($aConfig['authentication']['entities']['user_entity'])) {
            throw new \LogicException('Defined user entity class name does not exists : "' . $aConfig['authentication']['entities']['user_entity'] . '"');
        }
        if (!is_subclass_of($aConfig['authentication']['entities']['user_entity'], '\EvilLib\Entity\AbstractUserEntity')) {
            throw new \LogicException('Defined user entity class name should be an instance of \EvilLib\Entity\AbstractUserEntity');
        }

        return $aConfig['authentication']['entities']['user_entity'];
    }

    /**
     * @return string
     * @throws \LogicException
     */
    public function getRoleEntityClassName()
    {
        // Retrieve config
        $aConfig = $this->getServiceLocator()->get('configuration');

        // Check config
        if (!array_key_exists('authentication', $aConfig)) {
            throw new \LogicException('Config should contain an entry named "authentication"');
        }
        if (!array_key_exists('entities', $aConfig['authentication'])) {
            throw new \LogicException('Config authentication should contain an entry named "entities"');
        }
        if (!array_key_exists('role_entity', $aConfig['authentication']['entities']) || !is_string($aConfig['authentication']['entities']['role_entity'])) {
            throw new \LogicException('Config authentication entities should contain an string entry named "role_entity"');
        }

        // Check user entity class
        if (!class_exists($aConfig['authentication']['entities']['role_entity'])) {
            throw new \LogicException('Defined role entity class name does not exists : "' . $aConfig['authentication']['entities']['role_entity'] . '"');
        }
        if (!is_subclass_of($aConfig['authentication']['entities']['role_entity'], '\EvilLib\Entity\AbstractRoleEntity')) {
            throw new \LogicException('Defined role entity class name should be an instance of \EvilLib\Entity\AbstractRoleEntity');
        }

        return $aConfig['authentication']['entities']['role_entity'];
    }

    /**
     * @param string $sUserSignUpHashKey
     * @return boolean
     * @throws \InvalidArgumentException
     */
    public function validateUser($sUserSignUpHashKey)
    {
        // Check arguments
        if (!is_string($sUserSignUpHashKey)) {
            throw new \InvalidArgumentException('Argument $sUserSignUpHashKey expects a string value, "' . gettype($sUserSignUpHashKey) . '" given');
        }

        // Retrieve user from hash key
        $oUserRepository = $this->getServiceLocator()->get('\Doctrine\ORM\EntityManager')->getRepository($this->getUserEntityClassName());
        $oUserEntity = $oUserRepository->findOneBy(array('userSignUpHashKey' => $sUserSignUpHashKey, 'userStatus' => \EvilLib\Entity\AbstractUserEntity::USER_STATUS_PENDING));

        if ($oUserEntity instanceof \EvilLib\Entity\AbstractUserEntity) {
            $oUserRepository->updateEntity($oUserEntity->setUserStatus(\EvilLib\Entity\AbstractUserEntity::USER_STATUS_ACTIVE));
            return true;
        }
        return false;
    }

    /**
     *
     * @param array $aUserData
     * @return boolean
     * @throws \InvalidArgumentException
     */
    public function processUserLostPassword(array $aUserData)
    {
        // Check arguments
        if (!array_key_exists('userEmail', $aUserData)) {
            throw new \InvalidArgumentException('Argument $aUserData should contain an entry named "userEmail"');
        }
        $sUserEmail = $aUserData['userEmail'];
        if (!is_string($sUserEmail)) {
            throw new \InvalidArgumentException('Argument $aUserData[userEmail] expects a string value, "' . gettype($sUserEmail) . '" given');
        }

        // Retrieve Service locator and User Repository
        $oServiceLocator = $this->getServiceLocator();
        $oUserRepository = $oServiceLocator->get('\Doctrine\ORM\EntityManager')->getRepository($this->getUserEntityClassName());

        $oUserEntity = $oUserRepository->findOneBy(array('userEmail' => $sUserEmail));

        if (!($oUserEntity instanceof \EvilLib\Entity\UserEntityInterface)) {
            return false;
        }

        // Prepare renew password hash key
        $oCurrentDate = new \DateTime();
        $sUserRenewPasswordHashKey = sha1(uniqid() . $oUserEntity->getUserEmail()) . '-' . sha1($oCurrentDate->format('Y-m-d\TH:i:s'));

        // Update user entity date
        $oUserEntity->setUserPasswordHashKey($sUserRenewPasswordHashKey);

        // Persist user entity
        $oUserRepository->updateEntity($oUserEntity);
        // Send sign-up mail
        $this->sendRenewPasswordEmail($oUserEntity);

        return true;
    }

    /**
     * Override this (and the view) to send your own email
     * @param \EvilLib\Entity\UserEntityInterface $oUserEntity
     * @return \EvilLib\Service\UserService
     */
    public function sendRenewPasswordEmail(\EvilLib\Entity\UserEntityInterface $oUserEntity)
    {
        // Retrieve Service locator and User Repository
        $oServiceLocator = $this->getServiceLocator();

        // Prepare validate link
        $sRenewPasswordLink = $oServiceLocator->get('Router')->assemble(array('hash' => $oUserEntity->getUserPasswordHashKey()), array('name' => 'Home/RenewPassword', 'force_canonical' => true));
        $oMailViewModel = new \Zend\View\Model\ViewModel();
        $oMailViewModel->setTemplate('evillib/mail/renew-password')->setVariable('renewPasswordUrl', $sRenewPasswordLink);

        $oServiceLocator->get('MailService')->sendMail($oMailViewModel, array(
            'to' => $oUserEntity->getUserEmail(),
            'subject' => 'My website - Renew password',
        ));

        return $this;
    }
}
