<?php

namespace App\Entity;

use App\Repository\ParticipantsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParticipantsRepository::class)
 */
class Participants
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mail_participant;

  /**
     * @ORM\ManyToOne(targetEntity=Campaign::class, inversedBy="participants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $campaign_id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_anonymous;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMailParticipant(): ?string
    {
        return $this->mail_participant;
    }

    public function setMailParticipant(string $mail_participant): self
    {
        $this->mail_participant = $mail_participant;

        return $this;
    }

    public function getCampaignId(): ?Campaign
    {
        return $this->campaign_id;
    }

    public function setCampaignId(?Campaign $campaign_id): self
    {
        $this->campaign_id = $campaign_id;

        return $this;
    }

    public function getIsAnonymous(): ?bool
    {
        return $this->is_anonymous;
    }

    public function setIsAnonymous(bool $is_anonymous): self
    {
        $this->is_anonymous = $is_anonymous;

        return $this;
    }
}
