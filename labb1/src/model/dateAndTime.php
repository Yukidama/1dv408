<?php

namespace model;

class DateAndTime {
    
    /**
     * @var Int
     */
    private $time;
    
    /**
     * Constructor which takes time, set to now if not set
     * @param Int $aTime;
     */
    public function __construct($aTime = 0) {
        if ($aTime == 0) {
            $this->time = time();
        }
        else {
            $this->time = $aTimetime;
        }
    }
    
    /**
     * returns weekday in swedish
     * @return String
     */
    public function getWeekDay() {
        //Alla dagar på svenska
        $days = array("Söndag",
                      "Måndag",
                      "Tisdag",
                      "Onsdag",
                      "Torsdag",
                      "Fredag",
                      "Lördag");
        
        return $days[date('w', $this->time)];
    }
    
    /**
     * returns day
     * @return Int
     */
    public function getDay() {
        return date('j', $this->time);
    }
    
    /**
     * returns year
     * @return Int;
     */
    public function getYear() {
        return date('Y', $this->time);
    }
    
    /**
     * returns month
     * @return String
     */
    public function getMonth() {
        $months = array("Januari",
                        "Februari",
                        "Mars",
                        "April",
                        "Maj",
                        "Juni",
                        "Juli",
                        "Augusti",
                        "Sepember",
                        "Oktober",
                        "November",
                        "December");
        return $months[date('m', $this->time) - 1];
    }
    
    /**
     * returns time in hh:mm:ss-format
     * @return String
     */
    public function getTime() {
        return date('H:i:s');
    }
}