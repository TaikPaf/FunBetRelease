<?php

namespace FB\BetBundle\Controller;

use FB\BetBundle\Entity\Bet;
use FB\BetBundle\Entity\Odd;
use FB\StatsBundle\Entity\DayStat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Bet controller.
 *
 */
class BetController extends Controller
{
    
    
    /**
     * Lists all bet entities.
     *
     * @Route("/", name="bet_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $bets = $em->getRepository('BetBundle:Bet')->findUserBet($this->getUser());

        return $this->render('bet/index.html.twig', array(
            'bets' => $bets,
        ));
    }

    /**
     * Creates a new bet entity.
     *
     * @Route("/new/{id}", name="bet_new")
     * @Method({"GET", "POST"})
     */
    public function newBetAction(Request $request, Odd $odd)
    {
        $bet = new Bet();
        $form = $this->createForm('FB\BetBundle\Form\BetType', $bet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $this->getUser()->getCredit() >= $bet->getAmount()) {
            $em = $this->getDoctrine()->getManager();
           
            $bet->setAmount(abs($bet->getAmount()));
            
            $daystat = $em->getRepository('StatsBundle:DayStat')->FindOneBy(array('date' => new \DateTime()));
            if ($daystat == null){
                $daystat = new DayStat();
                $daystat->setDate(new \DateTime());
                $daystat->setNbUser(0);
            }

            $user = $em->getRepository('MemberBundle:User')->find($this->getUser());
            //Remplissage de Bet
            $bet->setUser($user);
            $bet->setDate(new \DateTime());
            $bet->setOdd($odd);
            $bet->setPotentialWin($bet->getAmount() * $odd->getOdd());
            $bet->setIsWin(false);

            //Ajout des stats en BDD
            $daystat->setNbBet($daystat->getNbBet() + 1);
            $daystat->setNbAmountBet($daystat->getNbAmountBet() + 1);
            

            //Mise à jour du crédit joueur
            $user->setCredit($user->getCredit() - $bet->getAmount());

            $em->persist($bet);
            $em->persist($daystat);
            $em->flush();

            return $this->redirectToRoute('bet_show', array('id' => $bet->getId()));
        }

        return $this->render('bet/new.html.twig', array(
            'bet' => $bet,
            'form' => $form->createView(),
        ));
    }

    /**
     * Validation matchs - En cours
     *
     * @Route("/validation", name="bet_validation")
     * @Method({"GET", "POST"})
     */
    public function validationBetAction(){
        $em = $this->getDoctrine()->getManager();

        $matchs = $em->getRepository('FootballBundle:Game')->findGameInProgress();
        $data = file_get_contents('http://api.football-data.org/v1/competitions/434/fixtures');


        print_r($data);die();
    }
    
}
