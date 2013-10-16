<?php

namespace application\controller;

require_once("application/view/View.php");
require_once("register/model/RegisterModel.php");
require_once("register/view/RegisterView.php");
require_once("login/controller/LoginController.php");
require_once("register/controller/RegisterController.php");

require_once("login/model/UserList.php");


/**
 * Main application controller
 */
class Application {
	/**
	 * \view\view
	 * @var [type]
	 */
	private $view;

	/**
	 * @var \login\controller\LoginController
	 */
	private $loginController;
	
	/**
	 * @var \register\controller\RegisterController
	 */
	private $registerController;
	
	/**
	 * @var \register\model\RegisterModel
	 */
	private $registerModel;
	
	/**
	 * @var \register\view\RegisterViwe
	 */
	private $registerView;
	
	public function __construct() {
		
		$userlist = new \login\model\UserList();
		
		$loginView = new \login\view\LoginView();
		$this->registerModel = new \register\model\RegisterModel($userlist);
		$this->registerView = new \register\view\RegisterView($this->registerModel);
		$this->registerModel->setObserver($this->registerView);
		
		$this->loginController = new \login\controller\LoginController($loginView, $userlist);
		$this->registerController = new \register\controller\RegisterController($this->registerView);
		
		$this->view = new \application\view\View($loginView, $this->registerView);
	}
	
	/**
	 * @return \common\view\Page
	 */
	public function doFrontPage() {
		$this->loginController->doToggleLogin();
	
		if ($this->loginController->isLoggedIn()) {
			$loggedInUserCredentials = $this->loginController->getLoggedInUser();
			return $this->view->getLoggedInPage($loggedInUserCredentials);	
		} else {
			if ($this->registerController->doingRegistration()) {
				$this->registerController->handleRegistrationIfNeeded();
				if (!$this->registerController->didRegisterUser()) {
					return $this->view->getRegistrationPage();
				}
				else {
					return $this->view->getLoggedOutPage($this->registerModel->getUserNameInText(),
									     $this->registerView->getSuccessMessage());
				}
			}
			else {
				return $this->view->getLoggedOutPage();
			}
		}
	}
}
