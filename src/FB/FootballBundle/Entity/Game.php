<?php

namespace FB\FootballBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 *
 * @ORM\Table(name="game")
 * @ORM\Entity(repositoryClass="FB\FootballBundle\Repository\GameRepository")
 */
class Game
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
     * @ORM\Column(name="HomeTeam", type="string", length=255)
     */
    private $homeTeam;

    /**
     * @var string
     *
     * @ORM\Column(name="AwayTeam", type="string", length=255)
     */
    private $awayTeam;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateMatch", type="date")
     */
    private $dateMatch;

    /**
     * @var int
     *
     * @ORM\Column(name="HomeGoal", type="integer")
     */
    private $homeGoal;

    /**
     * @var int
     *
     * @ORM\Column(name="AwayGoal", type="integer")
     */
    private $awayGoal;

    /**
     * @var int
     *
     * @ORM\Column(name="Result", type="integer")
     */
    private $result;

    /**
     * @var bool
     *
     * @ORM\Column(name="Inprogress", type="boolean")
     */
    private $inprogress;

    /**
     * @var bool
     *
     * @ORM\Column(name="Ended", type="boolean")
     */
    private $ended;

    /**
     * @var string
     *
     * @ORM\Column(name="typeGame", type="string")
     */
    private $typeGame;


    public function getTypeGame(){
        return $this->typeGame;
    }
    
    public function setTypeGame($type){
        $this->typeGame = $type;
    }
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
     * Set homeTeam
     *
     * @param string $homeTeam
     * @return Game
     */
    public function setHomeTeam($homeTeam)
    {
        $this->homeTeam = $homeTeam;

        return $this;
    }

    /**
     * Get homeTeam
     *
     * @return string 
     */
    public function getHomeTeam()
    {
        return $this->homeTeam;
    }

    /**
     * Set awayTeam
     *
     * @param string $awayTeam
     * @return Game
     */
    public function setAwayTeam($awayTeam)
    {
        $this->awayTeam = $awayTeam;

        return $this;
    }

    /**
     * Get awayTeam
     *
     * @return string 
     */
    public function getAwayTeam()
    {
        return $this->awayTeam;
    }

    /**
     * Set dateMatch
     *
     * @param \DateTime $dateMatch
     * @return Game
     */
    public function setDateMatch($dateMatch)
    {
        $this->dateMatch = $dateMatch;

        return $this;
    }

    /**
     * Get dateMatch
     *
     * @return \DateTime 
     */
    public function getDateMatch()
    {
        return $this->dateMatch;
    }

    /**
     * Set homeGoal
     *
     * @param integer $homeGoal
     * @return Game
     */
    public function setHomeGoal($homeGoal)
    {
        $this->homeGoal = $homeGoal;

        return $this;
    }

    /**
     * Get homeGoal
     *
     * @return integer 
     */
    public function getHomeGoal()
    {
        return $this->homeGoal;
    }

    /**
     * Set awayGoal
     *
     * @param integer $awayGoal
     * @return Game
     */
    public function setAwayGoal($awayGoal)
    {
        $this->awayGoal = $awayGoal;

        return $this;
    }

    /**
     * Get awayGoal
     *
     * @return integer 
     */
    public function getAwayGoal()
    {
        return $this->awayGoal;
    }

    /**
     * Set result
     *
     * @param integer $result
     * @return Game
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result
     *
     * @return integer 
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set inprogress
     *
     * @param boolean $inprogress
     * @return Game
     */
    public function setInprogress($inprogress)
    {
        $this->inprogress = $inprogress;

        return $this;
    }

    /**
     * Get inprogress
     *
     * @return boolean 
     */
    public function getInprogress()
    {
        return $this->inprogress;
    }

    /**
     * Set ended
     *
     * @param boolean $ended
     * @return Game
     */
    public function setEnded($ended)
    {
        $this->ended = $ended;

        return $this;
    }

    /**
     * Get ended
     *
     * @return boolean 
     */
    public function getEnded()
    {
        return $this->ended;
    }

    public function __construct()
    {
        $this->setAwayGoal(0);
        $this->setAwayTeam('');
        $this->setDateMatch(new \DateTime());
        $this->setEnded(false);
        $this->setInprogress(false);
        $this->setHomeGoal(0);
        $this->setHomeTeam('');
        $this->setResult(0);
    }
}
