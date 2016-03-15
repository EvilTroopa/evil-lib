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

namespace EvilLib\Authentication;

/**
 * Description of AuthenticationServiceFactory
 *
 * @author EvilTroopa
 */
class AuthenticationService
{

    /**
     * @var \Zend\Authentication\AuthenticationService
     */
    protected $authenticationService;

    /**
     * Constructor
     * @param \Zend\Authentication\AuthenticationService $oAuthenticationService
     */
    public function __construct(\Zend\Authentication\AuthenticationService $oAuthenticationService)
    {
        $this->authenticationService = $oAuthenticationService;
    }

    /**
     * @param string $sUserIdentity
     * @param string $sUserPassword
     * @return mixed
     */
    public function authenticate($sUserIdentity, $sUserPassword)
    {
        if (!is_string($sUserIdentity)) {
            throw new \InvalidArgumentException('Argument $sUserIdentity expects a string value, "' . gettype($sUserIdentity) . '" given');
        }
        if (!is_string($sUserPassword)) {
            throw new \InvalidArgumentException('Argument $sUserPassword expects a string value, "' . gettype($sUserPassword) . '" given');
        }

        $this->authenticationService->getAdapter()->setIdentity($sUserIdentity)->setCredential($sUserPassword);
        return $this->authenticationService->authenticate();
    }

    /**
     * @param \EvilLib\Entity\AbstractUserEntity $oUserEntity
     * @param string $sUserPassword
     * @return booleon
     */
    public function checkPassword(\EvilLib\Entity\AbstractUserEntity $oUserEntity, $sUserPassword)
    {
        return $this->getServiceManager()->get('Encryptor')->hash($sUserPassword) === $oUserEntity->getUserPassword();
    }
}
