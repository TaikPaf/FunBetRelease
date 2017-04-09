<?php

namespace FB\SupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TicketReply
 *
 * @ORM\Table(name="ticket_reply")
 * @ORM\Entity(repositoryClass="FB\SupportBundle\Repository\TicketReplyRepository")
 */
class TicketReply
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity="FB\SupportBundle\Entity\Ticket", inversedBy="ticketReply")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ticket;

    /**
     * @ORM\ManyToOne(targetEntity="FB\MemberBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;


    public function getUser(){
        return $this->user;
    }

    public function setUser($user){
        $this->user = $user;
    }


    public function getTicket(){
        return $this->ticket;
    }

    public function setTicket($ticket){
        $this->ticket = $ticket;
    }
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return TicketReply
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return TicketReply
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }
}
