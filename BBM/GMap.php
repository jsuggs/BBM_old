<?php

/**
 * Google Maps Object
 *
 * @author Jonathon Suggs <jsuggs@murmp.com>
 */
class GMap
{
    /** @var Address */
    private $address;

    private const BASE_URL = 'http://maps.google.com/';

    /**
     * Constructor
     * @param Address
     */
    public function __construct(Address $address)
    {
        $this->address = $address;
    }

    public function getMap($width,$height)
    {
        $coords = $this->address->getCoordinates();

        return BASE_URL . {$coords.latitude} . ',' . {$coords.longtitiude};
    }
}
