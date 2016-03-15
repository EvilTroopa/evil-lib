<?php

namespace EvilLib\Form;

/**
 * Description of AbstractForm
 *
 * @author EvilTroopa
 */
abstract class AbstractForm extends \Zend\Form\Form
{

    const TOKEN_KEY = 'token';

    /**
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $previousToken;

    /**
     * @see \Zend\Form\Form::setOptions
     * @param type $aOptions
     */
    public function setOptions($aOptions = array())
    {
        parent::setOptions($aOptions);
        if (array_key_exists('csrf_token', $aOptions)) {
            $this->setToken($aOptions['csrf_token']);
        }
        if (array_key_exists('csrf_previous_token', $aOptions)) {
            $this->setPreviousToken($aOptions['csrf_previous_token']);
        }
        return $this;
    }
}
