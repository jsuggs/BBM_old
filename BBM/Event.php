<?php

namespace BBM;

class Event
{
    /**
     * The string of the Retrosheet event code
     */
    private $event;

    /**
     * Did this even result in an out
     * @var boolean
     */
    private $out;

    /**
     * The number of runs scored during this event
     * @var integer
     */
    private $runsScored;

    /**
     * The text of the outcome of this event
     * @var string
     */
    private $outcome;

    public function __construct($event)
    {
        $this->setEvent($event);
    }

    public function setEvent($event)
    {
        // Initialize vars
        $this->event = $event;
        $this->runsScored = 0;
        $this->out = true;
        $this->outcome = 'unknown';

        // Break up the event string into parts
        // Note, it may just be a single part
        $parts = explode('/', $this->event);

        // Set the play 
        $play = (sizeof($parts)) ? $parts[0]: $this->event;

        $firstchar = substr($play,0,1);

        if (is_numeric($play)) {
            $this->out = true;
            $this->outcome =  'fly_out';
        }

        switch ($firstchar)
        {
            case 'K':
                $this->out = true;
                $this->outcome = 'strikeout';
                break;
            case 'S':
                $this->out = false;
                $this->outcome = 'single';
                break;
            case 'D':
                $this->out = false;
                $this->outcome =  'double';
                break;
            case 'T':
                $this->out = false;
                $this->outcome = 'triple';
                break;
        }
    }

    public function isOut()
    {
        return $this->out;
    }

    public function getRunsScored()
    {
        return $this->runsScored;
    }

    public function getOutcome()
    {
        return $this->outcome;
    }
}
