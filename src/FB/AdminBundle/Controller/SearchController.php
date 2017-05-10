<?php

namespace FB\AdminBundle\Controller;

use FB\FootballBundle\Entity\UpdateGame;
use FB\BetBundle\Entity\Bet;
use FB\BetBundle\Entity\Odd;
use FB\FootballBundle\Entity\Game;
use FB\MemberBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{
    


    /**
     * Finds and displays a bet entity.
     *
     * @Route("/search/user", name="admin_search_user")
     * @Method({"GET", "POST"})
     */
    public function searchUserAction(Request $request)
    {
        $user = new User();
        $editForm = $this->createForm('FB\MemberBundle\Form\UserType',$user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {


            $em = $this->getDoctrine()->getManager();
            $searchUser = $em->getRepository('MemberBundle:User')->findOneBy(array('username'=>$user->getUsername()));
            $bets = $em->getRepository('BetBundle:Bet')->findBy(array('user' => $searchUser),array('id'=>'DESC'),20);
            

            return $this->render('admin/UserShow.html.twig', array(
                'user' => $searchUser,
                'bets' => $bets
            ));
        }
        return $this->render('admin/searchUser.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
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

            $bet->setPotentialWin($bet->getAmount() * $bet->getOdd()->getOdd());
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
