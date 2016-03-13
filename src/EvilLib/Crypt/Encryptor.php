<?php

namespace EvilLib\Crypt;

class Encryptor implements \EvilLib\Crypt\EncryptorInterface
{

    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $algo;

    /**
     * @var string
     */
    protected $mode;

    /**
     * @var string
     */
    protected $hash;

    /**
     * @var \Zend\Crypt\BlockCipher
     */
    protected $blockCipher;

    /**
     * Constructor
     * @param string $sMethod
     * @param array $aOptions
     */
    public function __construct($sMethod, array $aOptions)
    {
        if (is_string($sMethod)) {
            $this->setMethod($sMethod);
        }
        if (array_key_exists('algo', $aOptions)) {
            $this->setAlgo($aOptions['algo']);
        }
        if (array_key_exists('hash', $aOptions)) {
            $this->setHash($aOptions['hash']);
        }
        if (array_key_exists('mode', $aOptions)) {
            $this->setMode($aOptions['mode']);
        }
        if (array_key_exists('salt', $aOptions)) {
            $this->setSalt($aOptions['salt']);
        }

        $this->blockCipher = \Zend\Crypt\BlockCipher::factory($this->getMethod(), array(
                    'algo' => $this->getAlgo(),
                    'mode' => $this->getMode(),
                    'hash' => $this->getHash(),
        ));
        $this->blockCipher->setKey($this->getSalt());
    }

    /**
     * @return string
     * @throws \LogicException
     */
    public function getMethod()
    {
        if (!is_string($this->method)) {
            throw new \LogicException('Argument $sMethod expects a string value, "' . gettype($this->method) . '" given');
        }
        return $this->method;
    }

    /**
     * @param string $sMethod
     * @return \EvilLib\Crypt\Hash
     * @throws \InvalidArgumentException
     */
    public function setMethod($sMethod)
    {
        if (!is_string($sMethod)) {
            throw new \InvalidArgumentException('Argument $sMethod expects a string value, "' . gettype($sMethod) . '" given');
        }
        $this->method = $sMethod;
        return $this;
    }

    /**
     * @return string
     * @throws \LogicException
     */
    public function getAlgo()
    {
        if (!is_string($this->algo)) {
            throw new \LogicException('Argument $sAlgo expects a string value, "' . gettype($this->algo) . '" given');
        }
        return $this->algo;
    }

    /**
     * @param string $sAlgo
     * @return \EvilLib\Crypt\Hash
     * @throws \InvalidArgumentException
     */
    public function setAlgo($sAlgo)
    {
        if (!is_string($sAlgo)) {
            throw new \InvalidArgumentException('Argument $sAlgo expects a string value, "' . gettype($sAlgo) . '" given');
        }
        $this->algo = $sAlgo;
        return $this;
    }

    /**
     * @return string
     * @throws \LogicException
     */
    public function getMode()
    {
        if (!is_string($this->mode)) {
            throw new \LogicException('Argument $sMode expects a string value, "' . gettype($this->mode) . '" given');
        }
        return $this->mode;
    }

    /**
     * @param string $sMode
     * @return \EvilLib\Crypt\Hash
     * @throws \InvalidArgumentException
     */
    public function setMode($sMode)
    {
        if (!is_string($sMode)) {
            throw new \InvalidArgumentException('Argument $sMode expects a string value, "' . gettype($sMode) . '" given');
        }
        $this->mode = $sMode;
        return $this;
    }

    /**
     * @return string
     * @throws \LogicException
     */
    public function getHash()
    {
        if (!is_string($this->hash)) {
            throw new \LogicException('Argument $sHash expects a string value, "' . gettype($this->hash) . '" given');
        }
        return $this->hash;
    }

    /**
     * @param string $sHash
     * @return \EvilLib\Crypt\Hash
     * @throws \InvalidArgumentException
     */
    public function setHash($sHash)
    {
        if (!is_string($sHash)) {
            throw new \InvalidArgumentException('Argument $sHash expects a string value, "' . gettype($sHash) . '" given');
        }
        $this->hash = $sHash;
        return $this;
    }

    /**
     * @return string
     * @throws \LogicException
     */
    public function getSalt()
    {
        if (!is_string($this->salt)) {
            throw new \LogicException('Argument $sSalt expects a string value, "' . gettype($this->salt) . '" given');
        }
        return $this->salt;
    }

    /**
     * @param string $sSalt
     * @return \EvilLib\Crypt\Salt
     * @throws \InvalidArgumentException
     */
    public function setSalt($sSalt)
    {
        if (!is_string($sSalt)) {
            throw new \InvalidArgumentException('Argument $sSalt expects a string value, "' . gettype($sSalt) . '" given');
        }
        $this->salt = $sSalt;
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
            return $this->blockCipher->decrypt($sEncryptedData);
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
            return $this->blockCipher->encrypt($sDataToEncrypt);
        }
        throw new \InvalidArgumentException('Argument $sDataToEncrypt expects a string value, "' . gettype($sDataToEncrypt) . '" given');
    }
}
