<?php

namespace EvilLib\Controller;

class UserController extends \EvilLib\Controller\AbstractController
{

    /**
     * @var string
     */
    const STEP_SIGN_UP_OK = 'sign_up_ok';

    /**
     * @var string
     */
    const STEP_NEW_PWD_OK = 'new_pwd_ok';

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function logInAction()
    {
        // Retrieve form
        $oForm = new \EvilLib\Form\AuthenticationForm();

        // Check post
        if ($this->getRequest()->isPost() && $oForm->setData($this->params()->fromPost())->isValid()) {
            $aFormData = $oForm->getData();

            // Retrieve service locator
            $oServiceLocator = $this->getServiceLocator();

            // Check authentication
            $oUserService = $oServiceLocator->get('UserService');
            $bAuthenticated = $oUserService->authenticate($aFormData['userEmail'], $aFormData['userPassword']);
            if ($bAuthenticated) {
                if (($oUserEntity = $this->identity()) instanceof \EvilLib\Entity\UserEntityInterface) {
                    $iUserStatus = $oUserEntity->getUserStatus();
                    if ($iUserStatus !== \EvilLib\Entity\AbstractUserEntity::USER_STATUS_ACTIVE) {
                        switch ($iUserStatus) {
                            case \EvilLib\Entity\AbstractUserEntity::USER_STATUS_PENDING:
                                $oForm->get('userPassword')->setMessages(array('Account pending, you must validate it from the link provided in the sign-up email'));
                                break;
                            case \EvilLib\Entity\AbstractUserEntity::USER_STATUS_BLOCKED:
                                $oForm->get('userPassword')->setMessages(array('Account blocked, please contact the administrator'));
                                break;
                            case \EvilLib\Entity\AbstractUserEntity::USER_STATUS_DISABLED:
                                $oForm->get('userPassword')->setMessages(array('Authentication failed'));
                                break;
                            default:
                                throw new \LogicException('User status value invalid : "' . gettype() . '"');
                        }
                        $oUserService->logOut();
                    } else {
                        return $this->redirect()->toRoute('Home');
                    }
                } else {
                    throw new \LogicException('Retrieve UserEntity expects an instance of \EvilLib\Entity\UserEntityInterface, "' . (is_object($oUserEntity) ? get_class($oUserEntity) : gettype($oUserEntity)) . '" given');
                }
            } else {
                $oForm->get('userPassword')->setMessages(array('Authentication failed'));
            }
        }

        $oViewModel = new \Zend\View\Model\ViewModel();
        $oViewModel->setTemplate('evillib/user/log-in');

        $oViewModel->authForm = $oForm;
        return $oViewModel;
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function logOutAction()
    {
        // Retrieve service locator
        $oServiceLocator = $this->getServiceLocator();

        $oServiceLocator->get('UserService')->logOut();

        return $this->redirect()->toRoute('Home');
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function signUpAction()
    {
        // Retrieve service locator
        $oServiceLocator = $this->getServiceLocator();

        // Retrieve User service
        $oUserService = $oServiceLocator->get('UserService');

        // Prepare view
        $oViewModel = new \Zend\View\Model\ViewModel();
        $oViewModel->setTemplate('evillib/user/sign-up');

        // Retrieve form
        $oForm = $oServiceLocator->get('SignUpForm');
        $sUserEntityClassName = $oUserService->getUserEntityClassName();
        $oForm->bind($oUserEntity = new $sUserEntityClassName());

        // Check post
        if ($this->getRequest()->isPost() && $oForm->setData($this->params()->fromPost())->isValid()) {
            $oUserService->processUserSignUp($oUserEntity);
            $oServiceLocator->get('Session')->getStorage()->offsetSet('step', self::STEP_SIGN_UP_OK);
            return $this->redirect()->toRoute('Home/SignUp/Ok');
        }

        $oViewModel->signUpForm = $oForm;

        return $oViewModel;
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function signUpOkAction()
    {
        // Retrieve service locator
        $oServiceLocator = $this->getServiceLocator();

        // Check session
        $oSessionStorage = $oServiceLocator->get('Session')->getStorage();
        if ($oSessionStorage->offsetGet('step') !== self::STEP_SIGN_UP_OK) {
            return $this->redirect()->toRoute('Home');
        }

        // Empty session
        $oSessionStorage->offsetUnset('step');

        // Prepare view
        $oViewModel = new \Zend\View\Model\ViewModel();
        $oViewModel->setTemplate('evillib/user/sign-up-ok');

        return $oViewModel;
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function signUpValidateAction()
    {
        // Retrieve hash from route
        $sSignUpHash = $this->params()->fromRoute('hash', '');

        if ($sSignUpHash) {
            // Retrieve service locator
            $oServiceLocator = $this->getServiceLocator();

            $bValidated = $oServiceLocator->get('UserService')->validateUser($sSignUpHash);

            if (!$bValidated) {
                return $this->redirect()->toRoute('Home');
            }
        }

        // Prepare view
        $oViewModel = new \Zend\View\Model\ViewModel();
        $oViewModel->setTemplate('evillib/user/sign-up-validate');

        return $oViewModel;
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function lostPasswordAction()
    {
        // Retrieve service locator
        $oServiceLocator = $this->getServiceLocator();

        // Retrieve User service
        $oUserService = $oServiceLocator->get('UserService');

        // Prepare view
        $oViewModel = new \Zend\View\Model\ViewModel();
        $oViewModel->setTemplate('evillib/user/lost-password');

        // Retrieve form
        $oForm = $oServiceLocator->get('LostPasswordForm');

        // Check post
        if ($this->getRequest()->isPost() && $oForm->setData($this->params()->fromPost())->isValid()) {
            $oUserService->processUserLostPassword($oForm->getData());
            $oViewModel->message = 'If the provided email is linked to an account, an email has been sent to it to renew the password.';
        }

        $oViewModel->lostPasswordForm = $oForm;

        return $oViewModel;
    }
}
