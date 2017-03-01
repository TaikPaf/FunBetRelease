<?php

namespace FB\BetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Odd
 *
 * @ORM\Table(name="odd")
 * @ORM\Entity(repositoryClass="FB\BetBundle\Repository\OddRepository")
 */
class Odd
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="odd", type="float")
     */
    private $odd;

    /**
     * @ORM\ManyToOne(targetEntity="FB\FootballBundle\Entity\Game")
     * @ORM\JoinColumn(nullable=false)
     */
    private $game;

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
     * Set name
     *
     * @param string $name
     * @return Odd
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set odd
     *
     * @param float $odd
     * @return Odd
     */
    public function setOdd($odd)
    {
        $this->odd = $odd;

        return $this;
    }

    /**
     * Get odd
     *
     * @return float 
     */
    public function getOdd()
    {
        return $this->odd;
    }

    /**
     * Set game
     *
     * @param string $game
     * @return Odd
     */
    public function setGame($game)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return string 
     */
    public function getGame()
    {
        return $this->game;
    }
}
