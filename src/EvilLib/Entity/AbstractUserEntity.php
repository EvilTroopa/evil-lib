<?php

namespace EvilLib\Entity;

/**
 * @\Doctrine\ORM\Mapping\MappedSuperclass
 */
abstract class AbstractUserEntity extends \EvilLib\Entity\AbstractEntity implements \EvilLib\Entity\UserEntityInterface
{

    /**
     * @var integer
     * @\Doctrine\ORM\Mapping\Id
     * @\Doctrine\ORM\Mapping\Column(type="integer", name="user_id")
     * @\Doctrine\ORM\Mapping\GeneratedValue
     */
    protected $userId;

    /**
     * @var string
     * @\Doctrine\ORM\Mapping\Column(type="string", name="user_email", length=255)
     */
    protected $userEmail;

    /**
     * @var string
     * @\Doctrine\ORM\Mapping\Column(type="string", name="user_password", length=255)
     */
    protected $userPassword;

    /**
     * @var string
     * @\Doctrine\ORM\Mapping\Column(type="string", name="user_name", length=255)
     */
    protected $userName;

    /**
     * @return integer
     * @throws \LogicException
     */
    public function getUserId()
    {
        if (is_int($this->userId)) {
            return $this->userId;
        }
        throw new \LogicException('Property userId expects an integer value, "' . gettype($this->userId) . '" defined');
    }

    /**
     * @return string
     * @throws \LogicException
     */
    public function getUserEmail()
    {
        if (is_string($this->userEmail)) {
            return $this->userEmail;
        }

        throw new \LogicException('Property userEmail expects a string value, "' . gettype($this->userEmail) . '" defined');
    }

    /**
     * @param string $sUserEmail
     * @return \EvilLib\Entity\AbstractUserEntity
     * @throws \LogicException
     */
    public function setUserEmail($sUserEmail)
    {
        if (is_string($sUserEmail)) {
            $this->userEmail = $sUserEmail;
            return $this;
        }

        throw new \LogicException('Argument $sUserEmail expects a string value, "' . gettype($sUserEmail) . '" given');
    }

    /**
     * @return string
     * @throws \LogicException
     */
    public function getUserPassword()
    {
        if (is_string($this->userPassword)) {
            return $this->userPassword;
        }

        throw new \LogicException('Property userPassword expects a string value, "' . gettype($this->userPassword) . '" defined');
    }

    /**
     * @param string $sUserPassword
     * @return \EvilLib\Entity\AbstractUserEntity
     * @throws \LogicException
     */
    public function setUserPassword($sUserPassword)
    {
        if (is_string($sUserPassword)) {
            $this->userPassword = $sUserPassword;
            return $this;
        }

        throw new \LogicException('Argument $sUserPassword expects a string value, "' . gettype($sUserPassword) . '" given');
    }

    /**
     * @return string
     * @throws \LogicException
     */
    public function getUserName()
    {
        if (is_string($this->userName)) {
            return $this->userName;
        }

        throw new \LogicException('Property userName expects a string value, "' . gettype($this->userName) . '" defined');
    }

    /**
     * @param string $sUserName
     * @return \EvilLib\Entity\AbstractUserEntity
     * @throws \LogicException
     */
    public function setUserName($sUserName)
    {
        if (is_string($sUserName)) {
            $this->userName = $sUserName;
            return $this;
        }

        throw new \LogicException('Argument $sUserName expects a string value, "' . gettype($sUserName) . '" given');
    }
}
