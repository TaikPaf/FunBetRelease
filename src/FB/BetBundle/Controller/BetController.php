<?php

namespace FB\BetBundle\Controller;

use FB\BetBundle\Entity\Bet;
use FB\BetBundle\Entity\Odd;
use FB\MemberBundle\Entity\User;
use FB\StatsBundle\Entity\DayStat;
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
    public function validationBetAction(){
        $em = $this->getDoctrine()->getManager();

        $matchs = $em->getRepository('FootballBundle:Game')->findGameInProgress();
        $data = json_decode(file_get_contents('http://api.football-data.org/v1/competitions/434/fixtures'),true);
        foreach ($data['fixtures'] as $datamatch){
            if  ($datamatch['status'] == "FINISHED" && $datamatch['date'] <= new \DateTime()){


                $hometeam = $em->getRepository('BetBundle:LinkName')->findNameTeam($datamatch['homeTeamName']);
                $awayteam = $em->getRepository('BetBundle:LinkName')->findNameTeam($datamatch['awayTeamName']);

                $game = $em->getRepository('FootballBundle:Game')->verificationGame($hometeam->getTeamNameBet(), $awayteam->getTeamNameBet());

                if ($game != null) {
                    echo "pouet";
                    $game->setHomeGoal($datamatch['result']['goalsHomeTeam']);
                    $game->setAwayGoal($datamatch['result']['goalsAwayTeam']);
                    $game->setEnded(true);
                    $game->setInProgress(false);
                    $bets = $em->getRepository('BetBundle:Bet')->findBetGame($game);

                        foreach($bets as $bet) {
                            $user = $em->getRepository('MemberBundle:User')->find($bet->getUser()->getId());

                            if ($game->getHomeGoal() > $game->getAwayGoal()){
                                if ($bet->getOdd()->getName() == 'homeTeam'){
                                    $user->setCredit($user->getCredit() + ($bet->getAmount() * $bet->getOdd()->getOdd()));
                                    $user->setNbBet($user->getNbBet() + 1);
                                    $user->setNbWin($user->getNbWin() + 1);
                                    //var_dump($user->getCredit());
                                }
                                else {
                                    $user->setCredit($user->getCredit() - ($bet->getAmount() * $bet->getOdd()->getOdd()));

                                    $user->setNbBet($user->getNbBet() + 1);
                                    if ($user->getNbWin() > 0){
                                        $user->setNbWin($user->getNbWin() - 1);
                                    }

                                }
                                $em->flush();
                            }
                            if ($game->getHomeGoal() == $game->getAwayGoal()){
                                if ($bet->getOdd()->getName() == 'Draw'){
                                    $user->setCredit($user->getCredit() + ($bet->getAmount() * $bet->getOdd()->getOdd()));
                                    $user->setNbBet($user->getNbBet() + 1);
                                    $user->setNbWin($user->getNbWin() + 1);
                                   // var_dump($user->getCredit());
                                }
                                else {
                                    $user->setCredit($user->getCredit() - ($bet->getAmount() * $bet->getOdd()->getOdd()));

                                    $user->setNbBet($user->getNbBet() + 1);

                                    if ($user->getNbWin() > 0){
                                        $user->setNbWin($user->getNbWin() - 1);
                                    }
                                   // var_dump($user->getCredit());
                                }
                                $em->flush();
                            }
                            if ($game->getHomeGoal() < $game->getAwayGoal()){
                                if ($bet->getOdd()->getName() == 'awayTeam'){
                                    $user->setCredit($user->getCredit() + ($bet->getAmount() * $bet->getOdd()->getOdd()));
                                    $user->setNbBet($user->getNbBet() + 1);
                                    $user->setNbWin($user->getNbWin() + 1);

                                }
                                else {
                                    $user->setCredit($user->getCredit() - ($bet->getAmount() * $bet->getOdd()->getOdd()));

                                    $user->setNbBet($user->getNbBet() + 1);

                                    if ($user->getNbWin() > 0){
                                        $user->setNbWin($user->getNbWin() - 1);
                                    }
                                   // var_dump($user->getCredit());
                                }
                                $em->flush();
                            }
                        }

                }


                
            }

        }
        die();

    }
    
}
