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
     * @var \EvilLib\Repository\AbstractEntityRepository
     */
    protected $objectRepository;

    /**
     * Constructor
     */
    public function __construct($aOptions = array())
    {
        parent::__construct('sign-up-form', $aOptions);

        $this->add(array('name' => 'userEmail', 'type' => 'text', 'options' => array('label' => 'Email')));
        $this->add(array('name' => 'userPassword', 'type' => 'password', 'options' => array('label' => 'Password')));
        $this->add(array('name' => 'userPasswordConfirm', 'type' => 'password', 'options' => array('label' => 'Password Confirm')));
        $this->add(array('name' => 'userName', 'type' => 'text', 'options' => array('label' => 'Name')));
        $this->add(array('name' => 'buttonSubmit', 'type' => 'submit', 'options' => array('label' => 'Sign Up')));
    }

    /**
     * @param array $aOptions
     * @return \EvilLib\Form\SignUpForm
     */
    public function setOptions($aOptions = array())
    {
        parent::setOptions($aOptions);

        if (array_key_exists('object_repository', $aOptions)) {
            $this->setObjectRepository($aOptions['object_repository']);
        }

        return $this;
    }

    /**
     * @return \EvilLib\Repository\AbstractEntityRepository
     * @throws \LogicException
     */
    public function getObjectRepository()
    {
        if ($this->objectRepository instanceof \EvilLib\Repository\AbstractEntityRepository) {
            return $this->objectRepository;
        }
        throw new \LogicException('Property objectRepository expects an instance of \EvilLib\Repository\AbstractEntityRepository, "' . (is_object($this->objectRepository) ? get_class($this->objectRepository) : gettype($this->objectRepository)) . '" defined');
    }

    /**
     * @param \EvilLib\Repository\AbstractEntityRepository $oObjectRepository
     * @return \EvilLib\Form\SignUpForm
     */
    public function setObjectRepository(\EvilLib\Repository\AbstractEntityRepository $oObjectRepository)
    {
        $this->objectRepository = $oObjectRepository;
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
                    array(
                        'name' => '\DoctrineModule\Validator\NoObjectExists',
                        'options' => array(
                            'object_repository' => $this->getObjectRepository(),
                            'fields' => array('userEmail'),
                        ),
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
                        'name' => 'StringLength',
                        'options' => array(
                            'min' => 3,
                            'max' => 50,
                        ),
                    ),
                ),
            ),
        );
    }
}
