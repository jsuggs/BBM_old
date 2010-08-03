<?php

/**
 * Generic Coordinate class
 *
 * @author Jonathon Suggs <jsuggs@murmp.com>
 * @version 1.0
 */

class Coordinates
{
    /** @var float */
    protected $latitiude;

    /** @var float */
    protected $longtitude;

    /** 
     * set latitude
     * @param float
     */
    public function setLatitude($value) {
        if (abs($value) > 60) {
            throw Exception('Invalid value passed for latitude');
        }

        $this->latitude = $value;
    }

    /** 
     * set longtitude
     * @param float
     */
    public function setLongtitude($value) {
        if (abs($value) > 60) {
            throw Exception('Invalid value passed for longtitude');
        }

        $this->longtitude = $value;
    }
}
