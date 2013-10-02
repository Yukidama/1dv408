<?php

namespace view;


class DateAndTime {
    
    /**
     * @var \model\DateAndTime
     */
    private $dateAndTimeModel;
    
    /**
     * Constructor which takes a DateAndTime object
     */
    public function __construct(\model\DateAndTime $aDateAndTime) {
        $this->dateAndTimeModel = $aDateAndTime;
    }
    
    /**
     * Assembles a String with time and date
     * @return String;
     */
    public function getString() {
        
        $toEcho = $this->dateAndTimeModel->getWeekDay() .", den ";
        $toEcho .= $this->dateAndTimeModel->getDay() . " ";
        $toEcho .= $this->dateAndTimeModel->getMonth() . " år ";
        $toEcho .= $this->dateAndTimeModel->getYear() .". Klockan är ";
        $toEcho .= "[" . $this->dateAndTimeModel->getTime() . "]";
        
        return $toEcho;
    }
}