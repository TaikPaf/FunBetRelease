<?php

namespace FB\SupportBundle\Controller;

use FB\SupportBundle\Entity\Ticket;
use FB\SupportBundle\Entity\TicketReply;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Ticketreply controller.
 *
 * @Route("reply")
 */
class TicketReplyController extends Controller
{
    /**
     * Creates a new ticketReply entity.
     *
     * @Route("/new/{id}", name="reply_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Ticket $ticket)
    {
        $ticketReply = new TicketReply();
        $form = $this->createForm('FB\SupportBundle\Form\TicketReplyType', $ticketReply);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $ticketReply->setTicket($ticket);

            $ticketReply->setDate(new \DateTime('now'));
            $ticketReply->setUser($em->getRepository('MemberBundle:User')->find($this->getUser()->getId()));

            $em->persist($ticketReply);
            $em->flush($ticketReply);

            return $this->redirectToRoute('support_index');
        }

        return $this->render('ticketreply/new.html.twig', array(
            'ticketReply' => $ticketReply,
            'form' => $form->createView(),
        ));
    }

    

}
