<?php

namespace FB\BetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bet
 *
 * @ORM\Table(name="bet")
 * @ORM\Entity(repositoryClass="FB\BetBundle\Repository\BetRepository")
 */
class Bet
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
     * @var string
     *
     * @ORM\Column(name="user", type="string", length=255)
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="odd", type="string", length=255)
     */
    private $odd;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float")
     */
    private $amount;

    /**
     * @var float
     *
     * @ORM\Column(name="PotentialWin", type="float")
     */
    private $potentialWin;

    /**
     * @var bool
     *
     * @ORM\Column(name="isWin", type="boolean")
     */
    private $isWin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;


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
     * Set user
     *
     * @param string $user
     * @return Bet
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set odd
     *
     * @param string $odd
     * @return Bet
     */
    public function setOdd($odd)
    {
        $this->odd = $odd;

        return $this;
    }

    /**
     * Get odd
     *
     * @return string 
     */
    public function getOdd()
    {
        return $this->odd;
    }

    /**
     * Set amount
     *
     * @param float $amount
     * @return Bet
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set potentialWin
     *
     * @param float $potentialWin
     * @return Bet
     */
    public function setPotentialWin($potentialWin)
    {
        $this->potentialWin = $potentialWin;

        return $this;
    }

    /**
     * Get potentialWin
     *
     * @return float 
     */
    public function getPotentialWin()
    {
        return $this->potentialWin;
    }

    /**
     * Set isWin
     *
     * @param boolean $isWin
     * @return Bet
     */
    public function setIsWin($isWin)
    {
        $this->isWin = $isWin;

        return $this;
    }

    /**
     * Get isWin
     *
     * @return boolean 
     */
    public function getIsWin()
    {
        return $this->isWin;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Bet
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
}
