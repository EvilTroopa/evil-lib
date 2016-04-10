<?php

namespace EvilLib\Form;

/**
 * Description of AuthenticationForm
 *
 * @author EvilTroopa
 */
class LostPasswordForm extends \EvilLib\Form\AbstractForm
{

    /**
     * @var \Zend\Captcha\ReCaptcha
     */
    protected $captcha;

    /**
     * Constructor
     */
    public function __construct($aOptions = array())
    {
        parent::__construct('lost-password-form', $aOptions);

        $this->add(array('name' => 'userEmail', 'type' => 'text', 'options' => array('label' => 'Email')));
        $this->add(array('name' => 'captcha', 'type' => '\Zend\Form\Element\Captcha', 'options' => array('label' => 'Are you a robot?', 'captcha' => $this->getCaptcha())));
        $this->add(array('name' => 'buttonSubmit', 'type' => 'submit', 'options' => array('label' => 'Validate')));
    }

    /**
     * @param array $aOptions
     * @return \EvilLib\Form\LostPasswordForm
     */
    public function setOptions($aOptions = array())
    {
        parent::setOptions($aOptions);

        if (array_key_exists('captcha', $aOptions)) {
            $this->setCaptcha($aOptions['captcha']);
        }

        return $this;
    }

    /**
     * @return \Zend\Captcha\ReCaptcha
     * @throws \LogicException
     */
    public function getCaptcha()
    {
        if ($this->captcha instanceof \Zend\Captcha\ReCaptcha) {
            return $this->captcha;
        }
        throw new \LogicException('Property captcha expects an instance of \Zend\Captcha\ReCaptcha, "' . (is_object($this->captcha) ? get_class($this->captcha) : gettype($this->captcha)) . '" defined');
    }

    /**
     * @param \Zend\Captcha\ReCaptcha $oCaptcha
     * @return \EvilLib\Form\LostPasswordForm
     */
    public function setCaptcha(\Zend\Captcha\ReCaptcha $oCaptcha)
    {
        $this->captcha = $oCaptcha;
        return $this;
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
            'userEmail' => array(
                'name' => 'userEmail',
                'required' => true,
                'filters' => array(
                    array('name' => '\Zend\Filter\StripTags'),
                    array('name' => '\Zend\Filter\StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => '\Zend\Validator\EmailAddress',
                    ),
                ),
            ),
        );
    }
}
