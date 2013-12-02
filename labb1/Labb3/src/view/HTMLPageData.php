<?php

namespace view;

class HTMLPageData {
    /**
     * @var String
     */
    private $title;
    
    /**
     * @var String
     */
    private $body;
    
    /**
     * @var String
     */
    private $footer;
    
    /**
     * Constructor which takes title body and footer as strings
     * @param String $aTitle
     * @param String $aBody
     * @param String $aFooter
     */
    public function __construct($aTitle = "", $aBody = "", $aFooter = "") {
        $this->title = $aTitle;
        $this->body = $aBody;
        $this->footer = $aFooter;
    }
    
    /**
     * Set or append information to the title
     * @param String $aTitle Information for the title
     * @param BOOL   $add    If true, append the title to the current title
     */
    public function setTitle($aTitle, $add = false) {
        if ($add) {
            $this->title .= $aTitle;
        }
        else {
            $this->title = $aTitle;
        }
    }
    
    /**
     * Set or append information to the body
     * @param String $aBody  Information for the body
     * @param BOOL   $add    If true, append the body to the current title
     */
    public function setBody($aBody, $add = false) {
        if ($add) {
            $this->body .= $aBody;
        }
        else {
            $this->body = $aBody;
        }
    }
    
    /**
     * Set or append information to the footer
     * @param String $aFooter Information for the footer
     * @param BOOL   $add    If true, append the footer to the current title
     */
    public function setFooter($aFooter, $add = false) {
        if ($add) {
            $this->footer .= $aFooter;
        }
        else {
            $this->footer = $aFooter;
        }
    }
    
    /**
     * Returns the title
     *@return String
     */
    public function getTitle() {
        return $this->title;
    }
    
    /**
     * Returns the body
     *@return String
     */
    public function getBody() {
        return $this->body;
    }
    
    /**
     * Returns the footer
     *@return String
     */
    public function getFooter() {
        return $this->footer;
    }
}
