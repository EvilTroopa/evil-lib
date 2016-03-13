<?php

namespace EvilLib\Crypt;

interface EncryptorInterface
{

    /**
     * @param string $sDataToEncrypt
     * @return string
     */
    public function encrypt($sDataToEncrypt);

    /**
     * @param string $sEncryptedData
     * @return string
     */
    public function decrypt($sEncryptedData);
}
