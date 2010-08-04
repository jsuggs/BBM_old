<?php

namespace BBM;

/**
 * A ballpark
 *
 * @Entity
 * @Table(name="ballparks")
 */
class Ballpark
{
    /**
     * @Id
     * @column(type="string", length="5", name="ballpark_id")
     * @var string
     */
    private $ballpark_id;

    /**
     * @column(type="string", length="")
     */
    private $name;

    /**
     * @column(type="string", nullable="true", length="")
     */
    private $nickname;

    /**
     * @column(type="string", length="")
     */
    private $city;

    /**
     * @column(type="string", length="3")
     */
    private $state;

    /**
     * @column(type="date")
     */
    private $start;

    /**
     * @column(type="date", nullable="true")
     */
    private $end;

    /**
     * @column(type="string", nullable="true", length="3")
     */
    private $league;

    /**
     * @column(type="string", nullable="true", length="")
     */
    private $notes;
}
