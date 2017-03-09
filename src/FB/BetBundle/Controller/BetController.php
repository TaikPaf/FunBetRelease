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
    public function newAction(Request $request, Odd $odd)
    {
        $bet = new Bet();
        $form = $this->createForm('FB\BetBundle\Form\BetType', $bet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

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
     * Deletes a bet entity.
     *
     * @Route("/{id}", name="bet_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Bet $bet)
    {
        $form = $this->createDeleteForm($bet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bet);
            $em->flush($bet);
        }

        return $this->redirectToRoute('bet_index');
    }

    /**
     * Creates a form to delete a bet entity.
     *
     * @param Bet $bet The bet entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Bet $bet)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bet_delete', array('id' => $bet->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
