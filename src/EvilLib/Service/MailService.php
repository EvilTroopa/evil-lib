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
 * Description of MailService
 *
 * @author EvilTroopa
 */
class MailService extends \EvilLib\Service\AbstractService
{

    /**
     * @var \Zend\Mail\Transport\TransportInterface
     */
    protected $transporter;

    /**
     * @return \Zend\Mail\Transport\TransportInterface
     * @throws \LogicException
     */
    public function getTransporter()
    {
        if ($this->transporter instanceof \Zend\Mail\Transport\TransportInterface) {
            return $this->transporter;
        }
        throw new \LogicException('Property transporter expects an instance of \Zend\Mail\Transport\TransportInterface, "' . (is_object($this->transporter) ? get_class($this->transporter) : gettype($this->transporter)) . '" defined');
    }

    /**
     * @param \Zend\Mail\Transport\TransportInterface $oTransporter
     * @return \EvilLib\Service\MailService
     */
    public function setTransporter(\Zend\Mail\Transport\TransportInterface $oTransporter)
    {
        $this->transporter = $oTransporter;
        return $this;
    }

    /**
     * @param \Zend\View\Model\ViewModel $oViewModel
     * @param array $aOptions
     * @return \EvilLib\Service\MailService
     * @throws \InvalidArgumentException
     */
    public function sendMail(\Zend\View\Model\ViewModel $oViewModel, array $aOptions)
    {
        $oServiceLocator = $this->getServiceLocator();

        // Retrieve default values from config
        $aConfig = $oServiceLocator->get('configuration');
        if (isset($aConfig['mail']) && isset($aConfig['mail']['default_values'])) {
            $aOptions = array_replace_recursive($aConfig['mail']['default_values'], $aOptions);
        }

        // Check values
        if (!array_key_exists('from', $aOptions)) {
            throw new \InvalidArgumentException('Argument $aOptions should contain an entry named "from"');
        }
        if (!array_key_exists('to', $aOptions)) {
            throw new \InvalidArgumentException('Argument $aOptions should contain an entry named "to"');
        }
        if (!array_key_exists('subject', $aOptions)) {
            throw new \InvalidArgumentException('Argument $aOptions should contain an entry named "subject"');
        }

        // Setup message
        $oMessage = new \Zend\Mail\Message();
        $oMessage
                ->setFrom($aOptions['from'])
                ->setTo($aOptions['to'])
                ->setSubject($aOptions['subject'])
                ->setBody($oServiceLocator->get('ZfcTwigRenderer')->render($oViewModel))
                ->setEncoding('UTF-8');
        $oMessage->getHeaders()
                ->addHeaderLine('Content-Type: text/html');

        // Check message
        if (!$oMessage->isValid()) {
            throw new \LogicException('Email message not valid, could not send : "' . $oMessage->toString() . '"');
        }

        // Send message
        $this->getTransporter()->send($oMessage);

        return $this;
    }
}
