<?php

namespace view;

class HTMLPage {
    function getHTMLPage($title, $body, $footer) {
        return "
            <!doctype html>
            <html lang=\"sv\">
                <head>
                    <meta charset=\"utf-8\" />
                    
                    <link rel=\"stylesheet\" type=\"text/css\" href=\"css/reset.css\" />
                    <link rel=\"stylesheet\" type=\"text/css\" href=\"css/style.css\" />
                    
                    <title>$title</title>
                
                </head>
                <body>
                    $body
                    <p>$footer</p>
                </body>
            </html>";
    }
}

?>
