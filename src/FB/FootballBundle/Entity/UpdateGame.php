<?php

namespace FB\FootballBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FB\BetBundle\Entity\Odd;
use FB\FootballBundle\Entity\Game;

/**
 * UpdateGame
 *
 * @ORM\Table(name="update_game")
 * @ORM\Entity(repositoryClass="FB\FootballBundle\Repository\UpdateGameRepository")
 */
class UpdateGame
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
     * @ORM\Column(name="dateUpdate", type="date")
     */
    private $dateUpdate;

    /**
     * @var bool
     *
     * @ORM\Column(name="successfull", type="boolean")
     */
    private $successfull;


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
     * Set dateUpdate
     *
     * @param \DateTime $dateUpdate
     * @return UpdateGame
     */
    public function setDateUpdate($dateUpdate)
    {
        $this->dateUpdate = $dateUpdate;

        return $this;
    }

    /**
     * Get dateUpdate
     *
     * @return \DateTime 
     */
    public function getDateUpdate()
    {
        return $this->dateUpdate;
    }

    /**
     * Set successfull
     *
     * @param boolean $successfull
     * @return UpdateGame
     */
    public function setSuccessfull($successfull)
    {
        $this->successfull = $successfull;

        return $this;
    }

    /**
     * Get successfull
     *
     * @return boolean 
     */
    public function getSuccessfull()
    {
        return $this->successfull;
    }

    public function UpdateFootballLeague($ligueInt, $ligueName, $delimiter, $em){

        $xmlparis = simplexml_load_file("http://xml.cdn.betclic.com/odds_fr.xml");

        foreach ($xmlparis->sport[0]->event[$ligueInt]->match as $currentMatch) {
            //cr�ation des objets
            $CurrentGame = new Game();
            $HomeTeamOdd = new Odd();
            $AwayTeamOdd = new Odd();
            $DrawOdd = new Odd();

            //Test du delimiter pour fin des paris à enregistrer
            if ($currentMatch['name'] != "$delimiter") {
                $equipes = explode(' - ', $currentMatch['name']);

                //Ajout des équipes
                $CurrentGame->setHomeTeam($equipes[0]);
                $CurrentGame->setAwayTeam($equipes[1]);

                //R�cup�ration de la comp�tition
                $CurrentGame->setTypeGame($ligueName);


                //Gestion date match
                $date = new \DateTime(str_replace('T', ' ', $currentMatch['start_date']), new \DateTimeZone('Europe/Paris'));

                $CurrentGame->setDateMatch($date);


                //var_dump($currentMatch->bets->bet);
                foreach ($currentMatch->bets->bet as $bet) {
                    if ($bet['code'] == 'Ftb_Mr3') {
                        //echo $bet['code'];
                        foreach ($bet->choice as $choice) {
                            //var_dump($choice);die();
                            if ($choice['name'] == '%1%') {
                                $HomeTeamOdd->setOdd((float)$choice['odd'][0]);
                                $HomeTeamOdd->setGame($CurrentGame);
                                $HomeTeamOdd->setName('homeTeam');
                                $CurrentGame->addOdds($HomeTeamOdd);
                               // var_dump($HomeTeamOdd);die();
                            }
                            if ($choice['name'] == 'Nul') {
                                $DrawOdd->setOdd((float)$choice['odd'][0]);
                                $DrawOdd->setGame($CurrentGame);
                                $DrawOdd->setName('Draw');
                                $CurrentGame->addOdds($DrawOdd);
                            }
                            if ($choice['name'] == '%2%') {
                                $AwayTeamOdd->setOdd((float)$choice['odd'][0]);
                                $AwayTeamOdd->setGame($CurrentGame);
                                $AwayTeamOdd->setName('awayTeam');
                                $CurrentGame->addOdds($AwayTeamOdd);
                            }
                        }


                    }
                }
                //var_dump($CurrentGame);
                //var_dump($em->getRepository('FootballBundle:Game')->verificationGame($CurrentGame));die();
                if ($em->getRepository('FootballBundle:Game')->verificationGame($CurrentGame->getHomeTeam(), $CurrentGame->getAwayTeam()) == null){


                    //changer ordre

                    $em->persist($CurrentGame);

                    $em->persist($HomeTeamOdd);
                    $em->persist($DrawOdd);
                    $em->persist($AwayTeamOdd);
                    
                    $em->flush();

                }


            }
        }
    }
}
