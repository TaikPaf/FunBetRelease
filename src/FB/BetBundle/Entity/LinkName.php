<?php

namespace FB\BetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LinkName
 *
 * @ORM\Table(name="link_name")
 * @ORM\Entity(repositoryClass="FB\BetBundle\Repository\LinkNameRepository")
 */
class LinkName
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
     * @ORM\Column(name="teamNameBet", type="string", length=255)
     */
    private $teamNameBet;

    /**
     * @var string
     *
     * @ORM\Column(name="teamNameApi", type="string", length=255)
     */
    private $teamNameApi;


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
     * Set teamNameBet
     *
     * @param string $teamNameBet
     * @return LinkName
     */
    public function setTeamNameBet($teamNameBet)
    {
        $this->teamNameBet = $teamNameBet;

        return $this;
    }

    /**
     * Get teamNameBet
     *
     * @return string 
     */
    public function getTeamNameBet()
    {
        return $this->teamNameBet;
    }

    /**
     * Set teamNameApi
     *
     * @param string $teamNameApi
     * @return LinkName
     */
    public function setTeamNameApi($teamNameApi)
    {
        $this->teamNameApi = $teamNameApi;

        return $this;
    }

    /**
     * Get teamNameApi
     *
     * @return string 
     */
    public function getTeamNameApi()
    {
        return $this->teamNameApi;
    }
}
