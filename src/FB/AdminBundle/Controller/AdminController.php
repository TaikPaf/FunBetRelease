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

class AdminController extends Controller
{

    /**
     * @Route("/", name="admin_index")
     */
    public function indexAction(){
        return $this->render('admin/index.html.twig');
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
     * Displays a form to edit an existing bet entity.
     *
     * @Route("/bet/{id}/edit", name="admin_bet_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Bet $bet)
    {
        $editForm = $this->createForm('FB\BetBundle\Form\BetType', $bet);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bet_edit', array('id' => $bet->getId()));
        }

        return $this->render('bet/edit.html.twig', array(
            'bet' => $bet,
            'edit_form' => $editForm->createView(),
        ));
    }
}
