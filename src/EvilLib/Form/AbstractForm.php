<?php

namespace EvilLib\Form;

/**
 * Description of AbstractForm
 *
 * @author EvilTroopa
 */
abstract class AbstractForm extends \Zend\Form\Form implements \Zend\InputFilter\InputFilterProviderInterface
{

    public function __construct($sName, array $aOptions)
    {
        parent::__construct($sName, $aOptions);

        $this->add(array('name' => 'csrf', 'type' => '\Zend\Form\Element\Csrf'));
    }

    /**
     * @see \Zend\Form\Form::setOptions
     * @param type $aOptions
     */
    public function setOptions($aOptions = array())
    {
        parent::setOptions($aOptions);
        return $this;
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
            'csrf' => array(
                'name' => 'csrf',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => '\Zend\Validator\Csrf',
                    ),
                )
            )
        );
    }
}
