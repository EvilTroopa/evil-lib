<?php

namespace EvilLib\Controller;

class UserController extends \EvilLib\Controller\AbstractController
{

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function logInAction()
    {
        $oServiceLocator = $this->getServiceLocator();

        $oForm = new \EvilLib\Form\AuthenticationForm();

        $oViewModel = new \Zend\View\Model\ViewModel();
        $oViewModel->setTemplate('evillib/user/log-in');

        $oViewModel->authForm = $oForm;

        if ($this->getRequest()->isPost()) {
            $aFormData = $this->params()->fromPost();

            $bAuthenticated = $oServiceLocator->get('\EvilLib\Service\UserService')->authenticate($aFormData['userEmail'], $aFormData['userPassword']);

            if ($bAuthenticated) {
                return $this->redirect()->toRoute('Home');
            }
            $oViewModel->authForm->get('userPassword')->setMessages(array('Authentication failed'));
        }

        return $oViewModel;
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function logOutAction()
    {
        $oServiceLocator = $this->getServiceLocator();

        $oServiceLocator->get('\EvilLib\Service\UserService')->logOut();

        return $this->redirect()->toRoute('Home');
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function signUpAction()
    {
        $oServiceLocator = $this->getServiceLocator();

        $oForm = $oServiceLocator->get('SignUpForm');

        $oViewModel = new \Zend\View\Model\ViewModel();
        $oViewModel->setTemplate('evillib/user/sign-up');

        $oViewModel->signUpForm = $oForm;

        return $oViewModel;
    }
}
