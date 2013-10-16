<?php

namespace register\model;

interface RegisterObserver {
    public function usernameIsTooShort();
    public function usernameIsTooLong();
    public function usernameHasBadCharacters();
    public function passwordIsTooShort();
    public function passwordIsTooLong();
    public function passwordHasBadCharacters();
    public function passwordDoesNotMatch();
    public function usernameTaken();
}