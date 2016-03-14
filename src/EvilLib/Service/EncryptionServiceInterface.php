<?php

namespace EvilLib\Service;

interface EncryptionServiceInterface
{

    /**
     * @return string
     */
    public function hash($sDataToHash);

    /**
     * @return string
     */
    public function encrypt($sDataToEncrypt);

    /**
     * @return string
     */
    public function decrypt($sEncryptedData);
}
