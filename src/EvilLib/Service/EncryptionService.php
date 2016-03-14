<?php

namespace EvilLib\Service;

class EncryptionService implements \EvilLib\Service\EncryptionServiceInterface
{

    /**
     * @var \EvilLib\Crypt\EncryptorInterface
     */
    protected $encryptor;

    /**
     * @var \EvilLib\Crypt\HashInterface
     */
    protected $hash;

    /**
     * Constructor
     * @param \EvilLib\Crypt\EncryptorInterface $oEncryptor
     * @param \EvilLib\Crypt\HashInterface $oHash
     */
    public function __construct(\EvilLib\Crypt\EncryptorInterface $oEncryptor, \EvilLib\Crypt\HashInterface $oHash)
    {
        $this->setEncryptor($oEncryptor);
        $this->setHash($oHash);
    }

    /**
     * @return \EvilLib\Crypt\EncryptorInterface
     * @throws \LogicException
     */
    protected function getEncryptor()
    {
        if ($this->encryptor instanceof \EvilLib\Crypt\EncryptorInterface) {
            return $this->encryptor;
        }
        throw \LogicException('Property encryptor expects an instance of \EvilLib\Crypt\EncryptorInterface, "' . (is_object($this->encryptor) ? get_class($this->encryptor) : gettype($this->encryptor)) . '" defined');
    }

    /**
     * @param \EvilLib\Crypt\EncryptorInterface $oEncryptor
     * @return \EvilLib\Service\EncryptionService
     */
    protected function setEncryptor(\EvilLib\Crypt\EncryptorInterface $oEncryptor)
    {
        $this->encryptor = $oEncryptor;
        return $this;
    }

    /**
     * @return \EvilLib\Crypt\HashInterface
     * @throws \LogicException
     */
    protected function getHash()
    {
        if ($this->hash instanceof \EvilLib\Crypt\HashInterface) {
            return $this->hash;
        }
        throw \LogicException('Property hash expects an instance of \EvilLib\Crypt\HashInterface, "' . (is_object($this->hash) ? get_class($this->hash) : gettype($this->hash)) . '" defined');
    }

    /**
     * @param \EvilLib\Crypt\HashInterface $oHash
     * @return \EvilLib\Service\EncryptionService
     */
    protected function setHash(\EvilLib\Crypt\HashInterface $oHash)
    {
        $this->hash = $oHash;
        return $this;
    }

    /**
     * @param string $sEncryptedData
     * @return string
     * @throws \InvalidArgumentException
     */
    public function decrypt($sEncryptedData)
    {
        if (is_string($sEncryptedData)) {
            return $this->getEncryptor()->decrypt($sEncryptedData);
        }
        throw new \InvalidArgumentException('Argument $sEncryptedData expects a string value, "' . gettype($sEncryptedData) . '" given');
    }

    /**
     * @param string $sDataToEncrypt
     * @return string
     * @throws \InvalidArgumentException
     */
    public function encrypt($sDataToEncrypt)
    {
        if (is_string($sDataToEncrypt)) {
            return $this->getEncryptor()->encrypt($sDataToEncrypt);
        }
        throw new \InvalidArgumentException('Argument $sDataToEncrypt expects a string value, "' . gettype($sDataToEncrypt) . '" given');
    }

    /**
     * @param string $sDataToHash
     * @return string
     * @throws \InvalidArgumentException
     */
    public function hash($sDataToHash)
    {
        if (is_string($sDataToHash)) {
            return $this->getHash()->hash($sDataToHash);
        }
        throw new \InvalidArgumentException('Argument $sDataToHash expects a string value, "' . gettype($sDataToHash) . '" given');
    }
}
