<?php

namespace view;

class MemberView {
    
    /**
     * @var \view\Login
     */
    private $loginView;
    
    /**
     * @var \model\Login
     */
    private $loginModel;
    
    /**
     * @var String
     */
    private $title = "Välkommen!";
        
    /**
     * @var \view\MessageHolder
     */
    private $messageHolder;
    
    /**
     * Concstructor which gets objects and set them as member variables
     */
    public function __construct(\model\Login        $aLoginModel,
                                \view\Login         $aLoginView,
                                \view\MessageHolder $aMessageHolder) {
        
        $this->loginModel = $aLoginModel;
        $this->loginView = $aLoginView;
        $this->messageHolder = $aMessageHolder;
    }
    
    /**
     * Returns a page for logged in members
     * @return String HTML
     */
    public function getMemberPage() {
        $message = "";
        if ($this->messageHolder->messageExists()) {
            $message = "<p class=\"normalMessage\">" . $this->messageHolder->getMessageOnce() . "</p>";
        }
      
        return "<h2>". $this->loginModel->getUsername() ." är inloggad</h2>
            $message".
            $this->loginView->getLogoutLink();
    }

    /**
     * Returns this views title
     * return String
     */
    public function getTitle() {
        return $this->title;
    }
    
}
