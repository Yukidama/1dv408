<?php

namespace login\model;


require_once("UserCredentials.php");
require_once("common/model/PHPFileStorage.php");

/**
 * represents All users in the system
 *

 */
class UserList {
	/**
	 * Temporary solution with only one user "Admin" in PHPFileStorage
 	 * You might want to use a database instead.
	 * @var \common\model\PHPFileStorage
	 */
	private $usersFile;

	/**
	 * We only have one user in the system right now.
	 * @var array of UserCredentials
	 */
	private $users;


	public function  __construct( ) {
		$this->users = array();
		
		$this->loadUsers();
	}

	/**
	 * Do we have this user in this list?
	 * @throws  Exception if user provided is not in list
	 * @param  UserCredentials $fromClient
	 * @return UserCredentials from list
	 */
	public function findUser(UserCredentials $fromClient) {
		foreach($this->users as $user) {
			if ($user->isSame($fromClient) ) {
				\Debug::log("found User");
				return  $user;
			}
		}
		throw new \Exception("could not login, no matching user");
	}

	public function update(UserCredentials $changedUser) {
		//this user needs to be saved since temporary password changed
		$this->usersFile->writeItem($changedUser->getUserName(), $changedUser->toString());

		\Debug::log("wrote changed user to file", true, $changedUser);
		$this->users[$changedUser->getUserName()->__toString()] = $changedUser;
	}

	/**
	 * Temporary function to store "Admin" user in file "data/admin.php"
	 * If no file is found a new one is created.
	 * 
	 * @return [type] [description]
	 */
	private function loadAdmin() {
		
		try {
			//Read admin from file
			$adminUserString = $this->usersFile->readItem("Admin");
			$admin = UserCredentials::fromString($adminUserString);

		} catch (\Exception $e) {
			\Debug::log("Could not read file, creating new one", true, $e);

			//Create a new user
			$userName = new UserName("Admin");
			$password = Password::fromCleartext("Password");
			$admin = UserCredentials::create( $userName, $password);
			$this->update($admin);
		}

	}
	
	public function userExists($username) {
		try {
			$userFromString = $this->usersFile->readItem($username);
			$user = UserCredentials::fromString($userFromString);
		}
		catch (\Exception $e) {
			return false;
		}
		return true;
	}
	
	/**
	 * Adds a user
	 * @param \login\model\UserName $username;
	 * @param \login\model\Password $password;
	 */
	public function addUser(\login\model\UserName $username, \login\model\Password $password) {
		$newUser = UserCredentials::create($username, $password);
		$this->update($newUser);
	}

	/**
	 * Loads all users incl. admin to $this->users
	 */
	private function loadUsers() {
		$this->usersFile = new \common\model\PHPFileStorage("data/users.php");
		//First we load the default admin
		$this->loadAdmin();
		$rawUsers = $this->usersFile->readAll();
		
		foreach ($rawUsers as $key => $user) {
			$credUser = UserCredentials::fromString($user);
			$this->users[$credUser->getUserName()->__toString()] = $credUser;
		}
		//Second we load the rest of the users
	}
}