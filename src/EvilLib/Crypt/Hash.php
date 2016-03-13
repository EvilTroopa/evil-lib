<?php

namespace EvilLib\Crypt;

class Hash implements \EvilLib\Crypt\HashInterface
{

    /**
     * @var string
     */
    protected $algo;

    /**
     * @var integer
     */
    protected $loops;

    /**
     * @var string
     */
    protected $salt;

    /**
     * Constructor
     * @param string $sAlgo
     * @param int $iLoops
     * @param string $sSalt
     */
    public function __construct($sAlgo, $iLoops, $sSalt)
    {
        $this->setAlgo($sAlgo);
        $this->setLoops($iLoops);
        $this->setSalt($sSalt);
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
        if (!in_array($this->algo, hash_algos())) {
            throw new \LogicException('"' . $this->algo . '" is not an known php hash algorithm');
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
        if (!in_array($sAlgo, hash_algos())) {
            throw new \InvalidArgumentException('"' . $sAlgo . '" is not an known php hash algorithm');
        }
        $this->algo = $sAlgo;
        return $this;
    }

    /**
     * @return integer
     * @throws \LogicException
     */
    public function getLoops()
    {
        if (!is_int($this->loops)) {
            throw new \LogicException('Argument $sLoops expects an integer string value, "' . gettype($this->loops) . '" given');
        }
        return $this->loops;
    }

    /**
     * @param integer $iLoops
     * @return \EvilLib\Crypt\Hash
     * @throws \InvalidArgumentException
     */
    public function setLoops($iLoops)
    {
        if (!is_int($iLoops)) {
            throw new \InvalidArgumentException('Argument $sLoops expects an integer value, "' . gettype($iLoops) . '" given');
        }
        $this->loops = $iLoops;
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
     * @return \EvilLib\Crypt\Hash
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
     * @param string $sDataToHash
     * @return string
     */
    public function hash($sDataToHash)
    {
        if (!is_string($sDataToHash)) {
            throw new \InvalidArgumentException('Argument $sDataToHash expects a string value, "' . gettype($sDataToHash) . '" given');
        }
        $sHashedData = '';
        for ($iCnt = 0; $iCnt < $this->getLoops(); $iCnt++) {
            $sHashedData = hash($this->getAlgo(), $sDataToHash . $this->getSalt());
        }
        return $sHashedData;
    }
}
