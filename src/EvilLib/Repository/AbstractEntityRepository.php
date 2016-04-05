<?php

namespace EvilLib\Repository;

class AbstractEntityRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     * @param \EvilLib\Entity\AbstractEntity $oEntity
     * @return \EvilLib\Repository\AbstractEntityRepository
     * @throws \InvalidArgumentException
     */
    public function createEntity(\EvilLib\Entity\AbstractEntity $oEntity)
    {
        $sEntityName = $this->getEntityName();
        if ($oEntity instanceof $sEntityName) {
            $this->getEntityManager()->persist();
            $this->getEntityManager()->flush();
            return $this;
        }
        throw new \InvalidArgumentException('Argument $oEntity expects an instance of "' . $this->getEntityName() . '", "' . (is_object($oEntity) ? get_class($oEntity) : gettype($oEntity)) . '" given');
    }

    /**
     * @param \EvilLib\Entity\AbstractEntity $oEntity
     * @return \EvilLib\Repository\AbstractEntityRepository
     * @throws \InvalidArgumentException
     */
    public function updateEntity(\EvilLib\Entity\AbstractEntity $oEntity)
    {
        $sEntityName = $this->getEntityName();
        if ($oEntity instanceof $sEntityName) {
            $this->getEntityManager()->flush();
            return $this;
        }
        throw new \InvalidArgumentException('Argument $oEntity expects an instance of "' . $this->getEntityName() . '", "' . (is_object($oEntity) ? get_class($oEntity) : gettype($oEntity)) . '" given');
    }
}
