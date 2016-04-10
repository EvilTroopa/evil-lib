<?php

namespace EvilLib\Factory\Form;

class LostPasswordFormFactory implements \Zend\ServiceManager\FactoryInterface
{

    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator
     * @return \EvilLib\Form\SignUpForm
     * @throws \LogicException
     */
    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator)
    {
        $aConfig = $oServiceLocator->get('configuration');
        if (!array_key_exists('recaptcha', $aConfig)) {
            throw new \LogicException('Configuration should contain an entry named "captcha"');
        }

        $oCaptcha = new \Zend\Captcha\ReCaptcha($aConfig['recaptcha']);

        return new \EvilLib\Form\LostPasswordForm(array('captcha' => $oCaptcha));
    }
}
