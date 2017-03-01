<?php

namespace FB\AdminBundle\Controller;

use FB\FootballBundle\Entity\UpdateGame;
use FB\BetBundle\Entity\Odd;
use FB\FootballBundle\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminController extends Controller
{
    /**
     * @Route("/updategame")
     */
    public function indexAction()
    {
        $Update = new UpdateGame();
        $Update->setDateUpdate(new \DateTime());

        //Liste des sports/ligues à update
        $Update->UpdateFootballLeague(2, 'Ligue 1', 'Ligue 1 2016/17', $this->getDoctrine()->getManager());
        $Update->setSuccessfull(true);



        $this->getDoctrine()->getManager()->persist($Update);
        $this->getDoctrine()->getManager()->flush();

        return $this->render('AdminBundle:Default:index.html.twig');
    }
}
