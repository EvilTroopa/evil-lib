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
            $this->flashMessenger()->addInfoMessage('If the provided email is linked to an account, an email has been sent to it to renew the password.');
            return $this->postRedirectGet('Home/LostPassword');
        }

        $oViewModel->lostPasswordForm = $oForm;

        if ($this->flashMessenger()->hasCurrentInfoMessages()) {
            $oViewModel->message = implode('<br />', $this->flashMessenger()->getCurrentInfoMessages());
        }

        return $oViewModel;
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function renewPasswordAction()
    {
        // Retrieve hash from route
        $sPasswordHash = $this->params()->fromRoute('hash', '');

        if (!$sPasswordHash) {
            return $this->redirect()->toRoute('Home');
        }
        // Retrieve service locator
        $oServiceLocator = $this->getServiceLocator();
        $oUserService = $oServiceLocator->get('UserService');
        $oUserEntity = $oUserService->findUserByPasswordHashKey($sPasswordHash);

        if (!($oUserEntity instanceof \EvilLib\Entity\UserEntityInterface)) {
            return $this->redirect()->toRoute('Home');
        }

        $oForm = new \EvilLib\Form\RenewPasswordForm();

        // Check post
        if ($this->getRequest()->isPost() && $oForm->setData($this->params()->fromPost())->isValid()) {
            $aUserData = $oForm->getData();
            $oUserService->updateUserPassword($oUserEntity, $aUserData['userPassword']);
            $oServiceLocator->get('Session')->getStorage()->offsetSet('step', self::STEP_NEW_PWD_OK);
            return $this->postRedirectGet('Home/RenewPasswordOk');
        }

        // Prepare view
        $oViewModel = new \Zend\View\Model\ViewModel();
        $oViewModel->setTemplate('evillib/user/renew-password');

        $oViewModel->renewPasswordForm = $oForm;

        return $oViewModel;
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function renewPasswordOkAction()
    {
        // Retrieve service locator
        $oSession = $this->getServiceLocator()->get('Session');

        if ($oSession->getStorage()->offsetGet('step') !== self::STEP_NEW_PWD_OK) {
            return $this->redirect('Home');
        }

        $oSession->getStorage()->offsetUnset('step');

        // Prepare view
        $oViewModel = new \Zend\View\Model\ViewModel();
        $oViewModel->setTemplate('evillib/user/renew-password-ok');

        return $oViewModel;
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function editUserAction()
    {
        // Retrieve service locator
        $oServiceLocator = $this->getServiceLocator();
        $oUserService = $oServiceLocator->get('UserService');

        $oUserEntity = $this->identity();
        $sOldPassword = $oUserEntity->getUserPassword();

        $oForm = $oServiceLocator->get('EditUserForm');
        $oForm->bind($oUserEntity);

        // Check post
        if ($this->getRequest()->isPost() && $oForm->setData($this->params()->fromPost())->isValid()) {
            $oUserService->updateUser($oUserEntity, $sOldPassword);

            return $this->postRedirectGet('Home/EditUser');
        }

        // Prepare view
        $oViewModel = new \Zend\View\Model\ViewModel();
        $oViewModel->setTemplate('evillib/user/edit-user');

        $oViewModel->renewPasswordForm = $oForm;

        return $oViewModel;
    }
}
