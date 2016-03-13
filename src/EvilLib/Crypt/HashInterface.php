<?php

namespace EvilLib\Crypt;

interface HashInterface
{

    /**
     * @param string $sData
     * @return string
     */
    public function hash($sData);
}
