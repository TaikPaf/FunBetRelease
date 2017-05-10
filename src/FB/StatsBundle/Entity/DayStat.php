<?php

namespace FB\StatsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DayStat
 *
 * @ORM\Table(name="day_stat")
 * @ORM\Entity(repositoryClass="FB\StatsBundle\Repository\DayStatRepository")
 */
class DayStat
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="nbUser", type="integer")
     */
    private $nbUser;

    /**
     * @var int
     *
     * @ORM\Column(name="nbBet", type="integer")
     */
    private $nbBet;

    /**
     * @var float
     *
     * @ORM\Column(name="nbAmountBet", type="float")
     */
    private $nbAmountBet;


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
     * Set date
     *
     * @param \DateTime $date
     * @return DayStat
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set nbUser
     *
     * @param integer $nbUser
     * @return DayStat
     */
    public function setNbUser($nbUser)
    {
        $this->nbUser = $nbUser;

        return $this;
    }

    /**
     * Get nbUser
     *
     * @return integer 
     */
    public function getNbUser()
    {
        return $this->nbUser;
    }

    /**
     * Set nbBet
     *
     * @param integer $nbBet
     * @return DayStat
     */
    public function setNbBet($nbBet)
    {
        $this->nbBet = $nbBet;

        return $this;
    }

    /**
     * Get nbBet
     *
     * @return integer 
     */
    public function getNbBet()
    {
        return $this->nbBet;
    }

    /**
     * Set nbAmountBet
     *
     * @param float $nbAmountBet
     * @return DayStat
     */
    public function setNbAmountBet($nbAmountBet)
    {
        $this->nbAmountBet = $nbAmountBet;

        return $this;
    }

    /**
     * Get nbAmountBet
     *
     * @return float 
     */
    public function getNbAmountBet()
    {
        return $this->nbAmountBet;
    }

    
}
