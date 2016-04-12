<?php

namespace EvilLib\Form;

/**
 * Description of AuthenticationForm
 *
 * @author EvilTroopa
 */
class RenewPasswordForm extends \EvilLib\Form\AbstractForm
{

    /**
     * Constructor
     */
    public function __construct($aOptions = array())
    {
        parent::__construct('renew-password-form', $aOptions);

        $this->add(array('name' => 'userPassword', 'type' => 'password', 'options' => array('label' => 'Password')));
        $this->add(array('name' => 'userPasswordConfirm', 'type' => 'password', 'options' => array('label' => 'Password confirmation')));
        $this->add(array('name' => 'buttonSubmit', 'type' => 'submit', 'options' => array('label' => 'Validate')));
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
            'userPassword' => array(
                'name' => 'userPassword',
                'required' => true,
                'filters' => array(
                    array('name' => '\Zend\Filter\StripTags'),
                ),
                'validators' => array(
                    array(
                        'name' => '\Zend\Validator\StringLength',
                        'options' => array(
                            'min' => 8,
                        ),
                    ),
                ),
            ),
            'userPasswordConfirm' => array(
                'name' => 'userPasswordConfirm',
                'required' => true,
                'filters' => array(
                    array('name' => '\Zend\Filter\StripTags'),
                ),
                'validators' => array(
                    array(
                        'name' => '\Zend\Validator\Identical',
                        'options' => array(
                            'token' => 'userPassword',
                            'strict' => true,
                        ),
                    ),
                ),
            ),
        );
    }
}
