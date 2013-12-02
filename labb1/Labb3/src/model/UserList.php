<?php

namespace model;

require_once("User.php");

class UserList {
    
    /**
     * @var Array $users
     */
    private $users;
    
    /**
     * Constructor
     */
    public function __construct() {
        $users = array();
        $this->loadUsers();
    }
    
    /**
     * Tries to login user, other throw exception
     * @param String $a_username
     * @param String $a_password
     * @throws Exception when user can't login with prompted username and password
     * @return User
     */
    public function tryLoginUser($a_username, $a_password) {
        //Om hittas, returera true och sŠtt logged in user
        $clientUser = User::createFromPlainPassword($a_username, $a_password);
        foreach ($this->users as $user) {
            if ($user->isSameUser($clientUser)) {
                return $user;
            }
        }
        throw new \Exception("model::UserList::tryLoginUser can't login");
    }
    
    /**
     * Tries to match a User just by username
     * @param String $a_username
     * @throws Exception when there is no matching username
     * @return User
     */
    public function tryLoginCookieUser($a_username) {
        $clientUser = User::createFromUsername($a_username);
        foreach ($this->users as $user) {
            if ($user->hasSameUsername($clientUser)) {
                return $user;
            }
        }
        throw new \Exception("model::UserList::tryLoginUser can't login");
    }
    
    /**
     * Method that loads all users into the array
     */
    public function loadUsers() {
        //Here all users will be loaded from. Right now just one
        $this->users[] = User::createFromPlainPassword("Admin", "Password");
    }
}