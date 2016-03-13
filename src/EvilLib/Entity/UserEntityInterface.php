<?php

namespace EvilLib\Entity;

interface UserEntityInterface
{

    /**
     * @return integer
     */
    public function getUserId();

    /**
     * @return string
     */
    public function getUserEmail();

    /**
     * @param string $sUserEmail
     * @return \EvilLib\Entity\UserEntityInterface
     */
    public function setUserEmail($sUserEmail);

    /**
     * @return string
     */
    public function getUserPassword();

    /**
     * @param string $sUserPassword
     * @return \EvilLib\Entity\UserEntity
     */
    public function setUserPassword($sUserPassword);

    /**
     * @return string
     */
    public function getUserName();

    /**
     * @param string $sUserName
     * @return \EvilLib\Entity\UserEntity
     */
    public function setUserName($sUserName);
}
