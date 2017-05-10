<?php

namespace FB\SupportBundle\Controller;

use FB\SupportBundle\Entity\Ticket;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Ticket controller.
 *
 *
 */
class TicketController extends Controller
{
    /**
     * Lists all ticket entities.
     *
     * @Route("/", name="support_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tickets = $em->getRepository('SupportBundle:Ticket')->findUserTicket($em->getRepository('MemberBundle:User')->find($this->getUser()->getId()));

        return $this->render('ticket/index.html.twig', array(
            'tickets' => $tickets,
        ));
    }

    /**
     * close a ticketReply entity.
     *
     * @Route("/close/{id}", name="support_close")
     * @Method({"GET", "POST"})
     */
    public function closeAction(Request $request, Ticket $ticket)
    {
        if ($this->getUser()->getRank() == 'Admin'){
            $em = $this->getDoctrine()->getManager();

            $ticketClose = $em->getRepository('SupportBundle:Ticket')->find($ticket->getId());

            $ticketClose->setStatus('Fermé');

            $em->flush();

            return $this->redirectToRoute('support_index');
        }
        return $this->redirectToRoute('support_index');

    }

    /**
     * Creates a new ticket entity.
     *
     * @Route("/new", name="support_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $ticket = new Ticket();
        $form = $this->createForm('FB\SupportBundle\Form\TicketType', $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $ticket->setDate(new \DateTime('now'));
            $ticket->setStatus('Ouvert');
            $ticket->setUser($em->getRepository('MemberBundle:User')->find($this->getUser()->getId()));

            $em->persist($ticket);
            $em->flush($ticket);

            return $this->redirectToRoute('support_show', array('id' => $ticket->getId()));
        }

        return $this->render('ticket/new.html.twig', array(
            'ticket' => $ticket,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ticket entity.
     *
     * @Route("/{id}", name="support_show")
     * @Method("GET")
     */
    public function showAction(Ticket $ticket)
    {

        return $this->render('ticket/show.html.twig', array(
            'ticket' => $ticket,
            
        ));
    }



}
