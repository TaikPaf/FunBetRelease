<?php

namespace FB\StatsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jackpot
 *
 * @ORM\Table(name="jackpot")
 * @ORM\Entity(repositoryClass="FB\StatsBundle\Repository\JackpotRepository")
 */
class Jackpot
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="value", type="float")
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="FB\MemberBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $winner;

    /**
     * @var bool
     *
     * @ORM\Column(name="isdone", type="boolean")
     */
    private $isdone;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set value
     *
     * @param float $value
     * @return Jackpot
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return float 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set winner
     *
     * @param string $winner
     * @return Jackpot
     */
    public function setWinner($winner)
    {
        $this->winner = $winner;

        return $this;
    }

    /**
     * Get winner
     *
     * @return string 
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * Set isdone
     *
     * @param boolean $isdone
     * @return Jackpot
     */
    public function setIsdone($isdone)
    {
        $this->isdone = $isdone;

        return $this;
    }

    /**
     * Get isdone
     *
     * @return boolean 
     */
    public function getIsdone()
    {
        return $this->isdone;
    }
}
