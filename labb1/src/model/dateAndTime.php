<?php

    namespace model;
    
    class dateAndTime {
        
        private $time;
        
        public function __construct($time = 0) {
            if ($time == 0) {
                $this->time = time();
            }
            else {
                $this->time = $time;
            }
        }
        
        //Få veckodag på svenska
        public function getWeekDay() {
            //Alla dagar på svenska
            $days = array("Söndag", "Måndag", "Tisdag", "Onsdag", "Torsdag", "Fredag", "Lördag");
            
            //Få dagens veckodag
            return $days[date('w', $this->time)];
        }
        
        //Få vilken dag det är i månaden
        public function getDay() {
            return date('j', $this->time);
        }
        
        public function getYear() {
            return date('Y', $this->time);
        }
        
        //Få månad på svenska
        public function getMonth() {
            $months = array("Januari", "Februari", "Mars", "April", "Maj", "Juni", "Juli", "Augusti", "Sepember", "Oktober", "November", "December");
            return $months[date('m', $this->time) - 1];
        }
        
        //Få fram tiden i tt:mm:ss-format
        public function getTime() {
            return date('H:i:s');
        }
    }
    
    

?>