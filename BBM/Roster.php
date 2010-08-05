<?php

namespace BBM;

use BBM\Team;

/**
 * A Roster for a season
 */
class Roster
{
    /**
     * A surrogate id for the table
     * @Id
     * @column(type="integer")
     * @GeneratedValue(strategy="SEQUENCE")
     * @SequenceGenerator(sequenceName="roster_seq", initialValue=1)
     * @var integer
     */
    private $roster_id;

    /**
     * @OneToMany(targetEntity="Team" mappedBy="rosters")
     */
    private $team;

    /**
     * @column(type="string" length="4")
     */
    private $year;
}
