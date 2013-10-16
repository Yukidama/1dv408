<?php

namespace model;

class MessageHolder {
    
    /**
     * @var String
     */
    private static $sessionMessage = "model::MessageHolder::sessionMessage";
    
    /**
     * return message
     * @return String
     */
    public function getMessageOnce() {
        $message = $this->getMessage();
        $this->unsetMessage();
        return $message;
    }
    
    /**
     * Returns message
     * @return String
     */
    private function getMessage() {
        return $_SESSION[self::$sessionMessage];
    }
    
    /**
     * Set message to desired message
     * @param String
     */ 
    public function setMessage($aMessage) {
        $_SESSION[self::$sessionMessage] = $aMessage;
    }
    
    /**
     * Checks if message exists
     * @return BOOL
     */
    public function messageExists() {
        if (isset($_SESSION[self::$sessionMessage])) {
            if (strlen($_SESSION[self::$sessionMessage]) > 0 ) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * unset the message
     */
    private function unsetMessage() {
        unset($_SESSION[self::$sessionMessage]);
    }
}
