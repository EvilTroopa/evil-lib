<?php

namespace EvilLib\Form;

/**
 * Description of AuthenticationForm
 *
 * @author EvilTroopa
 */
class EditUserForm extends \EvilLib\Form\AbstractForm
{

    /**
     * Constructor
     */
    public function __construct($aOptions = array())
    {
        parent::__construct('edit-user-form', $aOptions);

        $this->add(array('name' => 'userName', 'type' => 'text', 'options' => array('label' => 'Name')));
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
            'userName' => array(
                'name' => 'userName',
                'required' => false,
                'filters' => array(
                    array('name' => '\Zend\Filter\StripTags'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'min' => 3,
                            'max' => 50,
                        ),
                    ),
                ),
            ),
            'userPassword' => array(
                'name' => 'userPassword',
                'required' => false,
                'filters' => array(
                    array('name' => '\Zend\Filter\StripTags'),
                ),
                'validators' => array(
                    array(
                        'name' => '\Zend\Validator\Regex',
                        'options' => array(
                            'pattern' => '/(^$)|(^.{8,}$)/',
                        ),
                    ),
                ),
            ),
            'userPasswordConfirm' => array(
                'name' => 'userPasswordConfirm',
                'required' => false,
                'filters' => array(
                    array('name' => '\Zend\Filter\StripTags'),
                ),
                'validators' => array(
                    array(
                        'name' => '\Zend\Validator\Regex',
                        'options' => array(
                            'pattern' => '/(^$)|(^.{8,}$)/',
                        ),
                    ),
                ),
            ),
        );
    }
}
