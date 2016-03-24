<?php

namespace EvilLib\Form;

/**
 * Description of AuthenticationForm
 *
 * @author EvilTroopa
 */
class SignUpForm extends \EvilLib\Form\AbstractForm
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct('sign-up-form', array());

        $this->add(array('name' => 'userEmail', 'type' => 'text', 'options' => array('label' => 'Email')));
        $this->add(array('name' => 'userPassword', 'type' => 'password', 'options' => array('label' => 'Password')));
        $this->add(array('name' => 'userPasswordConfirm', 'type' => 'password', 'options' => array('label' => 'Password Confirm')));
        $this->add(array('name' => 'userName', 'type' => 'text', 'options' => array('label' => 'Name')));
        $this->add(array('name' => 'buttonSubmit', 'type' => 'submit', 'options' => array('label' => 'Sign Up')));
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
            'userName' => array(
                'name' => 'userName',
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
