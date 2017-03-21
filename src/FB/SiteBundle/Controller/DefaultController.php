<?php

namespace FB\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $daystat = $em->getRepository('StatsBundle:DayStat')->findOneBy(array(
            'date' => new \DateTime(),
        ));


        $games = $em->getRepository('FootballBundle:Game')->findNextGames();

       


        return $this->render('default/index.html.twig', array(
            'games' => $games
        ));
    }
}
