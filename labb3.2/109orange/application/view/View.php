<?php

namespace application\view;

require_once("common/view/Page.php");
require_once("SwedishDateTimeView.php");



class View {
	/**
	 * @var \Login\view\LoginView
	 */
	private $loginView;
	
	/**
	 * @var \Login\view\LoginView
	 */
	private $registerView;

	/**
	 * @var  SwedishDateTimeView $timeView;
	 */
	private $timeView;
	
	/**
	 * @param LoginviewLoginView $loginView 
	 */
	public function __construct(\login\view\LoginView $loginView, \register\view\registerView $registerView) {
		$this->loginView = $loginView;
		$this->registerView = $registerView;
		$this->timeView = new SwedishDateTimeView();
	}
	
	/**
	 * @return \common\view\Page
	 */
	public function getLoggedOutPage($username = "", $externalMessage = "") {
		$html = $this->getHeader(false);
		$loginBox = $this->loginView->getLoginBox($username, $externalMessage);
		$registerButton = $this->registerView->getRegisterButton();

		$html .= "<h2>Ej Inloggad</h2>
					$registerButton
				  	$loginBox
				 ";
		$html .= $this->getFooter();

		return new \common\view\Page("Laboration. Inte inloggad", $html);
	}
	
	/**
	 * @return \common\view\Page
	 */
	public function getRegistrationPage() {
		$html = $this->getHeader(false);
		$registrationForm = $this->registerView->getRegistrationForm();
		$backButton = $this->registerView->getBackButton();

		$html .= "<h2>Ej Inloggad, Registrerar användare</h2>
					$backButton
				  	$registrationForm
				 ";
		$html .= $this->getFooter();

		return new \common\view\Page("Laboration. Registrera användare", $html);
	}
	
	/**
	 * @param \login\login\UserCredentials $user
	 * @return \common\view\Page
	 */
	public function getLoggedInPage(\login\model\UserCredentials $user) {
		$html = $this->getHeader(true);
		$logoutButton = $this->loginView->getLogoutButton(); 
		$userName = $user->getUserName();

		$html .= "
				<h2>$userName är inloggad</h2>
				 	$logoutButton
				 ";
		$html .= $this->getFooter();

		return new \common\view\Page("Laboration. Inloggad", $html);
	}
	
	
	/**
	 * @param boolean $isLoggedIn
	 * @return  String HTML
	 */
	private function getHeader($isLoggedIn) {
		$ret =  "<h1>Laborationskod xx222aa</h1>";
		return $ret;
		
	}

	/**
	 * @return [type] [description]
	 */
	private function getFooter() {
		$timeString = $this->timeView->getTimeString(time());
		return "<p>$timeString<p>";
	}
	
	
	
}
