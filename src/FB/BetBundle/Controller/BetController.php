<?php

namespace FB\BetBundle\Controller;

use FB\BetBundle\Entity\Bet;
use FB\BetBundle\Entity\Odd;
use FB\FootballBundle\Entity\UpdateGame;
use FB\MemberBundle\Entity\User;
use FB\StatsBundle\Entity\DayStat;
use FB\StatsBundle\Entity\Jackpot;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

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
        //$form = $this->createForm('FB\BetBundle\Form\BetType', $bet);
        //$form->handleRequest($request);

        //if ($form->isSubmitted() && $form->isValid() && $this->getUser()->getCredit() >= $bet->getAmount()) {
            if($request->isXmlHttpRequest()) {
                $em = $this->getDoctrine()->getManager();
                $user = $em->getRepository('MemberBundle:User')->find($this->getUser());

                if ($request->request->get('mise') < $user->getCredit()){

                    //$bet->setAmount(abs($bet->getAmount()));
                    $val = $request->request->get('mise');

                    $bet->setAmount(abs($val));

                    $daystat = $em->getRepository('StatsBundle:DayStat')->FindOneBy(array('date' => new \DateTime()));
                    if ($daystat == null) {
                        $daystat = new DayStat();
                        $daystat->setDate(new \DateTime());
                        $daystat->setNbUser(0);
                    }



                    //Remplissage de Bet
                    $bet->setUser($user);
                    $bet->setDate(new \DateTime());
                    $bet->setOdd($odd);
                    $bet->setPotentialWin($bet->getAmount() * $odd->getOdd());
                    $bet->setIsWin(false);

                    //Ajout des stats en BDD
                    $daystat->setNbBet($daystat->getNbBet() + 1);
                    $daystat->setNbAmountBet($daystat->getNbAmountBet() + $bet->getAmount());


                    //Mise à jour du crédit joueur
                    $user->setCredit($user->getCredit() - $bet->getAmount());
                    $user->setNbBet($user->getNbBet() + 1);

                    //Gestion du Jackpot
                    $jackpot = $em->getRepository('StatsBundle:Jackpot')->findOneBy(array(),array('id' => 'DESC'));
                    if ($jackpot->getValue() + $bet->getAmount() >= 5000){
                        $jackpot->setIsdone(true);

                        $maxUser = $em->getRepository('MemberBundle:User')->findOneBy(array(),array('id'=>'DESC'));
                        $random = rand(1,$maxUser->getId());

                        $user = $em->getRepository('MemberBundle:User')->findOneBy(array('id' => $random));
                        $user->setCredit($user->getCredit() + 10);
                        $jackpot->setWinner($user);

                        $jackpotNew = new Jackpot();
                        $jackpotNew->setIsdone(false);
                        $calcul = 5000 - $jackpot->getValue();
                        $jackpotNew->setValue($bet->getAmount() - $calcul);
                        $jackpot->setValue(5000);

                        $em->persist($jackpotNew);

                    }
                    else {
                        $jackpot->setValue($jackpot->getValue() + $bet->getAmount());
                    }

                    $em->persist($bet);
                    $em->persist($daystat);
                    $em->flush();

                    $response = new Response();
                    $response->setStatusCode(Response::HTTP_OK);
                    return $response;
                }
                $response = new Response();
                $response->setStatusCode(Response::HTTP_UNAUTHORIZED);
                return $response;
            }

        }

        /*return $this->render('bet/new.html.twig', array(
            'bet' => $bet,
            'form' => $form->createView(),
        ));*/
    //}

    /**
     * Validation matchs - En cours
     *
     * @Route("/validation", name="bet_validation")
     * @Method({"GET", "POST"})
     */
     public function validationAction(){

         $Update = new UpdateGame();
         $em = $this->getDoctrine()->getManager();

         //Validation Ligue 1
         $Update->validationBet(434, $em);
         
         //Validation Premier League
         $Update->validationBet(426, $em);
         
         //validation Liga
         $Update->validationBet(436, $em);



         return $this->redirectToRoute('fb_site_default_index');
     }
    
}
