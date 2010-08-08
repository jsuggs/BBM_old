<?php

namespace BBM;

use BBM\Game;

/**
 * A play within a baseball game
 * @Entity
 * @Table(name="plays")
 */
class Play
{
    /**
     * The unique id for a play
     *
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="SEQUENCE")
     * @SequenceGenerator(sequenceName="roster_seq", initialValue=1)
     * @var integer
     */
    private $play_id;

    /**
     * The player at the plate during the play
     * @ManyToOne(targetEntity="Game", inversedBy="plays")
     * @JoinColumn(name="game_id", referencedColumnName="game_id")
     */
    private $game;

    /**
     * The inning in which the play occurred
     * @column(type="integer")
     * @var integer
     */
    private $inning;

    /**
     * The team the play is for
     * @ManyToOne(targetEntity="Team", inversedBy="plays")
     * @JoinColumn(name="teamAbbr", referencedColumnName="abbr")
     * @var BBM\Team
     */
    private $team;

    /**
     * The player who was at the plate when the play happened
     * @ManyToOne(targetEntity="Player", inversedBy="plays")
     * @JoinColumn(name="player_id", referencedColumnName="player_id")
     */
    private $player;

    /**
     * The pitchcount when the play occurred
     * @column(type="string")
     */
    private $pitchCount;

    /**
     * The pitches during the play
     * @column(type="string", length="")
     */
    private $pitches;

    /**
     * The even during the play
     * @column(type="string")
     */
    private $event;

    public function __construct()
    {
        //$this->setGame($game);
    }

    public function __toString()
    {
        return $this->play_id . ' ' . $this->team . ' ' . $this->player;
    }

    public function setTeam(Team $team)
    {
        $this->team = $team;
    }

    public function getTeam()
    {
        return $this->team;
    }

    public function setInning($value)
    {
        $this->inning = $value;
    }

    public function setGame(Game $game)
    {
        $this->game = $game;
        $game->addPlay($this);
    }

    public function getGame()
    {
        return $this->game;
    }

    public function setPlayer(Player $player)
    {
        $this->player = $player;
    }

    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Get the pitcher for the current play
     * @return BBM\Player
     * @todo
     */
    public function getCurrentPitcher()
    {
        return $this->player;
    }

    public function setPitchCount($value)
    {
        $this->pitchCount = $value;
    }

    public function setPitches($value)
    {
        $this->pitches = $value;
    }

    public function setEvent($value)
    {
        $this->event = $value;
    }

    public function getEvent()
    {
        return new Event($this->event);
    }
}
