<?php

namespace FB\AdminBundle\Controller;

use FB\FootballBundle\Entity\UpdateGame;
use FB\BetBundle\Entity\Bet;
use FB\BetBundle\Entity\Odd;
use FB\FootballBundle\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class AdminBetController extends Controller
{

    /**
     * @Route("/", name="admin_index")
     */
    public function indexAction(){

        $em = $this->getDoctrine()->getManager();

        $bets = $em->getRepository('BetBundle:Bet')->findBy(array(),array('id' => 'DESC'),20);

        return $this->render('admin/index.html.twig',array(
            'bets' => $bets
        ));
    }


    /**
     * @Route("/updategame", name="admin_update_game")
     */
    public function updateAction()
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

    /**
     * Finds and displays a bet entity.
     *
     * @Route("/bet/{id}", name="admin_bet_show")
     * @Method("GET")
     */
    public function showBetAction(Bet $bet)
    {
        return $this->render('bet/show.html.twig', array(
            'bet' => $bet,
        ));
    }

    /**
     * Finds and displays a bet entity.
     *
     * @Route("/bet/", name="admin_bet_show_all")
     * @Method("GET")
     */
    public function showAllBetAction()
    {
        $em = $this->getDoctrine()->getManager();
        $bets = $em->getRepository('BetBundle:Bet')->findBy(array(),array('id' => 'DESC'),20);
        
        return $this->render('admin/showBet.html.twig', array(
            'bets' => $bets,
        ));
    }


    /**
     * Displays a form to edit an existing bet entity.
     *
     * @Route("/bet/{id}/edit", name="admin_bet_edit")
     * @Method({"GET", "POST"})
     */
    public function editBetAction(Request $request, Bet $bet)
    {
        $editForm = $this->createForm('FB\BetBundle\Form\BetType', $bet);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->get('session')->getFlashBag()->set('success', 'Bet bien modifié');

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('bet/edit.html.twig', array(
            'bet' => $bet,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * cancel a bet.
     *
     * @Route("/bet/cancel/{id}", name="admin_bet_cancel")
     * @Method({"GET", "POST"})
     */
    public function cancelBetAction(Bet $bet){

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('MemberBundle:User')->find($bet->getUser());

        $user->setCredit($user->getCredit() + $bet->getAmount());

        if ($user->getNbBet() > 0){
            $user->setNbBet($user->getNbBet() - 1);
        }
        
        $em->remove($bet);
        $em->flush();

        return $this->redirectToRoute('admin_index');
    }
}
