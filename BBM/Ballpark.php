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
     * @column(type="date", nullable="true")
     */
    private $dateopen;

    /**
     * @column(type="date", nullable="true")
     */
    private $dateclose;

    /**
     * @column(type="string", nullable="true", length="3")
     */
    private $league;

    /**
     * @column(type="string", nullable="true", length="")
     */
    private $notes;

    public function __construct($id)
    {
        $this->setId($id);
    }

    public function __toString()
    {
        if (!isset($this->dateOpen)) {
            die($this->ballpark_id);
        }
        return $this->ballpark_id . ' ' . $this->name . ' ' . $this->dateOpen->format('Y-m-d');
    }

    public function setId($value)
    {
        $id = trim($value);

        if (!is_string($id) || strlen($id) > 5) {
            throw new \Exception('Invalid ID passed: ' . $id);
        }

        $this->ballpark_id = $id;
    }

    public function setName($value)
    {
        $this->name = $value;
    }

    public function setNickname($value)
    {
        $this->nickname = $value;
    }

    public function setCity($value)
    {
        $this->city = $value;
    }

    public function setState($value)
    {
        $this->state = $value;
    }

    public function setDateOpen($value)
    {
        try {
            $this->dateOpen = new \DateTime($value);
        }
        catch (\Exception $e)
        {
            die($value);
        }
    }

    public function setDateClose($value)
    {
        if (isset($value) && strlen($value) > 0) {
            $this->dateClose = new \DateTime($value);
        }
    }

    public function setLeague($value)
    {
        $this->league = $value;
    }

    public function setNotes($value)
    {
        $this->notes = $value;
    }
}
