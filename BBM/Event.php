<?php

namespace BBM;

class Event
{
    /**
     * Did this even result in an out
     * @var boolean
     */
    private $out;

    /**
     * Was this a walk
     * @var boolean
     */
    private $walk;

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
        // Initialize vars
        $this->runsScored = 0;
        $this->out = true;
        $this->walk = false;
        $this->outcome = 'unknown';

        // Get the positions of the different segmeents
        $modifierPos = strpos($event,'/');
        $runnerPos = strpos($event,'.');

        if ($modifierPos === false) {
            $modifierStr = '';

            // If no modifier and runner info, then event is only the basic play information
            if ($runnerPos === false) {
                $play = $event;
                $runnerStr = '';
            }
            else {
                $play = substr($event,0,$runnerPos);
                $runnerStr = substr($event,$runnerPos + 1);
            }
        }
        else {
            $play = substr($event,0,$modifierPos);
            if ($runnerPos === false) {
                $runnerStr = '';
                $modifierStr = substr($event,$modifierPos + 1);
            }
            else {
                $runnerStr = substr($event,$runnerPos + 1);
                $modifierStr = substr($event,$modifierPos + 1,($runnerPos - $modifierPos) - 1);
            }
        }

        // Break up the modifiers and runner string
        $modifiers = explode('/', $modifierStr);
        $runners = explode(';', $runnerStr);

        $this->parsePlay($play);
        $this->parseModifiers($modifiers);
        $this->parseRunners($runners);


        if ($this->outcome == 'unknown') {
            echo 'Unknown event: ' . $event . "\n";
        }
    }

    public function parseModifiers($modifiers) {
        foreach ($modifiers as $modifier) {
        }
    }

    public function parseRunners($runners)
    {
        //
    }

    public function parsePlay($play)
    {
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
            case 'W':
            case 'I':
                $this->out = false;
                $this->walk = true;
                $this->outcome = 'walk';
                break;
            case 'H':
                $this->out = false;
                $this->outcome = 'home run';
                $this->runsScored = 1; //TODO
            case 'E':
                $this->out = false;
                $this->outcome = 'Error';
                break;
        }

        if ($play === 'NP') {
            $this->out = false;
            $this->outcome = 'No Play';
        }
    }

    public function isOut()
    {
        return $this->out;
    }

    public function isWalk()
    {
        return $this->walk;
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
