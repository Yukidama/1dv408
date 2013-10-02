<?php

namespace model;

class MessageHolder {
    
    /**
     * @var String
     */
    private $message;
    
    /**
     * return message
     * @return String
     */
    public function getMessage() {
        return $this->message;
    }
    
    /**
     * Set message to desired message
     * @param String
     */
    public function setMessage($aMessage) {
        $this->message = $aMessage;
    }
    
    /**
     * Checks if message exists
     * @return BOOL
     */
    public function messageExists() {
        return (strlen($this->message) > 0);
    }
}
