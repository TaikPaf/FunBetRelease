<?php

namespace FB\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FB\BetBundle\Entity\Bet;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();

        $bet = new Bet();
        $form = $this->createForm('FB\BetBundle\Form\BetType', $bet);

        $nbUser = $em->getRepository('StatsBundle:DayStat')->findNbUser();
        $nbBet = $em->getRepository('StatsBundle:DayStat')->findNbBet();
        $AmountBet = $em->getRepository('StatsBundle:DayStat')->findNbAmount();
        

        $gamesLigue1 = $em->getRepository('FootballBundle:Game')->findNextGames('Ligue 1');
        $gamesAnglais = $em->getRepository('FootballBundle:Game')->findNextGames('Angl. Premier League');
        $gamesLiga = $em->getRepository('FootballBundle:Game')->findNextGames('Espagne Liga Primera');

        $users = $em->getRepository('MemberBundle:User')->findBy(array(), array('credit' => 'DESC'));


        return $this->render('default/index.html.twig', array(
            'gamesLigue1' => $gamesLigue1,
            'gamesLiga' => $gamesLiga,
            'gamesAnglais' => $gamesAnglais,
            'users' => $users,
            'nbUser' => $nbUser,
            'nbBet' => $nbBet,
            'AmountBet' => $AmountBet,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/pricing")
     */
    public function pricingAction()
    {


        return $this->render('default/pricing.html.twig', array(

        ));
    }
}
