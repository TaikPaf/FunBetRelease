<?php


namespace FB\MemberBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var float
     *
     * @ORM\Column(name="credit", type="float", length=255)
     */
    private $credit;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbwin", type="integer", length=255)
     */
    private $nbWin;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbBet", type="integer", length=255)
     */
    private $nbBet;

    /**
     * @var string
     *
     * @ORM\Column(name="rank", type="string", length=255)
     */
    private $rank;


    public function getCredit(){
        return $this->credit;
    }
    public function setCredit($cred){
        $this->credit = $cred;
    }

    public function getNbWin(){
        return $this->nbWin;
    }
    public function setNbWin($nb){
        $this->nbWin = $nb;
    }

    public function getNbBet(){
        return $this->nbBet;
    }
    public function setNbBet($nb){
        $this->nbBet = $nb;
    }

    public function getRank(){
        return $this->rank;
    }
    public function setRank($rank){
        $this->rank = $rank;
    }


    public function __construct()
    {
        parent::__construct();
        $this->credit = 100;
        $this->nbBet = 0;
        $this->nbWin = 0;
        $this->rank = "Membre";
    }
}