<?php

    namespace view;
    
    require_once("src/model/dateAndTime.php");
    
    class dateAndTime {
        
        public function getString(\model\dateAndTime $dateAndTime) {
            
            //Fixa så att svenskt datum skrivs ut -- Måndag, den 8 Juli år 2013. Klockan är [10:59:21]
            
            $toEcho = $dateAndTime->getWeekDay() .", den ";
            
            $toEcho .= $dateAndTime->getDay() . " ";
            
            $toEcho .= $dateAndTime->getMonth() . " år ";
            
            $toEcho .= $dateAndTime->getYear() .". Klockan är ";
            
            $toEcho .= "[" . $dateAndTime->getTime() . "]";
            
            return $toEcho;
        }
    }
    
    

?>