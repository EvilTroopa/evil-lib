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

namespace EvilLib\Service;

/**
 * Description of AbstractService
 *
 * @author EvilTroopa
 */
abstract class AbstractService
{

    /**
     * @var \Zend\ServiceManager\ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * Constructor
     * @param \Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator
     */
    public function __construct(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator)
    {
        $this->serviceLocator = $oServiceLocator;
    }

    /**
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     * @throws \LogicException
     */
    public function getServiceLocator()
    {
        if ($this->serviceLocator instanceof \Zend\ServiceManager\ServiceLocatorInterface) {
            return $this->serviceLocator;
        }
        throw new \LogicException('Property $serviceLocator expects an instance of \Zend\ServiceManager\ServiceLocatorInterface, "' . (is_object($this->serviceLocator) ? get_class($this->serviceLocator) : gettype($this->serviceLocator)) . '" defined');
    }
}
