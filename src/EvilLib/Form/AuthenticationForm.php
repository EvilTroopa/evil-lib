<?php

namespace EvilLib\Form;

/**
 * Description of AuthenticationForm
 *
 * @author EvilTroopa
 */
class AuthenticationForm extends \EvilLib\Form\AbstractForm
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct('authentication-form', array());

        $this->add(array('name' => 'userEmail', 'type' => 'text', 'options' => array('label' => 'Email')));
        $this->add(array('name' => 'userPassword', 'type' => 'password', 'options' => array('label' => 'Password')));
        $this->add(array('name' => 'buttonSubmit', 'type' => 'submit', 'options' => array('label' => 'Connect')));
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
                            'min' => 1,
                        ),
                    ),
                ),
            ),
        );
    }
}
