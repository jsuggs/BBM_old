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
     * The short text of the outcome of this event
     * @var string
     */
    private $outcome;

    /**
     * Detailed description of play
     * @var string
     */
    private $description;

    /**
     * Did the runner reach base
     * @boolean;
     */
    private $reachBase;

    /**
     * Was the event a complete play
     * @var boolean
     */
    private $isPlay;

    public function __construct($event)
    {
        // Initialize vars
        $this->runsScored = 0;
        $this->out = true;
        $this->walk = false;
        $this->isPlay = true;
        $this->reachBase = false;
        $this->outcome = 'unknown';
        $this->description = $event . ' = ';

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

        $this->parseModifiers($modifiers);
        $this->parseRunners($runners);
        $this->parsePlay($play);


        if ($this->outcome == 'unknown') {
            echo 'Unknown event: ' . $event . "\n";
        }
    }

    public function parseModifiers($modifiers) {
        foreach ($modifiers as $modifier) {
            switch ($modifier)
            {
                case 'B':     
                    $this->description .= 'bunt; ';
                    break;
                case 'BF':    
                    $this->description .= 'fly ball bunt; ';
                    break;
                case 'BG':    
                    $this->description .= 'ground ball bunt; ';
                    break;
                case 'BGDP':  
                    $this->description .= 'bunt grounded into double play; ';
                    break;
                case 'BL':    
                    $this->description .= 'line drive bunt; ';
                    break;
                case 'BP':    
                    $this->description .= 'bunt pop up; ';
                    break;
                case 'BPDP':  
                    $this->description .= 'bunt popped into double play; ';
                    break;
                case 'BR':    
                    $this->description .= 'runner hit by batted ball; ';
                    break;
                case 'C':     
                    $this->description .= 'called third strike; ';
                    break;
                case 'DP':    
                    $this->description .= 'unspecified double play; ';
                    break;
                case 'E$':    
                    $this->description .= 'error on $; ';
                    break;
                case 'F':    
                    $this->description .= 'fly; ';
                    break;
                case 'FDP':   
                    $this->description .= 'fly ball double play; ';
                    break;
                case 'FL':    
                    $this->description .= 'foul; ';
                    break;
                case 'FO':    
                    $this->description .= 'force out; ';
                    break;
                case 'G':     
                    $this->description .= 'ground ball; ';
                    break;
                case 'GDP':   
                    $this->description .= 'ground ball double play; ';
                    break;
                case 'GTP':   
                    $this->description .= 'ground ball triple play; ';
                    break;
                case 'INT':   
                    $this->description .= 'interference; ';
                    break;
                case 'L':     
                    $this->description .= 'line drive; ';
                    break;
                case 'LDP':   
                    $this->description .= 'lined into double play; ';
                    break;
                case 'LTP':   
                    $this->description .= 'lined into triple play; ';
                    break;
                case 'P':     
                    $this->description .= 'pop fly; ';
                    break;
                case 'R$':    
                    $this->description .= 'relay throw from the initial fielder to $ with no out made; ';
                    break;
                case 'SF':    
                    $this->description .= 'sacrifice fly; ';
                    break;
                case 'SH':    
                    $this->description .= 'sacrifice hit (bunt); ';
                    break;
                case 'TH':    
                    $this->description .= 'throw; ';
                    break;
                case 'TH%':   
                    $this->description .= 'throw to base %; ';
                    break;
                case 'TP':    
                    $this->description .= 'unspecified triple play; ';
                    break;
            }
        }
    }

    public function parseRunners($runners)
    {
        if (sizeof($runners) == 0) {
            return;
        }
        foreach ($runners as $runner) 
        {
            $bases = explode('-',$runner);
            
            if (!isset($bases[1]))
            {
                continue;
            }

            $start = $bases[0];
            $finish = substr($bases[1],0,1);

            if ($start !== $finish) {
                $this->description .= 'Runner advanced from ';
                switch ($start) {
                    case 1:
                        $this->description .= 'first';
                        break;
                    case 2:
                        $this->description .= 'second';
                        break;
                    case 3:
                        $this->description .= 'third';
                        break;
                }
                $this->description .= ' to ';
                switch ($finish) {
                    case 1:
                        $this->description .= 'first';
                        break;
                    case 2:
                        $this->description .= 'second';
                        break;
                    case 3:
                        $this->description .= 'third';
                        break;
                    case 'H':
                        $this->description .= 'home';
                        $this->runsScored++;
                        break;
                }
                $this->description .= '; ';
            }
        }
    }

    public function parsePlay($play)
    {
        $firstchar = substr($play,0,1);

        if (is_numeric($play)) {
            $this->out = true;
            $this->outcome =  'fly_out';
            $this->description .= 'Fly ball to ' . $this->positionName($play);
        }

        switch ($firstchar)
        {
            case 'K':
                $this->out = true;
                $this->outcome = 'strikeout';
                break;
            case 'S':
                $this->out = false;
                $this->reachBase = true;
                $this->outcome = 'single';
                break;
            case 'D':
                $this->out = false;
                $this->reachBase = true;
                $this->outcome =  'double';
                break;
            case 'T':
                $this->out = false;
                $this->reachBase = true;
                $this->outcome = 'triple';
                break;
            case 'W':
            case 'I':
                $this->out = false;
                $this->reachBase = true;
                $this->walk = true;
                $this->outcome = 'walk';
                break;
            case 'H':
                $this->out = false;
                $this->reachBase = true;
                $this->outcome = 'home run';
                $this->runsScored = 1;
                break;
            case 'E':
                $this->out = false;
                $this->reachBase = true;
                $this->outcome = 'Error';
                break;
        }

        $twochars = substr($play,0,2);

        if (is_numeric($twochars)) {
            $this->out = true;
            $this->outcome = 'Double Play';
        }

        switch($twochars)
        {
            case 'NP':
                $this->out = false;
                $this->outcome = 'No Play';
                $this->isPlay = false;
                break;
            case 'PO':
                $this->out = true;
                $this->outcome = 'Picked Off Runner';
                $this->isPlay = false;
                break;
        }
    }

    public function isOut()
    {
        return $this->out;
    }

    public function isPlay()
    {
        return $this->isPlay;
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

    public function getDescription()
    {
        return $this->description;
    }

    public function getReachedBase()
    {
        return $this->reachBase;
    }

    public function positionName($position)
    {
        switch($position)
        {
            case 1:
                return 'Pitcher';
            case 2:
                return 'Catcher';
            case 3:
                return 'First Base';
            case 4:
                return 'Second Base';
            case 5:
                return 'Third Base';
            case 6:
                return 'Shortstop';
            case 7:
                return 'Left Field';
            case 8:
                return 'Center Field';
            case 9:
                return 'Right Field';
            default:
                return 'Unknown position: ' . $position;
        }
    }
}
