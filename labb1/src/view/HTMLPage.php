<?php

namespace view;

class HTMLPage {
    
    /**
     * Returns a HTML Page from arguments
     * @param \model\HTMLPage $htmlObj
     */
    function getHTMLPage(\model\HTMLPage $htmlObj) {
        return "
            <!doctype html>
            <html lang=\"sv\">
                <head>
                    <meta charset=\"utf-8\" />
                    
                    <link rel=\"stylesheet\" type=\"text/css\" href=\"css/reset.css\" />
                    <link rel=\"stylesheet\" type=\"text/css\" href=\"css/style.css\" />
                    
                    <title>" . $htmlObj->getTitle() . "</title>
                
                </head>
                <body>
                    " . $htmlObj->getBody() . "
                    <p>" . $htmlObj->getFooter() . "</p>
                </body>
            </html>";
    }
}
