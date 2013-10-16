<?php

namespace login\model;

/**
 * Represents a valid Username
 */
class UserName {
	const MINIMUM_USERNAME_LENGTH = 3;
	const MAXIMUM_USERNAME_LENGTH = 9;
	
	/**
	 * @var \register\model\RegisterObserver
	 */
	private $observer;
    
    
	/**
	 * @param String $userName
	 * @throws Exception if not ok
	 */
	public function __construct($userName, \register\model\RegisterObserver $observer = null) {
		$this->observer = $observer;
		if ($this->isOkUserName($userName) == false) {
			throw new \Exception("UserName::__construct : Tried to create user with faulty username");
		}
		$this->userName = $userName;
	}

	/**
	 * @return String
	 */
	public function __toString() {
		return $this->userName;
	}

	/**
	 * @param  String  $string 
	 * @return boolean         
	 */
	private function isOkUserName($string) {
		if (\Common\Filter::hasTags($string) == true) {
			if ($this->observer != null) {
				$this->observer->usernameHasBadCharacters();
			}
			return false;
		} else if (strlen($string) < self::MINIMUM_USERNAME_LENGTH) {
			if ($this->observer != null) {
				$this->observer->usernameIsTooShort();
			}
			return false;
		} else if (strlen($string) > self::MAXIMUM_USERNAME_LENGTH) {
			if ($this->observer != null) {
				$this->observer->usernameIsTooLong();
			}
			return false;
		}
		
		return true;
	}
}