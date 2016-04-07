<?php

namespace EvilLib\Entity;

/**
 * @\Doctrine\ORM\Mapping\Entity(repositoryClass="\EvilLib\Repository\UserRepository")
 * @\Doctrine\ORM\Mapping\Table(name="users")
 */
class UserEntity extends \EvilLib\Entity\AbstractEntity implements \EvilLib\Entity\UserEntityInterface
{

    /**
     * @var integer
     */
    const USER_STATUS_PENDING = 0;

    /**
     * @var integer
     */
    const USER_STATUS_ACTIVE = 1;

    /**
     * @var integer
     */
    const USER_STATUS_BLOCKED = 2;

    /**
     * @var integer
     */
    const USER_STATUS_DISABLED = -1;

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
     * @var integer
     * @\Doctrine\ORM\Mapping\Column(type="integer", name="user_status")
     */
    protected $userStatus = self::USER_STATUS_PENDING;

    /**
     * @var string
     * @\Doctrine\ORM\Mapping\Column(type="string", name="user_sign_up_hash_key", length=255)
     */
    protected $userSignUpHashKey;

    /**
     * @var string
     * @\Doctrine\ORM\Mapping\Column(type="string", name="user_password_hash_key", length=255, nullable=true)
     */
    protected $userPasswordHashKey;

    /**
     * @var \Doctrine\Common\Collection\ArrayCollection
     * @\Doctrine\ORM\Mapping\ManyToMany(targetEntity="\EvilLib\Entity\RoleEntity", inversedBy="roleUsers")
     * @\Doctrine\ORM\Mapping\JoinTable(name="users_roles",
     *      joinColumns={@\Doctrine\ORM\Mapping\JoinColumn(name="user_id", referencedColumnName="user_id")},
     *      inverseJoinColumns={@\Doctrine\ORM\Mapping\JoinColumn(name="role_id", referencedColumnName="role_id")}
     *      )
     */
    protected $userRoles;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userRoles = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return \EvilLib\Entity\UserEntity
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
     * @return \EvilLib\Entity\UserEntity
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
     * @return \EvilLib\Entity\UserEntity
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

    /**
     * @return \Doctrine\Common\Collection\ArrayCollection
     * @throws \LogicException
     */
    public function getUserRoles()
    {
        if ($this->userRoles instanceof \Doctrine\Common\Collections\Collection) {
            return $this->userRoles;
        }
        throw new \LogicException('Property userRoles expects an instance of \Doctrine\Common\Collections\Collection, "' . (is_object($this->userRoles) ? get_class($this->userRoles) : gettype($this->userRoles)));
    }

    /**
     * @return integer
     * @throws \LogicException
     */
    public function getUserStatus()
    {
        if (is_int($this->userStatus)) {
            return $this->userStatus;
        }
        throw new \LogicException('Property userStatus expects an integer value, "' . gettype($this->userStatus) . '" defined');
    }

    /**
     * @param integer $iUserStatus
     * @return \EvilLib\Entity\UserEntity
     * @throws \InvalidArgumentException
     */
    public function setUserStatus($iUserStatus)
    {
        if (is_int($iUserStatus)) {
            $this->userStatus = $iUserStatus;
            return $this;
        }
        throw new \InvalidArgumentException('Argument $iUserStatus expects an integer value, "' . gettype($iUserStatus) . '" given');
    }

    /**
     * @return string
     * @throws \LogicException
     */
    public function getUserSignUpHashKey()
    {
        if (is_string($this->userSignUpHashKey)) {
            return $this->userSignUpHashKey;
        }

        throw new \LogicException('Property userSignUpHashKey expects a string value, "' . gettype($this->userSignUpHashKey) . '" defined');
    }

    /**
     * @param string $sUserSignUpHashKey
     * @return \EvilLib\Entity\UserEntity
     * @throws \LogicException
     */
    public function setUserSignUpHashKey($sUserSignUpHashKey)
    {
        if (is_string($sUserSignUpHashKey)) {
            $this->userSignUpHashKey = $sUserSignUpHashKey;
            return $this;
        }

        throw new \LogicException('Argument $sUserSignUpHashKey expects a string value, "' . gettype($sUserSignUpHashKey) . '" given');
    }

    /**
     * @return string
     * @throws \LogicException
     */
    public function getUserPasswordHashKey()
    {
        if (is_string($this->userPasswordHashKey)) {
            return $this->userPasswordHashKey;
        }

        throw new \LogicException('Property userPasswordHashKey expects a string value, "' . gettype($this->userPasswordHashKey) . '" defined');
    }

    /**
     * @param string $sUserPasswordHashKey
     * @return \EvilLib\Entity\UserEntity
     * @throws \LogicException
     */
    public function setUserPasswordHashKey($sUserPasswordHashKey)
    {
        if (is_string($sUserPasswordHashKey)) {
            $this->userPasswordHashKey = $sUserPasswordHashKey;
            return $this;
        }

        throw new \LogicException('Argument $sUserPasswordHashKey expects a string value, "' . gettype($sUserPasswordHashKey) . '" given');
    }
}
