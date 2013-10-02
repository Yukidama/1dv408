<?php

namespace view;

class Navigation {
    
    /**
     * Reload to index.php
     */
    public static function reloadPage() {
        header("Location: index.php");
    }
}
