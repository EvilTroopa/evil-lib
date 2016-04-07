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

//        $oRoleEntity = $oServiceLocator->get('\EvilLib\Repository\RoleRepository')->find(1);
//        $oUserEntity->getUserRoles()->add($oRoleEntity);
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
            'from' => 'email@myserver.com',
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
}
