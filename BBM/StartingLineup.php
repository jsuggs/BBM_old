<?php

namespace BBM;

use BBM\Team;

/**
 * A starting lneup
 *
 * @Entity
 * @Table(name="starting_lineups")
 */
class StartingLineup
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="SEQUENCE")
     * @SequenceGenerator(sequenceName="startinglineup_seq", initialValue=1)
     * @var integer
     */
    private $startinglineup_id;

    /** 
     * The pitcher
     * @ManyToOne(targetEntity="Player")
     * @JoinColumn(name="player_id", referencedColumnName="player_id")
     * @var BBM\Player 
     */
    private $pitcher;

    /**
     * Set the Starting Pitcher
     * @return Pitcher
     */
    public function getPitcher()
    {
        return $this->pitcher;
    }

    /**
     * Set the starting pitcher
     * @param Pitcher
     */
    public function setPitcher(Player $pitcher)
    {
        $this->pitcher = $pitcher;
    }
}
