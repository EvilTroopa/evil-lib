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

namespace EvilLib\Entity;

/**
 * @\Doctrine\ORM\Mapping\MappedSuperclass
 */
abstract class AbstractRoleEntity implements \Zend\Permissions\Acl\Role\RoleInterface
{

    /**
     * @var integer
     * @\Doctrine\ORM\Mapping\Id
     * @\Doctrine\ORM\Mapping\Column(type="integer", name="role_id")
     * @\Doctrine\ORM\Mapping\GeneratedValue
     */
    protected $roleId;

    /**
     * @var string
     * @\Doctrine\ORM\Mapping\Column(type="string", name="role_name", length=255)
     */
    protected $roleName;

    /**
     * @var \Doctrine\Common\Collection\ArrayCollection
     * @\Doctrine\ORM\Mapping\ManyToMany(targetEntity="\EvilLib\Entity\AbstractUserEntity", mappedBy="usersRoles")
     */
    protected $roleUsers;

    /**
     * @return integer
     * @throws \LogicException
     */
    public function getRoleId()
    {
        if (is_int($this->roleId)) {
            return $this->roleId;
        }
        throw new \LogicException('Property roleId expects an integer value, "' . gettype($this->roleId) . '" defined');
    }

    /**
     * @return string
     * @throws \LogicException
     */
    public function getRoleName()
    {
        if (is_string($this->roleName)) {
            return $this->roleName;
        }
        throw new \LogicException('Property roleName expects a string value, "' . gettype($this->roleName) . '" defined');
    }

    /**
     * @param string $sRoleName
     * @return \EvilLib\Entity\RoleEntity
     * @throws \InvalidArgumentException
     */
    public function setRoleName($sRoleName)
    {
        if (is_string($sRoleName)) {
            $this->roleName = $sRoleName;
            return $this;
        }
        throw new \InvalidArgumentException('Argument $sRoleName expects a string value, "' . $sRoleName . '" given');
    }

    /**
     * @return \Doctrine\Common\Collection\ArrayCollection
     * @throws \LogicException
     */
    public function getRoleUsers()
    {
        if ($this->roleUsers instanceof \Doctrine\Common\Collection\Collection) {
            return $this->roleUsers;
        }
        throw new \LogicException('Property roleUsers expects an instance of \Doctrine\Common\Collection\Collection, "' . (is_object($this->roleUsers) ? get_class($this->roleUsers) : gettype($this->roleUsers)));
    }
}
