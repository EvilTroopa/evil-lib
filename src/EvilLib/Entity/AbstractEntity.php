<?php

namespace EvilLib\Entity;

/**
 * @\Doctrine\ORM\Mapping\MappedSuperclass
 * @\Doctrine\ORM\Mapping\HasLifecycleCallbacks
 */
abstract class AbstractEntity
{

    /**
     * @var \DateTime
     * @\Doctrine\ORM\Mapping\Column(type="datetime", name="creation_create")
     */
    protected $creationDate;

    /**
     * @var \DateTime
     * @\Doctrine\ORM\Mapping\Column(type="datetime", name="update_create", nullable=true)
     */
    protected $updateDate = null;

    /**
     * @return \DateTime
     * @throws \LogicException
     */
    public function getCreationDate()
    {
        if ($this->creationDate instanceof \DateTime) {
            return $this->creationDate;
        }
        throw new \LogicException('Property creationDate expects an instance of \DateTime, "' . is_object($this->creationDate) ? get_class($this->creationDate) : gettype($this->creationDate) . '" defined');
    }

    /**
     * @param \DateTime $oCreationDate
     * @return \EvilLib\Entity\AbstractEntity
     */
    public function setCreationDate(\DateTime $oCreationDate)
    {
        $this->creationDate = $oCreationDate;
        return $this;
    }

    /**
     * @return \DateTime|null
     * @throws \LogicException
     */
    public function getUpdateDate()
    {
        if ($this->updateDate === null || $this->updateDate instanceof \DateTime) {
            return $this->updateDate;
        }
        throw new \LogicException('Property updateDate expects an instance of \DateTime or null value, "' . is_object($this->updateDate) ? get_class($this->updateDate) : gettype($this->updateDate) . '" defined');
    }

    /**
     * @param \DateTime|null $oUpdateDate
     * @return \EvilLib\Entity\AbstractEntity
     */
    public function setUpdateDate(\DateTime $oUpdateDate)
    {
        $this->updateDate = $oUpdateDate;
        return $this;
    }

    /**
     * @\Doctrine\ORM\Mapping\PrePersist
     */
    public function onCreateEntity()
    {
        $this->creationDate = new \DateTime();
    }

    /**
     * @\Doctrine\ORM\Mapping\PreUpdate
     */
    public function onUpdateEntity()
    {
        $this->updateDate = new \DateTime();
    }
}
